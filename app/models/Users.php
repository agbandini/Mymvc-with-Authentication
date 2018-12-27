<?php

namespace App\Models;

use \PDO;

class Users {

    protected $conn;
    public $usersDtCount = 0;
    public $groupsDtCount = 0;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
    }

    public function getUsersDt($searchVal = '', $orderBy = '', $len = 1, $start = 0, $cols) {
        $users = array();
        $user_groups = $this->getUserGroups();

        $sql = "SELECT * FROM usr_users u "
                . "INNER JOIN usr_user_profiles p ON u.user_id = p.user_id "
                . "INNER JOIN usr_user_groups g ON u.group_id = g.group_id "
                . "WHERE 1=1";

        $sql_where = "";
        if ($searchVal != '') {
            $sql_where = " AND (p.ragione_sociale LIKE '%" . $searchVal . "%')";
            $sql_where .= " OR (p.cognome LIKE '%" . $searchVal . "%')";
            $sql_where .= " OR (u.user_email LIKE '%" . $searchVal . "%')";
            $sql_where .= " OR (g.group_name LIKE '%" . $searchVal . "%')";
        }

        //$sql_order = ' ORDER BY u.user_id ';
        $sql_order = " ORDER BY " . $cols[$orderBy[0]['column']]['name'] . " " . $orderBy[0]['dir'];
        if ($orderBy != "") {
            //$sql_order = ' ORDER BY ' . $orderBy;
        }

        switch ($this->conn->getAttribute(constant("PDO::ATTR_DRIVER_NAME"))) {
            case 'sqlsrv':
                $sql_offset = ' OFFSET (' . $start . ') ROWS';
                $sql_limit = ' FETCH first ' . $len . ' ROWS ONLY';
                $query = $sql . $sql_where . $sql_order . $sql_offset . $sql_limit;
                break;
            case 'mysql':
                $sql_limit = ' LIMIT ' . $len;
                $sql_offset = ' OFFSET ' . $start;
                $query = $sql . $sql_where . $sql_order . $sql_limit . $sql_offset;
                break;
        }

        //var_dump($sql . $sql_where . $sql_order . $sql_offset . $sql_limit);

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        } catch (\PDOException $e) {
            $res = array('code' => $e->getCode(), 'desc' => $e->getMessage());
        } catch (Exception $e) {
            $res = array('code' => $e->getCode(), 'desc' => $e->getMessage());
        }

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        $this->usersDtCount = $stmt->rowCount();

        while ($row = $stmt->fetch()) {
            $gruppi = [];
            foreach ($user_groups as $ugp) {
                if ($row['user_id'] == $ugp['rug_userid']) {
                    array_push($gruppi, $ugp['group_name']);
                }
            }
            $row['user_groups'] = implode(', ', $gruppi);
            $users[] = $row;
        }
        $stmt = NULL;
        return $users;
    }

    public function getGroupsDt($searchVal = '', $orderBy = '', $len = 1, $start = 0, $cols){
        
        $groups = array();

        $sql = "SELECT * FROM usr_user_groups WHERE 1=1";

        $sql_where = "";
        if ($searchVal != '') {
            $sql_where = " AND (group_name LIKE '%" . $searchVal . "%')";
            $sql_where .= " OR (group_description LIKE '%" . $searchVal . "%')";
        }

        //$sql_order = ' ORDER BY u.user_id ';
        $sql_order = " ORDER BY " . $cols[$orderBy[0]['column']]['name'] . " " . $orderBy[0]['dir'];
        if ($orderBy != "") {
            //$sql_order = ' ORDER BY ' . $orderBy;
        }

        switch ($this->conn->getAttribute(constant("PDO::ATTR_DRIVER_NAME"))) {
            case 'sqlsrv':
                $sql_offset = ' OFFSET (' . $start . ') ROWS';
                $sql_limit = ' FETCH first ' . $len . ' ROWS ONLY';
                $query = $sql . $sql_where . $sql_order . $sql_offset . $sql_limit;
                break;
            case 'mysql':
                $sql_limit = ' LIMIT ' . $len;
                $sql_offset = ' OFFSET ' . $start;
                $query = $sql . $sql_where . $sql_order . $sql_limit . $sql_offset;
                break;
        }

        //var_dump($sql . $sql_where . $sql_order . $sql_offset . $sql_limit);

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
        } catch (\PDOException $e) {
            $res = array('code' => $e->getCode(), 'desc' => $e->getMessage());
        } catch (Exception $e) {
            $res = array('code' => $e->getCode(), 'desc' => $e->getMessage());
        }

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        $this->groupsDtCount = $stmt->rowCount();

        while ($row = $stmt->fetch()) {
            $groups[] = $row;
        }
        $stmt = NULL;
        return $groups;        
        
    }

    public function getUserGroups($userId = false) {
        $sql = null;
        if ($userId) {
            $sql = "SELECT * FROM usr_rel_usergroups "
                    . "INNER JOIN usr_user_groups ON rug_groupid = group_id "
                    . "LEFT JOIN usr_rel_userana ON rug_userid = rua_userid "
                    . "WHERE rug_userid = ?";
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $userId, PDO::PARAM_INT);
        } else {
            $sql = "SELECT * FROM usr_rel_usergroups "
                    . "INNER JOIN usr_user_groups ON rug_groupid = group_id "
                    . "LEFT JOIN usr_rel_userana ON rug_userid = rua_userid";
            $stmt = $this->conn->prepare($sql);
        }

        try {
            $stmt->execute();
        } catch (\PDOException $exc) {
            $res = array('code' => $exc->getCode(), 'desc' => array($exc->getMessage()));
        } catch (Exception $exc) {
            $res = array('code' => $exc->getCode(), 'desc' => array($exc->getMessage()));
        }

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $out_data = array();
        $out_data = $stmt->fetchAll();
        $stmt = NULL;
        return $out_data;
    }

    public function getBlankUser() {

        $sql = "SELECT COLUMN_NAME as column_name 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE (TABLE_NAME = 'usr_users') 
            OR (TABLE_NAME = 'usr_user_profiles')
            OR (TABLE_NAME = 'usr_user_groups')";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt->execute()) {
            die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $user = array();
        while ($row = $stmt->fetch()) {
            $user[$row['column_name']] = NULL;
        }

        $stmt = NULL;
        return $user;
    }

    public function getBlankGroup() {

        $sql = "SELECT COLUMN_NAME as column_name 
            FROM INFORMATION_SCHEMA.COLUMNS 
            WHERE (TABLE_NAME = 'usr_user_groups')";

        $stmt = $this->conn->prepare($sql);

        if (!$stmt->execute()) {
            die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $user = array();
        while ($row = $stmt->fetch()) {
            $user[$row['column_name']] = NULL;
        }

        $stmt = NULL;
        return $user;
    }
    
    public function getUser($user_id) {

        $stmt = $this->conn->prepare("SELECT * FROM usr_users u "
                . "INNER JOIN usr_user_profiles p ON u.user_id = p.user_id "
                . "INNER JOIN usr_user_groups g ON u.group_id = g.group_id WHERE u.user_id = ? ");

        $stmt->bindParam(1, $user_id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $user = [];
        while ($row = $stmt->fetch()) {
            $user = $row;
        }
        $stmt = NULL;
        return $user;
    }

    public function getGroups() {

        $stmt = $this->conn->prepare("SELECT * FROM usr_user_groups");
        if (!$stmt->execute()) {
            die("Execute failed: (" . $stmt->errno . ") " . $stmt->error);
        }
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $stmt->fetch()) {
            $groups[] = $row;
        }
        $stmt = NULL;
        return $groups;
    }

    public function createUser($user_data) {

        $email = filter_var($user_data['email'], FILTER_SANITIZE_EMAIL);
        $password = filter_var($user_data['password'], FILTER_SANITIZE_STRING);

        $user_approved = 0; //questo campo cambia quando attivato via mail
        $user_status = 0; //user status 0 account incompleto 1 account completo

        $user_data['user_created'] = date('Y-m-d\TH:i:s');
        $code = sha1(md5(microtime()));

        try {
            $stmt = $this->conn->prepare("INSERT INTO usr_users (group_id, user_email, user_status, user_approved, user_created, activation_code) VALUES (?,?,?,?,?,?)");
            $stmt->bindParam(1, $user_data['group_id'], PDO::PARAM_INT);
            $stmt->bindParam(2, $email, PDO::PARAM_STR);
            $stmt->bindParam(3, $user_status, PDO::PARAM_INT);
            $stmt->bindParam(4, $user_approved, PDO::PARAM_INT);
            $stmt->bindParam(5, $user_data['user_created'], PDO::PARAM_STR);
            $stmt->bindParam(6, $code, PDO::PARAM_STR);
            $stmt->execute();
        } catch (\PDOException $exc) {
            if ($exc->getCode() === "23000") {
                $res = (object) ['result' => false, 'msg' => 'Email gia presente in archivio'];
            }
        } catch (Exception $exc) {
            $res = (object) ['result' => false, 'msg' => $exc->getMessage()];
        }

        if (empty($res)) {
            $user_id = $this->conn->lastInsertId();

            $hashid = hash('sha1', $user_id);
            //$password viene passata gia codifcata alla funzione
            $password = $hashid . $password;

            $stmt = $this->conn->prepare("UPDATE usr_users SET user_password = ? WHERE user_id = ?");
            $stmt->bindParam(1, $password, PDO::PARAM_STR);
            $stmt->bindParam(2, $user_id, PDO::PARAM_INT);

            if (!$stmt->execute()) {
                $res = (object) ['result' => false, 'msg' => $stmt->error];
            }

            $aut_privacy = 1;
            $stmt = $this->conn->prepare("INSERT INTO usr_user_profiles (user_id, nome, cognome, telefono, cellulare) VALUES (?,?,?,?,?)");
            $stmt->bindParam(1, $user_id, PDO::PARAM_INT);
            $stmt->bindParam(2, $user_data['nome'], PDO::PARAM_STR);
            $stmt->bindParam(3, $user_data['cognome'], PDO::PARAM_STR);
            $stmt->bindParam(4, $user_data['telefono'], PDO::PARAM_STR);
            $stmt->bindParam(5, $user_data['cellulare'], PDO::PARAM_STR);

            if (!$stmt->execute()) {
                $res = (object) ['result' => false, 'msg' => $stmt->error];
            }
            $profile_id = $this->conn->lastInsertId();
        }

        if (empty($res)) {
            $res = (object) ['result' => true, 'user_id' => $user_id, 'profile_id' => $profile_id];
        }

        return $res;
    }

    public function updateUserPassword($user_id, $newPwd) {

        $password = filter_var($newPwd, FILTER_SANITIZE_STRING);
        $hashid = hash('sha1', $user_id);
        $encPwd = hash('sha512', $password);

        $finalpwd = $hashid . $encPwd;

        try {
            $stmt = $this->conn->prepare("UPDATE usr_users SET user_password = ? WHERE user_id = ?");
            $stmt->bindParam(1, $finalpwd, PDO::PARAM_STR);
            $stmt->bindParam(2, $user_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\PDOException $e) {
            $res = array('code' => $e->getCode(), 'desc' => $e->getMessage());
        } catch (Exception $e) {
            $res = array('code' => $e->getCode(), 'desc' => $e->getMessage());
        }

        if (empty($res)) {
            $res = array('code' => 'ok', 'desc' => '');
        }

        return $res;
    }

    public function updateUserEmail($user_id, $newMail) {

        $email = filter_var($newMail, FILTER_SANITIZE_EMAIL);
        $res = [];
        try {
            $stmt = $this->conn->prepare("UPDATE usr_users SET user_email = ? WHERE user_id = ?");
            $stmt->bindParam(1, $email, PDO::PARAM_STR);
            $stmt->bindParam(2, $user_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\PDOException $e) {
            $res = (object) ['result' => false, 'msg' => $e->getMessage()];
            if ($e->getCode() === "23000") {
                $res = (object) ['result' => false, 'msg' => 'Email gia presente in archivio'];
            }
        } catch (Exception $e) {
            $res = (object) ['result' => false, 'msg' => $e->getMessage()];
        }

        if (empty($res)) {
            $res = (object) ['result' => true];
        }

        return $res;
    }

    public function updateUserData($user_id, $user_data) {

        try {
            $stmt = $this->conn->prepare("UPDATE usr_users SET group_id = ?, user_status = ?, user_approved = ? WHERE user_id = ?");
            $stmt->bindParam(1, $user_data['group_id'], PDO::PARAM_INT);
            $stmt->bindParam(2, $user_data['user_status'], PDO::PARAM_INT);
            $stmt->bindParam(3, $user_data['user_approved'], PDO::PARAM_INT);
            $stmt->bindParam(4, $user_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\PDOException $e) {
            $res = (object) ['result' => false, 'msg' => $e->getMessage()];
        } catch (Exception $e) {
            $res = (object) ['result' => false, 'msg' => $e->getMessage()];
        }

        try {
            $stmt = $this->conn->prepare("UPDATE usr_user_profiles SET nome = ?, cognome = ?, telefono = ?, cellulare = ? WHERE user_id = ?");
            $stmt->bindParam(1, $user_data['nome'], PDO::PARAM_STR);
            $stmt->bindParam(2, $user_data['cognome'], PDO::PARAM_STR);
            $stmt->bindParam(3, $user_data['telefono'], PDO::PARAM_STR);
            $stmt->bindParam(4, $user_data['cellulare'], PDO::PARAM_STR);
            $stmt->bindParam(5, $user_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\PDOException $e) {
            $res = (object) ['result' => false, 'msg' => $e->getMessage()];
        } catch (Exception $e) {
            $res = (object) ['result' => false, 'msg' => $e->getMessage()];
        }

        if (empty($res)) {
            $res = (object) ['result' => true];
        }

        return $res;
    }
    
    public function deleteUser($userId) {

        $sql = "DELETE FROM usr_users WHERE user_id = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(1, $userId, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            $res = (object) ['result' => false, 'msg' => $stmt->error];
        }

        $stmt = NULL;
        if (empty($res)) {
            $res = (object) ['result' => true];
        }
        return $res;
    }
    
    public function createGroup($groupdata) {
        $res = [];
        
        $sql = "INSERT INTO usr_user_groups (group_description, group_name) VALUES (?,?)";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $groupdata['group_description'], PDO::PARAM_STR);
            $stmt->bindParam(2, $groupdata['group_name'], PDO::PARAM_STR);
            $stmt->execute();
        } catch (\PDOException $exc) {
            $res = (object) ['result' => false, 'msg' => $exc->getMessage()];
        } catch (Exception $exc) {
            $res = (object) ['result' => false, 'msg' => $exc->getMessage()];
        }

        $stmt = NULL;

        if (empty($res)) {
            $res = (object) ['result' => true, 'group_id' => $this->conn->lastInsertId()];
        }

        return $res;
    }
    
    public function getGroup($group_id) {
        
        $res = array();
        $stmt = $this->conn->prepare("SELECT * FROM usr_user_groups WHERE group_id = ?");
        $stmt->bindParam(1, $group_id, PDO::PARAM_INT);

        if (!$stmt->execute()) {
            $res = (object) ['result' => false, 'msg' => $stmt->error];
        }

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() <> 0) {
            $res = $stmt->fetch();
        }
        return $res;
    }    
    
    public function editGroup($group_id, $groupdata) {

        $sql = "UPDATE usr_user_groups SET group_description = ?, group_name = ? WHERE group_id = ?";

        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->bindParam(1, $groupdata['group_description'], PDO::PARAM_STR);
            $stmt->bindParam(2, $groupdata['group_name'], PDO::PARAM_STR);
            $stmt->bindParam(3, $group_id, PDO::PARAM_INT);
            $stmt->execute();
        } catch (\PDOException $exc) {
            $res = (object) ['result' => false, 'msg' => $exc->getMessage()];
        } catch (Exception $exc) {
            $res = (object) ['result' => false, 'msg' => $exc->getMessage()];
        }

        $stmt = NULL;

        if (empty($res)) {
            $res = (object) ['result' => true];
        }

        return $res;
    }    

}

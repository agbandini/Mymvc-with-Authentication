<?php

namespace App\Models;

use PDO;

/**
 * Description of Authentication
 *
 * @author gmk
 */
class Authentication {

    protected $conn;
    protected $session;
    protected $Email;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
        $this->session = new \App\Models\Session();
        $this->Email = new \App\Models\Email();
    }

    private function token() {
        return md5('studioartifex' . $_SERVER['REMOTE_ADDR'] . $_SERVER['HTTP_USER_AGENT']);
    }

    public function doLogin(string $email, string $password, bool $remember = false) {

        try {
            $stmt = $this->conn->prepare("SELECT * FROM usr_users WHERE user_email = ?");
            $stmt->bindParam(1, $email, PDO::PARAM_STR);
            $stmt->execute();
        } catch (\PDOException $e) {
            $ret = array('code' => $e->getCode(), 'desc' => $e->getMessage());
        } catch (Exception $e) {
            $ret = array('code' => $e->getCode(), 'desc' => $e->getMessage());
        }

        if ($stmt->rowCount() <> 0) {
            $row = $stmt->fetch(PDO::FETCH_OBJ);

            //controllo necessario se l'utente non ha ancora attivato il suo account
            if ((int) $row->user_status == 1 || (int) $row->user_approved == 1) {
                $hashid = hash('sha1', $row->user_id);
                //$password viene passata gia codifcata alla funzione
                $password = $hashid . $password;

                try {
                    $sql = "SELECT * FROM usr_users u "
                            . "INNER JOIN usr_user_profiles p ON u.user_id = p.user_id "
                            . "INNER JOIN usr_user_groups g ON u.group_id = g.group_id "
                            . "WHERE u.user_email = ? AND u.user_password = ? AND u.user_status = 1 AND u.user_approved = 1";
                    $stmt = $this->conn->prepare($sql);
                    $stmt->bindParam(1, $email, PDO::PARAM_STR);
                    $stmt->bindParam(2, $password, PDO::PARAM_STR);
                    $stmt->execute();
                } catch (\PDOException $e) {
                    $ret = array('code' => $e->getCode(), 'desc' => $e->getMessage());
                } catch (Exception $e) {
                    $ret = array('code' => $e->getCode(), 'desc' => $e->getMessage());
                }

                if ($stmt->rowCount() <> 0) {
                    $row = $stmt->fetch(PDO::FETCH_OBJ);

                    $oldSessId = session_id();
                    session_regenerate_id(true);
                    $newSessId = session_id();

                    $this->session->set('token', $this->token());
                    $this->session->set('logged_in', true);

                    //var_dump($row);
                    $user_id = $row->user_id;
                    $group_id = $row->group_id;

                    $this->session->set('user_id', $user_id);
                    $this->session->set('group_id', $group_id);
                    $this->session->set('group_name', $row->group_name);
                    $this->session->set('profile_id', $row->profile_id);
                    $this->session->set('user_email', $row->user_email);
                    $this->session->set('user_status', $row->user_status);
                    $this->session->set('con_gestionale', $row->con_gestionale);
                    $this->session->set('last_ip', $row->last_ip);
                    $this->session->set('ragione_sociale', $row->ragione_sociale);
                    $this->session->set('nome_url', $row->nome_url);
                    $this->session->set('nome', $row->nome);
                    $this->session->set('cognome', $row->cognome);
                    $this->session->set('email_profilo', $row->email);
                    $this->session->set('cellulare', $row->cellulare);

                    try {
                        $sql = "UPDATE usr_users SET last_login = ?, last_ip = ? WHERE user_id = ?";
                        $last_login = date('Y-m-d\TH:i:s');
                        ;
                        $stmt = $this->conn->prepare($sql);
                        $stmt->bindParam(1, $last_login, PDO::PARAM_STR);
                        $stmt->bindParam(2, $_SERVER['REMOTE_ADDR'], PDO::PARAM_STR);
                        $stmt->bindParam(3, $user_id, PDO::PARAM_INT);
                        $stmt->execute();
                    } catch (\PDOException $e) {
                        $ret = array('code' => $e->getCode(), 'desc' => $e->getMessage());
                    } catch (Exception $e) {
                        $ret = array('code' => $e->getCode(), 'desc' => $e->getMessage());
                    }

                    if ($remember) {
                        //$this->remember_user($user_id, $email, $password);
                    }

                    $ret = (object) [
                                'stato' => 1,
                                'msg' => "Authorized access"
                    ];
                } else {
                    $ret = (object) [
                                'stato' => 0,
                                'msg' => "La password inserita non è valida."
                    ];
                }
            } else {
                $ret = (object) [
                            'stato' => 2,
                            'msg' => "Utente non attivo"
                ];
            }
        } else {
            $ret = (object) [
                        'stato' => 0,
                        'msg' => "La mail inserita non è presente in archivio."
            ];
        }

        $stmt = NULL;

        return $ret;
    }

    public function doLogout() {
        unset($_COOKIE['remember_code']);
        setcookie('remember_code', '', time() - 1, '/');
        $this->session->destroy();
    }
    
    private function getRandomPassword() {
        $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
        return implode($pass); //turn the array into a string
    }    

    public function newPassword($email) {

        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        try {
            $stmt = $this->conn->prepare("SELECT * FROM `usr_users` WHERE `user_email` = ? LIMIT 1");
            $stmt->bindParam(1, $email, PDO::PARAM_STR);
            $stmt->execute();
        } catch (\PDOException $e) {
            $ret = array('stato' => 0, 'msg' => $e->getMessage());
        } catch (Exception $e) {
            $ret = array('stato' => 0, 'msg' => $e->getMessage());
        }

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if ($stmt->rowCount() <> 0) {
            $row = $stmt->fetch();
            $hashid = hash('sha1', $row['user_id']);
            $pwd = $this->getRandomPassword();
            $encPwd = hash('sha512', $pwd);
            $finalpwd = $hashid . $encPwd;

            try {
                $stmt = $this->conn->prepare("UPDATE `usr_users` SET `user_password` = ? WHERE `user_id` = ?");
                $stmt->bindParam(1, $finalpwd, PDO::PARAM_STR);
                $stmt->bindParam(2, $row['user_id'], PDO::PARAM_INT);
                $stmt->execute();
            } catch (\PDOException $e) {
                $ret = array('stato' => 0, 'msg' => $e->getMessage());
            } catch (Exception $e) {
                $ret = array('stato' => 0, 'msg' => $e->getMessage());
            }

            $this->Email->pwdResetMail($email, $pwd);

            $ret = (object)['stato' => 0];
        } else {
            $ret = (object)[
                'stato' => 0,
                'msg' => "La mail inserita non è presente in archivio."
            ];
        }
        return $res;
    }

}

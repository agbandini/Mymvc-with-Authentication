<?php

namespace App\Controllers;

use \PDO;

class UsersController {

    protected $layout = 'layout/index.tpl.php';
    public $customcss = '<link rel="stylesheet" href="/themes/admin/plugins/datatables/dataTables.bootstrap.css">';
    public $customjs = '<script src="/themes/admin/plugins/datatables/jquery.dataTables.js"></script>'
            . '<script src="/themes/admin/plugins/datatables/dataTables.bootstrap.min.js"></script>';
    private $usersjs = '<script src="/resources/admin/js/users.js"></script>';
    private $groupsjs = '<script src="/resources/admin/js/groups.js"></script>';
    public $content = 'Gmk';
    public $userFullName = Null;
    protected $conn;
    protected $Sess;
    protected $Auth;
    protected $Err;
    protected $User;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
        $this->Auth = new \App\Models\Authentication($conn);
        $this->Err = new \App\Models\Errors();
        $this->Sess = new \App\Models\Session();
        $this->User = new \App\Models\Users($conn);
        $this->userFullName = $this->Sess->get('nome') . ' ' . $this->Sess->get('cognome');
    }

    public function display() {
        require $this->layout;
    }

    public function users() {
        $this->customjs .= $this->usersjs;
        $this->content = view('users');
    }

    public function groups() {
        $this->customjs .= $this->groupsjs;
        $this->content = view('groups');
    }

    public function newUser() {
        $Err = $this->Err;
        $user = $this->User->getBlankUser();
        $groups = $this->User->getGroups();
        $this->content = view('editUser', compact('user', 'groups', 'Err'));
    }

    public function editUser($userId) {
        $Err = $this->Err;
        $user = $this->User->getUser($userId);
        $groups = $this->User->getGroups();
        $this->content = view('editUser', compact('user', 'groups', 'Err'));
    }

    public function editGroup($groupId) {
        $Err = $this->Err;
        $group = $this->User->getGroup($groupId);
        $this->content = view('editGroup', compact('group', 'Err'));
    }

    public function newGroup() {
        $Err = $this->Err;
        $group = $this->User->getBlankGroup();
        $this->content = view('editGroup', compact('group', 'Err'));
    }

    public function save() {

        $datiUtente = [
            'group_id' => filter_input(INPUT_POST, 'gruppo_utente', FILTER_SANITIZE_NUMBER_INT),
            'user_status' => filter_input(INPUT_POST, 'stato', FILTER_SANITIZE_NUMBER_INT),
            'user_approved' => filter_input(INPUT_POST, 'mail_verificata', FILTER_SANITIZE_NUMBER_INT),
            'nome' => filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING),
            'cognome' => filter_input(INPUT_POST, 'cognome', FILTER_SANITIZE_STRING),
            'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
            'telefono' => filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING),
            'cellulare' => filter_input(INPUT_POST, 'cellulare', FILTER_SANITIZE_STRING),
            'password' => filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING),
            'confirm_password' => filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING),
        ];

        $err = \App\Helpers\Validation::valUsers($datiUtente, TRUE);
        if (!empty($err)) {
            redirect('/users/new');
        } else {
            $datiUtente['password'] = hash('sha512', $datiUtente['password']);
            $out = $this->User->createUser($datiUtente);
            if ($out->result) {
                redirect('/users');
            } else {
                $this->Err->set_error($out->msg);
                redirect('/users/new');
            }
        }
    }

    public function saveGroup() {

        $datiGroup = [
            'group_description' => filter_input(INPUT_POST, 'group_description', FILTER_SANITIZE_STRING),
            'group_name' => filter_input(INPUT_POST, 'group_name', FILTER_SANITIZE_STRING),
        ];

        $err = \App\Helpers\Validation::valGroup($datiGroup);
        if (!empty($err)) {
            redirect('/groups/new');
        } else {
            $out = $this->User->createGroup($datiGroup);
            if ($out->result) {
                redirect('/groups');
            } else {
                $this->Err->set_error($out->msg);
                redirect('/groups/new');
            }
        }
    }

    public function store() {

        $user_id = filter_input(INPUT_POST, 'user_id', FILTER_SANITIZE_NUMBER_INT);
        $profile_id = filter_input(INPUT_POST, 'profile_id', FILTER_SANITIZE_NUMBER_INT);

        $gruppo_origine = filter_input(INPUT_POST, 'gruppo_old', FILTER_SANITIZE_NUMBER_INT);

        $datiUtente = [
            'group_id' => filter_input(INPUT_POST, 'gruppo_utente', FILTER_SANITIZE_NUMBER_INT),
            'user_status' => filter_input(INPUT_POST, 'stato', FILTER_SANITIZE_NUMBER_INT),
            'user_approved' => filter_input(INPUT_POST, 'mail_verificata', FILTER_SANITIZE_NUMBER_INT),
            'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
            'nome' => filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_STRING),
            'cognome' => filter_input(INPUT_POST, 'cognome', FILTER_SANITIZE_STRING),
            'telefono' => filter_input(INPUT_POST, 'telefono', FILTER_SANITIZE_STRING),
            'cellulare' => filter_input(INPUT_POST, 'cellulare', FILTER_SANITIZE_STRING),
            'password' => filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING),
            'confirm_password' => filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_STRING)
        ];

        $pwd = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        if (!empty($pwd)) {
            $err = \App\Helpers\Validation::valUsers($datiUtente, TRUE);
            if (empty($err)) {
                $this->User->updateUserPassword($user_id, $pwd);
            }
        } else {
            $err = \App\Helpers\Validation::valUsers($datiUtente, FALSE);
        }

        if (!empty($err)) {
            redirect("/users/$user_id/edit");
        } else {
            $old_email = filter_input(INPUT_POST, 'old_email', FILTER_SANITIZE_EMAIL);

            if ($datiUtente['email'] !== $old_email) {
                $out = $this->User->updateUserEmail($user_id, $datiUtente['email']);
                if (!$out->result) {
                    $this->Err->set_error($out->msg);
                    redirect("/users/$user_id/edit");
                }
            }

            $out = $this->User->updateUserData($user_id, $datiUtente);
            if ($out->result) {
                redirect('/users');
            } else {
                $this->Err->set_error($out->msg);
                redirect("/users/$user_id/edit");
            }
        }
    }

    public function storeGroup() {
        
        $group_id = filter_input(INPUT_POST, 'group_id', FILTER_SANITIZE_NUMBER_INT);

        $datiGroup = [
            'group_description' => filter_input(INPUT_POST, 'group_description', FILTER_SANITIZE_STRING),
            'group_name' => filter_input(INPUT_POST, 'group_name', FILTER_SANITIZE_STRING),
        ];

        $err = \App\Helpers\Validation::valGroup($datiGroup);
        if (!empty($err)) {
            redirect("/groups/$group_id/edit");
        } else {
            $out = $this->User->editGroup($group_id, $datiGroup);
            if ($out->result) {
                redirect('/groups');
            } else {
                $this->Err->set_error($out->msg);
                redirect("/groups/$group_id/edit");
            }
        }
    }

}

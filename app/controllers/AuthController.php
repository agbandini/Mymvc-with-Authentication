<?php

namespace App\Controllers;

use \PDO;

class AuthController {

    protected $layout = 'layout/login.tpl.php';
    public $content = 'Hidran Arias';
    protected $conn;
    protected $Auth;
    protected $Err;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
        $this->Auth = new \App\Models\Authentication($conn);
        $this->Err = new \App\Models\Errors();
    }

    public function display() {
        require $this->layout;
    }

    public function login() {
        $Err = $this->Err;
        $this->content = view('login', compact('login', 'Err'));
    }

    public function logout() {
        $this->Auth->doLogout();
        redirect('/');
    }

    public function doLogin() {

        $login_email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        $password = filter_input(INPUT_POST, 'hashpwd', FILTER_SANITIZE_STRING);

        $remember = false;
        filter_input(INPUT_POST, 'remember', FILTER_SANITIZE_NUMBER_INT) == 1 ? $remember = true : $remember = false;

        if (!empty($login_email) && !empty($password)) {
            $out = $this->Auth->doLogin($login_email, $password, $remember);

            if ($out->stato != 1) {
                $this->Err->set_error($out->msg);
            }
        }
        redirect('/');
    }

    public function lostPassword() {
        $Err = $this->Err;
        $this->content = view('lostPassword', compact('Err'));
    }

    public function passwordRemind() {
        
        $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
        if (empty($email)){
            $this->Err->set_error('Verificare indirizzo Email');
            redirect('/lostpassword');
        }
        $out = $this->Auth->newPassword($email);
        $this->Err->set_error('Ti è stata inviata una mail con la nuova password di accesso, da questo momento in poi potrai accedere con la nuova password.');
        redirect('/login');
       

    }

}

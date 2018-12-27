<?php

namespace App\Controllers;

use \PDO;


/**
 * Description of PostController
 *
 * @author hidran@gmail.com
 */
class MainController {

    protected $layout = 'layout/index.tpl.php';
    public $customcss = '';
    public $customjs = '';
    public $content = '';
    public $userFullName = Null;
    protected $conn;
    protected $Sess;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
        $this->Sess = new \App\Models\Session();
        $this->userFullName = $this->Sess->get('nome') . ' ' . $this->Sess->get('cognome');
    }

    public function display() {
        require $this->layout;
    }

    public function mainPage() {
        $this->content = 'ciao';
    }

   


}

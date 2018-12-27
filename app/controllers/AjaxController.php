<?php

namespace App\Controllers;

use \PDO;
use App\Models\Users;

/**
 * Description of AjaxController
 *
 * @author gmk
 */
class AjaxController {

    protected $layout = 'layout/ajax.tpl.php';
    public $content = '';
    protected $conn;
    protected $Users;
    protected $Session;

    public function __construct(PDO $conn) {
        $this->conn = $conn;
        $this->Users = new \App\Models\Users($conn);
        $this->Session = new \App\Models\Session();
    }

    public function display() {
        require $this->layout;
    }

    public function allUsers() {
        $datidg = array();
        $users = $this->Users->getUsersDt($_POST['search']['value'], $_POST['order'], $_POST['length'], $_POST['start'], $_POST['columns']);

        foreach ($users as $usr) {

            $tools = "<div class='btn-group'>                        
                        <a title='Modifica' href='/users/$usr[user_id]/edit' class='btn btn-default'><i class='fa fa-edit'></i></a>
                        <button title='Elimina' " . ($usr['user_id'] == $this->Session->get('user_id') ? "disabled" : "") . " type='button' onclick='deleteUser($usr[user_id])' class='btn btn-default'><i class='fa fa-trash'></i></button>
                        </div>";

            $datidg[] = array(
                'ragione_sociale' => $usr['ragione_sociale'],
                'referente' => $usr['nome'] . ' ' . $usr['cognome'],
                'email' => $usr['user_email'],
                'gruppo' => $usr['group_name'],
                'stato' => "<button type='button' id='_stato_$usr[user_id]' value='$usr[user_id]_$usr[user_status]' onclick='ckstato(this);' class='btn btn-default'><i class='fa " . ($usr['user_status'] == 1 ? "fa-check text-green" : "fa-square text-red") . "'></i></button>",
                'user_approved' => "<button type='button' value='$usr[user_id]_$usr[user_approved]' id='_autorizzato_$usr[user_id]' onclick='ckautorizzato(this);' class='btn btn-default'><i class='fa " . ($usr['user_approved'] == 1 ? "fa-check text-green" : "fa-square text-red") . "'></i></button>",
                'gestione' => $tools
            );
        }
        $totale_records = $this->Users->usersDtCount;
        $utentidg = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $totale_records,
            "recordsFiltered" => $totale_records,
            "colums" => array('ragione_sociale', 'referente', 'email', 'gruppo', 'stato', 'user_approved'),
            "data" => $datidg,
        ];

        $this->content = json_encode($utentidg);
    }

    public function userDelete(int $id) {
        try {
            $result = $this->Users->deleteUser((int) $id);
            $this->content = json_encode($result);
        } catch (PDOException $e) {
            return $e->getMessage();
        }
    }

    public function allGroups() {
        
        $groups = $this->Users->getGroupsDt($_POST['search']['value'], $_POST['order'], $_POST['length'], $_POST['start'], $_POST['columns']);

        foreach ($groups as $grp) {
            $datidg[] = array(
                'nome_gruppo' => $grp['group_name'],
                'descrizione' => $grp['group_description'],
                'gestione' => "<div class='btn-group'><a href='/groups/$grp[group_id]/edit' class='btn btn-default'><i class='fa fa-edit'></i></a></div>"
            );
        }
        
        $totale_records = $this->Users->groupsDtCount;
        
        $gruppidg = [
            "draw" => $_POST['draw'],
            "recordsTotal" => $totale_records,
            "recordsFiltered" => $totale_records,
            "colums" => array('nome_gruppo', 'descrizione'),
            "data" => $datidg,
        ];

        $this->content = json_encode($gruppidg);
    }

}

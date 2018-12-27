<?php

namespace App\Helpers;

class Validation {

    public function __construct() {
    
    }
    
    public static function valUsers($param, $ckPassword = false) {
        $err = array();
        //campi obbligatori
        if (empty(trim($param['email']))){
            array_push($err, 'Email non inserita');
        }
        if (empty(trim($param['nome']))){
            array_push($err, 'Nome non inserito');
        }
        if (empty(trim($param['cognome']))){
            array_push($err, 'Cognome non inserito');
        }
        if (empty(trim($param['cellulare']))){
            array_push($err, 'Cellulare non inserito');
        }
        
        if ($ckPassword) {
            if (empty(trim($param['password']))){
                array_push($err, 'Password non inserita');
            }
            if (empty(trim($param['confirm_password']))){
                array_push($err, 'Conferma Password non inserita');
            }
            if (trim($param['password']) !== trim($param['confirm_password'])){
                array_push($err, 'Le password non coincidono');
            }
            if (strlen(trim($param['password'])) < 8){
                array_push($err, 'Password troppo corta');
            }
        }
        
        if (!empty($err)){
            $Err = new \App\Models\Errors();
            foreach ($err as $e) {
                $Err->set_error($e);
            }
            return $err;
        } else {
            return [];
        }
        
    }
    
    public static function valGroup($param) {
        $err = array();
        //campi obbligatori
        if (empty(trim($param['group_name']))){
            array_push($err, 'Gruppo non inserito');
        }
  
        if (!empty($err)){
            $Err = new \App\Models\Errors();
            foreach ($err as $e) {
                $Err->set_error($e);
            }
            return $err;
        } else {
            return [];
        }
        
    }    

}

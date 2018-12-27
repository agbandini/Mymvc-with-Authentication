<?php
namespace App\Models;
/**
 * Error class
 */
class Errors{

    /**
     * Errors
     *
     * @access private 
     */
    private $errors = array();

    /**
     * Session
     *
     * @access private 
     */
    private $session;

    /**
     * Constructor
     * 
     * @access public 
     */
    public function __construct() {

        $this->session = new Session();

        if (!$this->session->get('errors'))
            $this->session->set('errors', array());
    }

    /**
     * Set errors
     * 
     * @access public 
     */
    public function set_error($message) {

        $this->errors[] = $message;

        $this->session->set('errors', $this->errors);
    }

    /**
     * Display errors
     * 
     * @access public 
     */
    public function display_errors() {
        return $this->session->get('errors');
    }
    
    public function display_errors_html($clean = false) {
        
        $erlist = $this->session->get('errors');
        $out = '';
        foreach ($erlist as $e){
            $out .= $e.'<br>';
        }
        
        if($clean){
            $this->clear_errors();
        }
        
        return $out;
    }

    /**
     * Returns whether has errors
     * 
     * @access public 
     */
    public function has_errors() {
        /*
          $x = $this->session->get('errors');
          if((strlen($x[0]) <> "0") && (count($this->session->get('errors')) > 0 )){
          return true;
          } else {
          return false;
          }
         */
        return count($this->session->get('errors')) > 0 ? true : false;
    }

    /**
     * Clear errors
     * 
     * @access public 
     */
    public function clear_errors() {

        $this->session->delete('errors');
        $this->session->set('errors', array());
    }

}
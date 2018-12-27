<?php
namespace App\Models;
use \PDO;

class Session {

    /**
     * Constructor
     *
     * @access public
     */
    public function __construct() {
        if (!session_id()){
            session_start();
        }
    }

    /**
     * Set session
     *
     * @access public
     */
    public function set($name, $value) {
        $_SESSION[$name] = $value;
    }

    /**
     * Get session
     *
     * @access public
     */
    public function get($name) {
        if (isset($_SESSION[$name])){
            return $_SESSION[$name];
        } else {
            return false;
        }
    }

    /**
     * Delete session
     *
     * @access public
     */
    public function delete($name) {
        unset($_SESSION[$name]);
    }

    /**
     * Destroy session
     *
     * @access public
     */
    public function destroy() {
    	//var_dump(session_status());
	if (!isset($_SESSION)) {
            session_start();
	}
        $_SESSION = array();
        session_unset();
        session_destroy();
        //var_dump($_SESSION);
    }

}

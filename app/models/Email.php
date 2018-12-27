<?php

namespace App\Models;

/**
 * Description of Email
 *
 * @author gmk
 */
class Email {

    public function __construct() {
        $this->Email = new \PHPMailer\PHPMailer\PHPMailer(true);
    }

    public function pwdResetMail($email, $pwd) {
        try {
            $this->Email->IsSMTP(); // set mailer to use SMTP
            $this->Email->SMTPAuth = true;
            $this->Email->From = \Conf::CFG_SYSTEM_EMAIL;
            $this->Email->CharSet = "UTF-8";
            $this->Email->FromName = \Conf::CFG_APP_TITLE;
            $this->Email->Host = \Conf::CFG_SMTP_HOST; // specify main and backup server
            $this->Email->Port = \Conf::CFG_SMTP_PORT; // Porta SMTP
            $this->Email->Username = \Conf::CFG_SMTP_USERNAME; // SMTP account username
            $this->Email->Password = \Conf::CFG_SMTP_PASSWORD; // SMTP account password
            $this->Email->SMTPSecure = \Conf::CFG_SMTP_SECURITY;
            $this->Email->AddReplyTo(\Conf::CFG_SYSTEM_EMAIL, \Conf::CFG_APP_TITLE);
            $this->Email->WordWrap = 50; // set word wrap
            $this->Email->IsHTML(true); // set email format to HTML

            $message = file_get_contents('././layout/email/passwordReset.tpl.php');
            $this->Email->Subject = "Recupero password per  " . \Conf::CFG_APP_TITLE;

            $message = str_replace('%%SITE_NAME%%', \Conf::CFG_APP_TITLE, $message);
            $message = str_replace('%%CUSTOMER_EMAIL%%', \Conf::CFG_SYSTEM_EMAIL, $message);
            $message = str_replace('%%SITE_URL%%', \Conf::CFG_APP_URL, $message);
            $message = str_replace('%%EMAIL%%', $email, $message);
            $message = str_replace('%%PASSWORD%%', $pwd, $message);

            $this->Email->Body = $message;
            $this->Email->ClearAddresses();
            $this->Email->AddAddress($email); // name is optional
            $this->Email->Send();
            return true;
        } catch (Exception $e) {

            return false;
        }
    }

}

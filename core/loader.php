<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/Conf.php';
require_once __DIR__ . '/../db/DBPDO.php';
require_once __DIR__ . '/../db/DbFactory.php';
require_once __DIR__ . '/../app/controllers/MainController.php';
require_once __DIR__ . '/../app/controllers/AuthController.php';
require_once __DIR__ . '/../app/controllers/UsersController.php';
require_once __DIR__ . '/../app/controllers/AjaxController.php';
require_once __DIR__ . '/../app/models/Session.php';
require_once __DIR__ . '/../app/models/Errors.php';
require_once __DIR__ . '/../app/models/Authentication.php';
require_once __DIR__ . '/../app/models/Users.php';
require_once __DIR__ . '/../helpers/Validation.php';
require_once __DIR__ . '/../helpers/functions.php';
require_once __DIR__ . '/../core/Router.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/SMTP.php';
require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/Exception.php';
require_once __DIR__ . '/../app/models/Email.php';

$session = new \App\Models\Session();
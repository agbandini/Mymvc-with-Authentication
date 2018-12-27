<?php
header('Content-Type: text/html; charset=utf-8');
chdir(dirname(__DIR__));
require_once __DIR__ . '/../core/loader.php';

$data = require 'config/database.php';
$appRoutes = require 'config/app.routes.php';

try {
    
    $conn = App\DB\DbFactory::create($data)->getConn();
    $router = new Router($conn);
    $router->loadRoutes($appRoutes['routes']);   
    $controller = $router->dispatch();

    //$_SESSION['logged_in'] = null;
    //var_dump($_SESSION['logged_in']);
    
    if (!$session->get('logged_in') && !is_a($controller, 'App\Controllers\AuthController')) {
        redirect('/login');
    } else {
        $controller->display(); 
    }
    
} catch (\PDOException $e) {
    echo $e->getMessage();
} catch (\Exception $e) {
    echo $e->getMessage();
}
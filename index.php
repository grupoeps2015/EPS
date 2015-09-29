<?php
    
    define('DS',DIRECTORY_SEPARATOR);
    define('ROOT',realpath(dirname(__FILE__)) . DS);
    define('APP_PATH',ROOT . 'application' . DS);
    
    require_once APP_PATH . 'Bootstrap.php';
    require_once APP_PATH . 'Config.php';
    require_once APP_PATH . 'Controller.php';
    require_once APP_PATH . 'Database.php';
    require_once APP_PATH . 'Funciones.php';
    require_once APP_PATH . 'Model.php';
    require_once APP_PATH . 'Parametros.php';
    require_once APP_PATH . 'Registro.php';
    require_once APP_PATH . 'Request.php';
    require_once APP_PATH . 'View.php';

    try{
        Bootstrap::run(new Request);
    }catch(Exception $e){
        echo $e->getMessage();
    }
    
?>
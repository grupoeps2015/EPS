<?php

/**
 * La clase Boostrap es la encargada de reconocer el controlador que se
 * esta invocando y el metodo que se solicite.
 *
 * @author Rickardo
 */

class Bootstrap{
    public static function run(Request $peticion){
        $controller = $peticion->getControlador() . 'Controller';
        $rutaControlador = ROOT . 'controllers' . DS . $controller . '.php';
        if(is_readable($rutaControlador)){
            Bootstrap::redirect($peticion);
        }else{
            throw new Exception('Controlador no encontrado: ' . $rutaControlador);
        }
    }
    
    public function redirect(Request $peticion){
        $controller = $peticion->getControlador() . 'Controller';
        $rutaControlador = ROOT . 'controllers' . DS . $controller . '.php';
        $metodo = $peticion->getMetodo();
        $args = $peticion->getArgs();
        
        require_once $rutaControlador;
        $controller = new $controller;
            
        if(is_callable(array($controller, $metodo))){
            $metodo = $peticion->getMetodo();
        }else{
            $metodo = 'index';
        }
        
        if(isset($args)){
            call_user_func_array(array($controller,$metodo), $args);
        }else{
            call_user_func(array($controller,$metodo));
        }
    }
    
}

?>
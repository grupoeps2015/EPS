<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of session
 *
 * @author ARIAS
 */
class session {
    public function __construct() {
        
    }
    public function validarSesion(){
        session_start();
        if(isset($_SESSION["centrounidad"]) && isset($_SESSION["usuario"]) && isset($_SESSION["rol"]) && isset($_SESSION["nombre"])){
            if($_SESSION["rol"] == ROL_ESTUDIANTE){
                 if(isset($_SESSION["carrera"])){
                     return true;
                 }
                 else{
                     return false;
                 }
            }
            return true;
        }
        else{
            return false;
        }
    }
    public function prueba(){
        $modelo = 'ajaxModel';
        require_once ROOT . 'models' . DS . $modelo . '.php';
        $modelo = new $modelo;
        $lstPais = $modelo->getPais();
        print_r ($lstPais);
    }
}

?>

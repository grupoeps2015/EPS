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
        session_start();
    }
    public function validarSesion(){
        $retorno = false;
        if(isset($_SESSION["centrounidad"]) && isset($_SESSION["usuario"]) && isset($_SESSION["rol"]) && isset($_SESSION["nombre"]) && isset($_SESSION["tiempo"])){
            $retorno = true;
//            if($_SESSION["rol"] == ROL_ESTUDIANTE){
//                 if(isset($_SESSION["carrera"])){
//                     $retorno = true;
//                 }
//                 else{
//                     $retorno = false;
//                 }
//            }
        }
        if($retorno){
            $retorno = $this->validarTiempoSesion();
        }
        return $retorno;
    }
    public function validarTiempoSesion(){
        $modelo = 'ajaxModel';
        require_once ROOT . 'models' . DS . $modelo . '.php';
        $modelo = new $modelo;
        $lstPais = $modelo->getPais();
        $tiempoSesion = $modelo->valorParametro(CONS_PARAM_APP_MAXTIEMPOSESIONACTIVA, -1, -1);
        if(!is_array($tiempoSesion)){
            $urlEnvio=BASE_URL."error/sql/" . $tiempoSesion;
            echo '<script language="javascript">window.location.href="' . $urlEnvio . '"</script>';
            exit;
        }
        $tiempoSesion = (isset($tiempoSesion[0]['valorparametro']) ? $tiempoSesion[0]['valorparametro'] : 0);
        if($tiempoSesion*60 < time() - $_SESSION["tiempo"]){
            return false;
        }
        else{
            return true;
        }
    }
}

?>

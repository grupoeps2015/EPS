<?php

/**
 * Description of gestionNotas
 *
 * @author Rickardo
 */
class empleadoController extends Controller{
    
    private $_emp;
    private $_ajax;
    private $_encriptar;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('session');
        $this->_session = new session();
        if(!$this->_session->validarSesion()){
            //$this->redireccionar('login/salir');
            //exit;
        }
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_emp = $this->loadModel('empleado');
        $this->_ajax = $this->loadModel('ajax');
    }

    public function index(){
        $this->redireccionar('admEmpleado/infoEmpleado');
    }
    
    public function infoEmpleado($idUsuario=0){
        $iden = $this->getInteger('hdEnvio');
        $actualizar = false;
        $arrayInfo = array();
        
        $this->_view->titulo = APP_TITULO;
        $this->_view->id = $idUsuario;
        
        $deptos = $this->_view->deptos = $this->_ajax->getDeptos();
        if(is_array($deptos)){
            $this->_view->deptos = $deptos;
        }else{
            $this->redireccionar("error/sql/" . $deptos);
            exit;
        }
        
        $paises = $this->_ajax->getPais();
        if(is_array($paises)){
            $this->_view->paises = $paises;
        }else{
            $this->redireccionar("error/sql/" . $paises);
            exit;
        }
        
        
        $infoGeneral = $this->_emp->getInfoGeneral($idUsuario);
        if(is_array($infoGeneral)){
            $this->_view->infoGeneral = $infoGeneral;
        }else{
            $this->redireccionar("error/sql/" . $infoGeneral);
            exit;
        }
        
        $this->_view->setJs(array('empleado'));
        $this->_view->setJs(array('jquery.validate'), "public");
        
        if($iden == 1){
            $actualizar = true;
        }
        
        if($actualizar){
            $arrayInfo["id"] = $idUsuario;
            $arrayInfo["direccion"] = $this->getTexto('txtDireccion');
            $arrayInfo["zona"] = $this->getInteger('txtZona');
            $arrayInfo["muni"] = $this->getInteger('slMunis');
            $arrayInfo["telefono"] = $this->getTexto('txtTelefono');
            $arrayInfo["pais"] = $this->getInteger('slPaises');
            $info = $this->_emp->setInfo($arrayInfo);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            $this->redireccionar('empleado/infoEmpleado/' . $idUsuario);
        }
        
        $this->_view->renderizar('empleado','infoEmpleado');
    }
}

<?php

class admEmpleadoController extends Controller{
    
    private $_emp;
    private $_ajax;
    private $_encriptar;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_emp = $this->loadModel(ADM_FOLDER,'admEmpleado');
        $this->_ajax = $this->loadModel("",'ajax');
    }

    public function index(){
        $this->redireccionar('admEmpleado/infoEmpleado');
    }
    
    public function infoEmpleado($idUsuario=0){
        $iden = $this->getInteger('hdEnvio');
        $actualizar = false;
        $arrayInfo = array();
        
        $this->_view->titulo = APP_TITULO;
        $this->_view->deptos = $this->_ajax->getDeptos();
        $this->_view->paises = $this->_ajax->getPais();
        $this->_view->infoGeneral = $this->_emp->getInfo($idUsuario);
        $this->_view->setJs(ADM_FOLDER, array('admEmpleado'));
        $this->_view->setJs("public", array('jquery.validate'));
        
        if($iden == 1){
            $this->_view->datos = $_POST;
            if (!$this->getInteger('slDeptos')) {
                $this->_view->renderizar(ADM_FOLDER,'admEmpleado','infoEmpleado');
                exit;
            }
            if (!$this->getInteger('slMunis')) {
                $this->_view->renderizar(ADM_FOLDER,'admEmpleado','infoEmpleado');
                exit;
            }
            if (!$this->getInteger('txtZona')) {
                $this->_view->renderizar(ADM_FOLDER,'admEmpleado','infoEmpleado');
                exit;
            }
            if (!$this->getTexto('txtDireccion')) {
                $this->_view->renderizar(ADM_FOLDER,'admEmpleado','infoEmpleado');
                exit;
            }
            if (!$this->getInteger('txtTelefono')) {
                $this->_view->renderizar(ADM_FOLDER,'admEmpleado','infoEmpleado');
                exit;
            }
            if (!$this->getInteger('slPaises')) {
                $this->_view->renderizar(ADM_FOLDER,'admEmpleado','infoEmpleado');
                exit;
            }
            $actualizar = true;
        }
        
        if($actualizar){
            $arrayInfo["id"] = $idUsuario;
            $arrayInfo["direccion"] = $this->getTexto('txtDireccion');
            $arrayInfo["zona"] = $this->getInteger('txtZona');
            $arrayInfo["muni"] = $this->getInteger('slMunis');
            $arrayInfo["telefono"] = $this->getTexto('txtTelefono');
            $arrayInfo["pais"] = $this->getInteger('slPaises');
            $this->_emp->setInfo($arrayInfo);
            
            $this->redireccionar('admEmpleado/infoEmpleado/10');
        }
        
        $this->_view->renderizar(ADM_FOLDER,'admEmpleado','infoEmpleado');
    }
}

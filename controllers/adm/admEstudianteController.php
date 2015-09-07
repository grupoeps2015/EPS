<?php

class admEstudianteController extends Controller{
    
    private $_est;
    private $_ajax;
    private $_encriptar;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_est = $this->loadModel(ADM_FOLDER,'admEstudiante');
        $this->_ajax = $this->loadModel("",'ajax');
    }

    public function index(){
        $this->redireccionar('admEstudiante/infoEstudiante');
    }
    
    public function infoEstudiante($idUsuario=0){
        $iden = $this->getInteger('hdEnvio');
        $actualizar = false;
        $arrayGen = array();
        $arrayEmg = array();
        
        $this->_view->titulo = APP_TITULO;
        $this->_view->deptos = $this->_post->getDeptos();
        $this->_view->paises = $this->_post->getPais();
        $this->_view->infoGeneral = $this->_est->getInfoGeneral($idUsuario);
        $this->_view->setJs(ADM_FOLDER, array('admEstudiante'));
        $this->_view->setJs("public", array('jquery.validate'));
        if($iden == 1){
            $this->_view->datos = $_POST;
            if (!$this->getInteger('slDeptos')) {
                $this->_view->renderizar(ADM_FOLDER,'admEstudiante','infoEstudiante');
                exit;
            }
            if (!$this->getInteger('slMunis')) {
                $this->_view->renderizar(ADM_FOLDER,'admEstudiante','infoEstudiante');
                exit;
            }
            if (!$this->getInteger('txtZona')) {
                $this->_view->renderizar(ADM_FOLDER,'admEstudiante','infoEstudiante');
                exit;
            }
            if (!$this->getTexto('txtDireccion')) {
                $this->_view->renderizar(ADM_FOLDER,'admEstudiante','infoEstudiante');
                exit;
            }
            if (!$this->getInteger('txtTelefono')) {
                $this->_view->renderizar(ADM_FOLDER,'admEstudiante','infoEstudiante');
                exit;
            }
            if (!$this->getInteger('slPaises')) {
                $this->_view->renderizar(ADM_FOLDER,'admEstudiante','infoEstudiante');
                exit;
            }
            $actualizar = true;
        }else if($iden == 2){
            $actualizar = true;
        }
        
        if($actualizar){
            if($iden == 1){
                $arrayGen["id"] = $idUsuario;
                $arrayGen["direccion"] = $this->getTexto('txtDireccion');
                $arrayGen["zona"] = $this->getInteger('txtZona');
                $arrayGen["muni"] = $this->getInteger('slMunis');
                $arrayGen["telefono"] = $this->getTexto('txtTelefono');
                $arrayGen["pais"] = $this->getInteger('slPaises');
                $this->_est->setInfoGeneral($arrayGen);
            }else{
                $arrayEmg["id"] = $idUsuario;
                $arrayEmg["telefonoE"] = $this->getTexto('txtTelefonoE');
                $arrayEmg["alergias"] = $this->getTexto('txtAlergias');
                $arrayEmg["sangre"] = $this->getTexto('txtTipoSangre');
                $arrayEmg["centro"] = $this->getTexto('txtHospital');
                $arrayEmg["seguro"] = $this->getInteger('rbSeguro');
                $this->_est->setInfoEmergencia($arrayEmg);
            }
           $this->redireccionar('admEstudiante/infoEstudiante/12');
        }
        
        $this->_view->renderizar(ADM_FOLDER,'admEstudiante');
    }
}

<?php

/**
 * Description of gestionNotas
 *
 * @author Rickardo
 */
class estudianteController extends Controller{
    
    private $_est;
    private $_ajax;
    private $_encriptar;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_est = $this->loadModel('estudiante');
        $this->_ajax = $this->loadModel('ajax');
    }

    public function index(){
        $this->redireccionar('estudiante/infoEstudiante');
    }
    
    public function infoEstudiante($idUsuario=0){
        $iden = $this->getInteger('hdEnvio');
        $actualizar = false;
        $arrayGen = array();
        $arrayEmg = array();
        
        $this->_view->titulo = APP_TITULO;
        $this->_view->id = $idUsuario;
        $this->_view->deptos = $this->_ajax->getDeptos();
        $this->_view->paises = $this->_ajax->getPais();
        $this->_view->infoGeneral = $this->_est->getInfoGeneral($idUsuario);
        $this->_view->setJs(array('estudiante'));
        $this->_view->setJs(array('jquery.validate'), "public");
        
        if($iden == 1 || $iden == 2){
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
           $this->redireccionar('estudiante/infoEstudiante/' . $idUsuario);
        }
        
        $this->_view->renderizar('estudiante');
    }
}

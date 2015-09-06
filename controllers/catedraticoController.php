<?php

class catedraticoController extends Controller{
    
    private $_cat;
    private $_ajax;
    private $_encriptar;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_cat = $this->loadModel('catedratico');
        $this->_ajax = $this->loadModel('ajax');
    }

    public function index(){
        $this->redireccionar('catedratico/infoCatedratico');
    }
    
    public function infoCatedratico($idUsuario=0){
        $iden = $this->getInteger('hdEnvio');
        $actualizar = false;
        $arrayInfo = array();
        
        $this->_view->titulo = APP_TITULO;
        $this->_view->id = $idUsuario;
        $this->_view->deptos = $this->_ajax->getDeptos();
        $this->_view->paises = $this->_ajax->getPais();
        $this->_view->infoGeneral = $this->_cat->getInfo($idUsuario);
        $this->_view->setJs(array('admCatedratico'));
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
            $this->_cat->setInfo($arrayInfo);
            
            $this->redireccionar('catedratico/infoCatedratico/'. $idUsuario);
        }
        
        $this->_view->renderizar('catedratico');
    }
}

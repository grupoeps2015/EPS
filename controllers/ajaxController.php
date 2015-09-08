<?php

class ajaxController extends Controller{
    
    private $_ajax;
    
    public function __construct() {
        parent::__construct();
        $this->_ajax=$this->loadModel('ajax');
    }
    
    public function index(){
        
    }
    
    public function getMunicipio(){
        if($this->getInteger('Depto')){
            echo json_encode($this->_ajax->getMunicipio($this->getInteger('Depto')));
        }
    }
    
    public function getUnidadesAjax(){
        if($this->getInteger('centro')){
            echo json_encode($this->_ajax->getUnidadesAjax($this->getInteger('centro')));
        }
    }
    
    public function getCiclosAjax(){
        if($this->getInteger('tipo')){
            echo json_encode($this->_ajax->getCiclosAjax($this->getInteger('tipo')));
        }
    }
    
    public function getCarreras(){
        if($this->getInteger('carr')){
            echo json_encode($this->_ajax->getCarreras($this->getInteger('carr')));
        }
    }
    
    public function getCentroUnidadAjax(){
        if($this->getInteger('centro') && $this->getInteger('unidad')){
            echo json_encode($this->_ajax->getCentroUnidadAjax($this->getInteger('centro'),$this->getInteger('unidad')));
        }
    }
    
    public function getInfoCarreras(){
        if($this->getInteger('centro_unidadacademica')){
            echo json_encode($this->_ajax->getInfoCarreras($this->getInteger('centro_unidadacademica')));
        }
    }
}

?>
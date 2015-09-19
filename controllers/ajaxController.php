<?php

/**
 * Description of ajaxController
 *
 * @author Rickardo
 */
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
    
    public function getJornadasAjax(){
        if($this->getInteger('jornada')){
            echo json_encode($this->_ajax->getJornadas());
        }
    }
    
    public function getTipoCiclo(){
        if($this->getInteger('tipoCiclo')){
            echo json_encode($this->_ajax->getTipoCiclo());
        }
    }
    
    public function getAniosAjax(){
        if($this->getInteger('tipo')){
            echo json_encode($this->_ajax->getAniosAjax($this->getInteger('tipo')));
        }
    }
    
    public function getCiclosAjax(){
        if($this->getInteger('anio')){
            $tipo = 1;
            //TODO: Marlen: consultar parámetro en base de datos
            echo json_encode($this->_ajax->getCiclosAjax($tipo,$this->getInteger('anio')));
        }
    }
    
    public function getPeriodosAjax(){
        if($this->getInteger('tipo')){
            echo json_encode($this->_ajax->getPeriodosAjax($this->getInteger('tipo')));
        }
    }
    
     public function getDatosCentroUnidadAjax(){
        if($this->getInteger('centroUnidad')){
            echo json_encode($this->_ajax->getDatosCentroUnidad());
        }
    }
    
    public function getSalonesAjax(){
        if($this->getInteger('edificio')){
            echo json_encode($this->_ajax->getSalonesAjax($this->getInteger('edificio')));
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
    
    public function getDocenteSeccion(){
        if($this->getInteger('cat') && $this->getInteger('ciclo')){
            echo json_encode($this->_ajax->getDocenteSeccion($this->getInteger('cat'),$this->getInteger('ciclo')));
        }
    }
    
}

?>
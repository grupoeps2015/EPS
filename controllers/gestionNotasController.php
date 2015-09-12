<?php

/**
 * Description of gestionNotas
 *
 * @author Rickardo
 */
class gestionNotasController extends Controller{
    private $_ajax;
    private $_notas;
    private $_catedratico;
    
    public function __construct() {
        parent::__construct();
        $this->_ajax = $this->loadModel('ajax');
        $this->_notas = $this->loadModel('gestionNotas');
        $this->_catedratico = $this->loadModel('catedratico');
    }
    
    public function index(){
        $idCentroUnidad = $this->getInteger('hdCentroUnidad');
        
        $lsCat = $this->_catedratico->getCatedraticos($idCentroUnidad);
        if(is_array($lsCat)){
            $this->_view->lstCat = $lsCat;
        }else{
            $this->redireccionar("error/sql/" . $lsCat);
            exit;
        }
        
        $infoCentroUnidad = $this->_ajax->spGetNombreCentroUnidad($idCentroUnidad);
        if(is_array($infoCentroUnidad)){
            $this->_view->infoCentroUnidad = $infoCentroUnidad;
        }else{
            $this->redireccionar("error/sql/" . $infoCentroUnidad);
            exit;
        }
        
        $this->_view->setJs(array('gestionNotas'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));
        $this->_view->titulo = 'Gestión de notas - ' . APP_TITULO;
        $this->_view->id = $idCentroUnidad;
        $this->_view->renderizar('gestionNotas');
    }
    
    public function cursosXDocente($idRegistro = 0){
        
        $this->_view->registroCat = $idRegistro;
        
        $lsTipoCiclo = $this->_view->getTipoCiclo();
        if(is_array($lsTipoCiclo)){
            $this->_view->lsTipoCiclo = $lsTipoCiclo;
        }else{
            $this->redireccionar('error/sql/' . $lsTipoCiclo);
            exit;
        }
        
        
        $this->_view->titulo = 'Gestión de notas - ' . APP_TITULO;
        $this->_view->setJs(array('cursosXDocente'));
        $this->_view->renderizar('cursosXDocente','gestionNotas');
    }
    
    public function actividades(){
        $this->_view->titulo = 'Gestión de notas - ' . APP_TITULO;
        $this->_view->setJs(array('actividades'));
        $this->_view->renderizar('actividades');
    }
    
}

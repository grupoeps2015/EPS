<?php

/**
 * Description of gestionParametroController
 *
 * @author Gerson
 */

class gestionParametroController extends Controller{
    
    private $_post;
    
    public function __construct() {
        parent::__construct();
        $this->_post = $this->loadModel('gestionParametro');
    }

    public function index(){
        $this->_view->lstPar = $this->_post->informacionParametro();
        $this->_view->titulo = 'Gestión de parámetros - ' . APP_TITULO;
        
        //Se agregan los archivos JS, CSS, locales y publicos
        $this->_view->setJs(array('gestionParametro'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));
        
        //se renderiza la vista a mostrar
        $this->_view->renderizar('gestionParametro');
    }
    
    public function agregarParametro(){
        $iden = $this->getInteger('hdEnvio');
        $arrayPar = array();
        $this->_view->centro_unidadacademica = $this->_post->getCentro_UnidadAcademica();
        $this->_view->tipoparametro = $this->_post->getTipoParametro();
        
        $this->_view->titulo = 'Agregar Parametro - ' . APP_TITULO;
        $this->_view->setJs(array('agregarParametro'));
        $this->_view->setJs(array('jquery.validate'), "public");
        
        if($iden == 1){
            $arrayPar["nombre"] = $this->getTexto('txtNombreParametro');
            $arrayPar["valor"] = $this->getTexto('txtValorParametro');
            $arrayPar["descripcion"] = $this->getTexto('txtDescripcionParametro');
            $arrayPar["centro_unidadacademica"] = $this->getInteger('slCentroUnidadAcademica');
            $arrayPar["carrera"] = $this->getInteger('slCarreras');
            $arrayPar["extension"] = $this->getTexto('txtExtensionParametro');         
            $arrayPar["tipoparametro"] =  $this->getInteger('slTipoParametro');
            $this->_view->query = $this->_post->agregarParametro($arrayPar);
            $this->redireccionar('gestionParametro');
        }
        
        $this->_view->renderizar('agregarParametro', 'gestionParametro');
    }
    
    public function eliminarParametro($intNuevoEstado, $intIdParametro){
        if($intNuevoEstado == -1 || $intNuevoEstado == 1){
            $this->_post->eliminarParametro($intIdParametro,$intNuevoEstado);
            $this->redireccionar('gestionParametro');
        }else{
            $this->_view->cambio = "No reconocio ningun parametro";    
        }
    }
    
    public function actualizarParametro($intIdParametro = 0) {
        $iden = $this->getInteger('hdEnvio');
        
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarParametro'));
        $this->_view->centro_unidadacademica = $this->_post->getCentro_UnidadAcademica();
        $this->_view->tipoparametro = $this->_post->getTipoParametro();
        
        $arrayPar = array();
        $this->_view->id = $intIdParametro;
        $this->_view->datosPar = $this->_post->datosParametro($intIdParametro);
        if($iden == 1){
            $arrayPar["nombre"] = $this->getTexto('txtNombreParametro');
            $arrayPar["valor"] = $this->getTexto('txtValorParametro');
            $arrayPar["descripcion"] = $this->getTexto('txtDescripcionParametro');
            $arrayPar["centro_unidadacademica"] = $this->getInteger('slCentroUnidadAcademica');
            $arrayPar["carrera"] = $this->getInteger('slCarreras');
            $arrayPar["extension"] = $this->getTexto('txtExtensionParametro');         
            $arrayPar["tipoparametro"] =  $this->getInteger('slTipoParametro');
            //$this->_post->actualizarParametro($intIdParametro, $arrayPar);
            $this->redireccionar('gestionParametro/actualizarParametro/' . $intIdParametro);
        }
        $this->_view->renderizar('actualizarParametro', 'gestionParametro');
    }
 
}
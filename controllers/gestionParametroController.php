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
        
        $unicentro = $this->_post->getCentro_UnidadAcademica();
        if(is_array($unicentro)){
            $this->_view->centro_unidadacademica = $unicentro;
        }else{
            $this->redireccionar("error/sql/" . $unicentro);
            exit;
        }
        
        $tipoparam = $this->_post->getTipoParametro();
        if(is_array($tipoparam)){
            $this->_view->tipoparametro = $tipoparam;
        }else{
            $this->redireccionar("error/sql/" . $tipoparam);
            exit;
        }
        
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
            
            $info = $this->_view->query = $this->_post->agregarParametro($arrayPar);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            
            $this->redireccionar('gestionParametro');
        }
        
        $this->_view->renderizar('agregarParametro', 'gestionParametro');
    }
    
    public function eliminarParametro($intNuevoEstado, $intIdParametro){
        if($intNuevoEstado == -1 || $intNuevoEstado == 1){
            $info = $this->_post->eliminarParametro($intIdParametro,$intNuevoEstado);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            $this->redireccionar('gestionParametro');
        }else{
            $this->_view->cambio = "No reconocio ningun parametro";    
        }
    }
    
    public function actualizarParametro($intIdParametro = 0) {
        $valorPagina = $this->getInteger('hdEnvio');
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarParametro'));
        
        $unicentro = $this->_post->getCentro_UnidadAcademica();
        if(is_array($unicentro)){
            $this->_view->centro_unidadacademica = $unicentro;
        }else{
            $this->redireccionar("error/sql/" . $unicentro);
            exit;
        }
        
        $tipoparam = $this->_post->getTipoParametro();
        if(is_array($tipoparam)){
            $this->_view->tipoparametro = $tipoparam;
        }else{
            $this->redireccionar("error/sql/" . $tipoparam);
            exit;
        }
        
        $arrayPar = array();
        $this->_view->id = $intIdParametro;
        $datosPar = $this->_post->datosParametro($intIdParametro);
        if(is_array($datosPar)){
            $this->_view->datosPar = $datosPar;
        }else{
            $this->redireccionar("error/sql/" . $datosPar);
            exit;
        }
        
        if ($valorPagina == 1) {
            $arrayPar["parametro"] = $intIdParametro;
            $arrayPar["nombre"] = $this->getTexto('txtNombreParametro');
            $arrayPar["valor"] = $this->getTexto('txtValorParametro');
            $arrayPar["descripcion"] = $this->getTexto('txtDescripcionParametro');
            $arrayPar["centro_unidadacademica"] = $this->getInteger('slCentroUnidadAcademica');
            $arrayPar["carrera"] = $this->getInteger('slCarreras');
            $arrayPar["extension"] = $this->getTexto('txtExtensionParametro');         
            $arrayPar["tipoparametro"] =  $this->getInteger('slTipoParametro');
            
            $info = $this->_post->actualizarParametro($arrayPar);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            
            $this->redireccionar('gestionParametro/actualizarParametro/' . $intIdParametro);
        }
        $this->_view->renderizar('actualizarParametro', 'gestionParametro');
    }
 
}
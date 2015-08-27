<?php

/**
 * Description of admCrearParametroController
 *
 * @author Gerson
 */

class admCrearParametroController extends Controller{
    
    private $_post;
    private $_encriptar;
    
     public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel(ADM_FOLDER, 'admCrearParametro');
    }

    public function index(){
        $this->_view->lstPar = $this->_post->informacionParametro();
        $this->_view->titulo = 'Gestión de parámetros - ' . APP_TITULO;
        
        //Se agregan los archivos JS, CSS, locales y publicos
        $this->_view->setJs(ADM_FOLDER, array('admCrearParametro'));
        $this->_view->setJs("public",array('jquery.dataTables.min'));
        $this->_view->setCSS(array('jquery.dataTables.min'));
        
        //se renderiza la vista a mostrar
        $this->_view->renderizar(ADM_FOLDER, 'admCrearParametro', 'admCrearParametro');
    }
    
    public function agregarParametro(){
         
        $arrayPar = array();
        
        $this->_view->titulo = 'Agregar Parametro - ' . APP_TITULO;
        $this->_view->setJs(ADM_FOLDER,array('agregarParametro'));
        $this->_view->setJs("public", array('jquery.validate'));
 
           $this->_view->datos = $_POST;
            if(!$this->getTexto('txtNombreParametro')){
                $this->_view->renderizar(ADM_FOLDER,'agregarParametro', 'admCrearParametro');
                exit;
            }
            
            if(!$this->getTexto('txtValorParametro')){
                $this->_view->renderizar(ADM_FOLDER,'agregarParametro', 'admCrearParametro');
                exit;
            }
            
            if(!$this->getTexto('txtDescripcionParametro')){
                $this->_view->renderizar(ADM_FOLDER,'agregarParametro', 'admCrearParametro');
                exit;
            }
            
            if(!$this->getTexto('txtExtensionParametro')){
                $this->_view->renderizar(ADM_FOLDER,'agregarParametro', 'admCrearParametro');
                exit;
            }
                        
            $arrayPar["nombre"] = $this->getTexto('txtNombreParametro');
            $arrayPar["valor"] = $this->getTexto('txtValorParametro');;
            $arrayPar["descripcion"] = $this->getTexto('txtDescripcionParametro');
            $arrayPar["centro"] = 1;
            $arrayPar["unidadacademica"] = 1;
            $arrayPar["carrera"] = 1;
            $arrayPar["extension"] = $this->getTexto('txtExtensionParametro');         
            $arrayPar["tipoparametro"] = 1;
            $this->_post->agregarParametro($arrayPar);           
           
        $this->redireccionar('admCrearParametro');
        $this->_view->renderizar(ADM_FOLDER,'agregarParametro', 'admCrearParametro');
        
        
    }
    public function eliminarParametro($intNuevoEstado,$intIdParametro){
        if($intNuevoEstado == -1 || $intNuevoEstado == 1){
            $this->_post->eliminarParametro($intIdParametro,$intNuevoEstado);
            $this->redireccionar('admCrearParametro');
        }else{
            $this->_view->cambio = "No reconocio ningun parametro";    
        }
        //$this->redireccionar('admCrearParametro');
        //$this->_view->cambio = $intNuevoEstado;
        $this->_view->titulo = 'Eliminar Parametro - ' . APP_TITULO;
        $this->_view->renderizar(ADM_FOLDER,'eliminarParametro', 'admCrearParametro');
    }
    
     public function actualizarParametro($intIdParametro = 0) {
        
       $iden = $this->getInteger('hdEnvio');
        $actualizar = false;
        $arrayGen = array();
        $arrayEmg = array();

        $this->_view->titulo = APP_TITULO;
        $this->_view->infoGeneral = $this->_par->datosParametro($intIdParametro);
        $this->_view->setJs(ADM_FOLDER, array('admEstudiante'));
        $this->_view->setJs("public", array('jquery.validate'));
           $this->_view->datos = $_POST;
            if (!$this->getTexto('txtNombre')) {
                $this->_view->renderizar(ADM_FOLDER, 'admCrearParametro', 'actualizarParametro');
                exit;
            }
            if (!$this->getTexto('txtCorreo')) {
                $this->_view->renderizar(ADM_FOLDER, 'admCrearParametro', 'actualizarParametro');
                exit;
            }
            if (!$this->getTexto('txtUnidadAcademica')) {
                $this->_view->renderizar(ADM_FOLDER, 'admCrearParametro', 'actualizarParametro');
                exit;
            }

            $actualizar = true;
        
        $this->_view->renderizar(ADM_FOLDER, 'actualizarParametro');
    }
    
}

?>
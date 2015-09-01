<?php

/**
 * Description of admCrearParametroController
 *
 * @author Gerson
 */

class gestionParametroController extends Controller{
    
    private $_post;
    private $_par;
    private $_encriptar;
    
     public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
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
        $arrayPar = array();
        $this->_view->titulo = 'Agregar Parametro - ' . APP_TITULO;
        $this->_view->setJs(array('agregarParametro'));
        $this->_view->setJs(array('jquery.validate'), "public");
        
        $arrayPar["nombre"] = $this->getTexto('txtNombreParametro');
        $arrayPar["valor"] = $this->getTexto('txtValorParametro');;
        $arrayPar["descripcion"] = $this->getTexto('txtDescripcionParametro');
        $arrayPar["centro"] = 1;
        $arrayPar["unidadacademica"] = 1;
        $arrayPar["carrera"] = 1;
        $arrayPar["extension"] = $this->getTexto('txtExtensionParametro');         
        $arrayPar["tipoparametro"] = 1;
        $this->_post->agregarParametro($arrayPar);           
           
        $this->redireccionar('gestionParametro');
        $this->_view->renderizar('agregarParametro', 'gestionParametro');
        
        
    }
    
    public function eliminarParametro($intNuevoEstado,$intIdParametro){
        if($intNuevoEstado == -1 || $intNuevoEstado == 1){
            $this->_post->eliminarParametro($intIdParametro,$intNuevoEstado);
            $this->redireccionar('gestionParametro');
        }else{
            $this->_view->cambio = "No reconocio ningun parametro";    
        }
        $this->_view->titulo = 'Eliminar Parametro - ' . APP_TITULO;
        $this->_view->renderizar('eliminarParametro', 'gestionParametro');
    }
    
    public function actualizarParametro($intIdParametro = 0) {
        
       $iden = $this->getInteger('hdEnvio');
        $actualizar = false;
        $arrayGen = array();
        $arrayEmg = array();

        $this->_view->titulo = APP_TITULO;
        $this->_view->infoGeneral = $this->_par->datosParametro($intIdParametro);
        $this->_view->setJs(array('estudiante'));
        $this->_view->setJs(array('jquery.validate'), "public");
        $actualizar = true;
        
        $this->_view->renderizar(ADM_FOLDER, 'actualizarParametro');
    }
    
}

?>
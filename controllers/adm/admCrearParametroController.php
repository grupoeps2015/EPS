<?php

/**
 * Description of admCrearParametroController
 *
 * @author Gerson
 */

class admCrearParametroController extends Controller{
    
    private $_post;
    private $_par;
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
    
  public function infoParametro($idParametro=0){
        $actualizar = false;
        $arrayGen = array();
        $arrayEmg = array();
        
        $this->_view->titulo = APP_TITULO;
        $this->_view->infoGeneral = $this->_par->getInfoGeneral($idParametro);
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

?>
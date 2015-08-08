<?php

/**
 * Description of admCrearUsuarioController
 *
 * @author Rickardo
 */

class admCrearUsuarioController extends Controller{
    
    private $_post;
    private $_encriptar;
    
     public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel(ADM_FOLDER,'admCrearUsuario');
    }

    public function index(){
        $this->_view->posts = $this->_post->getUsuarios();
        $this->_view->titulo = APP_TITULO;
        $this->_view->renderizarAdm('admCrearUsuario', 'admCrearUsuario');
    }
    
    public function agregarUsuario(){
        $iden = $this->getInteger('hdEnvio');
        $nombreUsr='';
        $correoUsr='';
        $fotoUsr='';
        $crearUsr = false;
        
        $arrayUsr = array();
        $arrayEst = array();
        $arrayEmp = array();
        $arrayCat = array();
        
        $this->_view->centros = $this->_post->getCentros();
        $this->_view->titulo = 'Agregar Usuario - ' . APP_TITULO;
        $this->_view->setJs(ADM_FOLDER,array('agregarUsuario'));
        $this->_view->setPublicJs(array('jquery.validate'));
        
        if($iden == 1){
            $this->_view->datos = $_POST;
            if(!$this->getTexto('txtNombreEst1')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtCorreoEst')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtApellidoEst1')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtCarnetEst')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            $nombreUsr = $this->getTexto('txtNombreEst1');
            $correoUsr = $this->getTexto('txtCorreoEst');
            $fotoUsr = $this->getTexto('txtFotoEst');
            $crearUsr = true;
            
        }
        elseif($iden == 2){
            $this->_view->datos = $_POST;
            $this->_view->preguntas = $this->_post->getPreguntas();
            if(!$this->getTexto('txtNombreCat1')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtCorreoCat')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtApellidoCat1')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtCodigoCat')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            $nombreUsr = $this->getTexto('txtNombreCat1');
            $correoUsr = $this->getTexto('txtCorreoCat');
            $fotoUsr = $this->getTexto('txtFotoCat');
            $crearUsr = true;
            
        }
        elseif($iden == 3){
            $this->_view->datos = $_POST;
            $this->_view->preguntas = $this->_post->getPreguntas();
            if(!$this->getTexto('txtNombreEmp1')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtCorreoEmp')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtApellidoEmp1')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtCodigoEmp')){
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            $nombreUsr = $this->getTexto('txtNombreEmp1');
            $correoUsr = $this->getTexto('txtCorreoEmp');
            $fotoUsr = $this->getTexto('txtFotoEmp');
            $crearUsr = true;
        }
        
        if($crearUsr){
            $arrayUsr["nombreUsr"] = $nombreUsr;
            $arrayUsr["correoUsr"] = $correoUsr;
            $arrayUsr["fotoUsr"] = $fotoUsr;
            $claveAleatoria = $this->_encriptar->keyGenerator();
            $arrayUsr["claveUsr"] = $this->_encriptar->encrypt($claveAleatoria, UNIDAD_ACADEMICA);
            $arrayUsr["preguntaUsr"] = 0;
            $arrayUsr["respuestaUsr"] = "USAC";
            $arrayUsr["intentosUsr"] = 5;
            $arrayUsr["unidadUsr"] = UNIDAD_ACADEMICA;
            $this->_post->agregarUsuario($arrayUsr);
            
            if($iden == 1){
                $arrayEst["carnetEst"] = $this->getTexto('txtCarnetEst');
                $arrayEst["nombreEst"] = $nombreUsr;
                $arrayEst["nombreEst2"] = $this->getTexto('txtNombreEst2');
                $arrayEst["apellidoEst"] = $this->getTexto('txtApellidoEst1');
                $arrayEst["apellidoEst2"] = $this->getTexto('txtApellidoEst2');
                $arrayEst["direccionEst"] = "ciudad";
                $arrayEst["zonaEst"] = 0;
                $arrayEst["municipioEst"] = 1;
                $arrayEst["telefonoEst"] = "22220000";
                $arrayEst["telefono2Est"] = "22220000";
                $arrayEst["sangreEst"] = "desconocida";
                $arrayEst["alergiasEst"] = "desconocidas";
                $arrayEst["seguroEst"] = 'false';
                $arrayEst["centroEst"] = "desconocido";
                $arrayEst["paisEst"] = 1;
                $this->_post->agregarEstudiante($arrayEst);
            }
            elseif($iden == 2){
                
            }
            elseif($iden == 3){
                
            }
            
            //$this->redireccionar('admCrearUsuario');
        }
        
        $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
    }
    
    public function eliminarUsuario(){
        
    }
    
    public function actualizarUsuario(){
        
    }
    
}

?>
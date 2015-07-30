<?php

/**
 * Description of admCrearUsuarioController
 *
 * @author Rickardo
 */

class admCrearUsuarioController extends Controller{
    
    private $_post;
    
     public function __construct() {
        parent::__construct();
        $this->_post = $this->loadModel(ADM_FOLDER,'admCrearUsuario');
    }

    public function index(){
        $this->_view->posts = $this->_post->getUsuarios();
        $this->_view->titulo = APP_TITULO;
        $this->_view->renderizarAdm('admCrearUsuario', 'admCrearUsuario');
    }
    
    public function agregarUsuario(){
        $this->_view->titulo = 'Agregar Usuario - ' . APP_TITULO;
        $this->_view->setJs(ADM_FOLDER,array('agregarUsuario'));
        $this->_view->setPublicJs(array('jquery.validate'));
        
        if($this->getInteger('btnAgregar') == 1){
            $this->_view->prueba = "Hola";
        }else{
            $this->_view->datos = $_POST;
            $this->_view->preguntas = $this->_post->getPreguntas();
            if(!$this->getTexto('txtNombre')){
                $this->_view->_error = "Campo Nombre es obligatorio";
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtCorreo')){
                $this->_view->_error = "Campo Correo es obligatorio";
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtPass1')){
                $this->_view->_error = "Campo Clave es obligatorio";
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            if(!$this->getTexto('txtPass2')){
                $this->_view->_error = "Campo Validar es obligatorio";
                $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
                exit;
            }
            
            $this->_view->query = $this->_post->agregarUsuario($this->getTexto('txtNombre'),
                                         $this->getTexto('txtCorreo'),
                                         $this->getTexto('txtClave'),
                                         $this->getTexto('txtPregunta'),
                                         $this->getTexto('txtRespuesta'),
                                         $this->getInteger('txtIntentos'),
                                         $this->getTexto('txtFoto'),
                                         $this->getTexto('txtUnidadAcademica')
                    );
            $this->redireccionar('admCrearUsuario');
        }
            
        $this->_view->renderizarAdm('agregarUsuario', 'admCrearUsuario');
    }
    
    public function eliminarUsuario(){
        
    }
    
    public function actualizarUsuario(){
        
    }
    
}

?>
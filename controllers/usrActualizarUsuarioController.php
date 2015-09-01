<?php
/**
 * Description of usrActualizarUsuarioController
 *
 * @author Rickardo
 */
class usrActualizarUsuarioController extends Controller{
    
     public function __construct() {
        parent::__construct();
        //$this->_actualizarUSR = $this->loadModel(USRH_FOLDER,'usrActualizarUsuario');
    }

    public function index(){
        $this->_view->titulo = APP_TITULO;
        $this->_view->renderizarUsrHistoria('usrActualizarUsuario', 'usrActualizarUsuario');
    }
    
    public function activarCuentaEst(){
        $this->_view->titulo = 'Activar Cuenta - ' . APP_TITULO;
        //$this->_view->setJs(ADM_FOLDER,array('agregarUsuario'));
        $this->_view->setPublicJs(array('jquery.validate'));
        
        $this->_view->renderizar(USRH_FOLDER ,'activarCuentaEst', 'usrActualizarUsuario');
    }
    
    public function activarCuentaCat(){
        
    }
    
    public function activarCuentaEmp(){
        
    }
    
}

?>
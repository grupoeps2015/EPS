<?php

/**
 * Description of errorController
 *
 * @author Rickardo
 */

class errorController extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
            
    public function index($codigo = 0){
        $this->_view->titulo = 'Error';
        $this->_view->mensaje = 'Error';
        $this->_view->detalle = $this->getError($codigo);
        $this->_view->renderizar('index');
    }
    
    public function login($codigo, $funcion){
        $this->_view->titulo = 'Error';
        $this->_view->mensaje = 'Error de Login';
        $this->_view->detalle = 'Funci&oacute;n: ' . $funcion . '<br/>' . $this->getError($codigo);
        $this->_view->renderizar('login');
    }
    
    public function sql($codigo, $funcion){
        $this->_view->titulo = 'Error';
        $this->_view->mensaje = 'Error de SQL';
        $this->_view->detalle = 'Funci&oacute;n: ' . $funcion . '<br/>' . $this->getError($codigo);
        $this->_view->renderizar('index');
    }
    
    private function getError($codigo = false){
        if($codigo){
            if(is_numeric($codigo)){
                $codigo = $codigo;
            }
        }else{
            $codigo = 'default';
        }
        
        $error['default'] = "Ha ocurrido un error desconocido y la página no puede mostrarse";
        $error['1000'] = "Acceso Restringido";
        $error['1101'] = "Error al insertar datos";
        $error['1102'] = "Error al eliminar datos";
        $error['1103'] = "Error al actualizar datos";
        $error['1104'] = "Error al consultar datos";
        $error['1200'] = "Error de ajaxModel consultando datos";
        
        if(array_key_exists($codigo, $error)){
            return $error[$codigo];
        }else{
            return $error['default'];
        }
    }
}
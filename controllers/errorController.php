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
            
    public function index(){
        $this->_view->titulo = 'Error';
        $this->_view->mensaje = 'Error';
        $this->_view->detalle = $this->getError();
        $this->_view->renderizar('index');
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
        $error['1102'] = "Error al actualiza datos";
        $error['1103'] = "Error al eliminar datos";
        $error['1104'] = "Error al consultar datos";
        
        if(array_key_exists($codigo, $error)){
            return $error[$codigo];
        }else{
            return $error['default'];
        }
    }
}
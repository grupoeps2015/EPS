<?php

/**
 * Description of gestionNotas
 *
 * @author Rickardo
 */

class errorController extends Controller {
    
    public function __construct() {
        parent::__construct();
    }
            
    public function index(){
        $this->_view->titulo = 'Error';
        $this->_view->mensaje = $this->getError();
        $this->_view->renderizar('index');
    }
    
    public function acceso(){
        $this->_view->titulo = 'Error';
        $this->_view->mensaje = $this->getError(1000);
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
        
        if(array_key_exists($codigo, $error)){
            return $error[$codigo];
        }else{
            return $error['default'];
        }
        
    }
}
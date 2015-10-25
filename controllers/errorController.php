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
    
    public function noRol($codigo){
        $this->_view->titulo = 'Error de credenciales';
        $this->_view->mensaje = 'Error de credenciales';;
        $this->_view->detalle = $this->getError($codigo);
        $this->_view->renderizar('noRol');
    }
    
    public function asign($codigo, $razon){
        $this->_view->titulo = 'Error';
        $this->_view->mensaje = 'Error de asignación';
        $this->_view->detalle = 'Raz&oacute;n: ' . $this->getRazon($razon) . '<br/>' . $this->getError($codigo);
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
        $error['1000'] = "<b>\"Acceso Restringido\"</b><br/>No tiene permisos para acceder a esta funci&oacute;n";
        $error['1101'] = "Error al insertar datos";
        $error['1102'] = "Error al eliminar datos";
        $error['1103'] = "Error al actualizar datos";
        $error['1104'] = "Error al consultar datos";
        $error['1200'] = "Error de ajaxModel consultando datos";
        $error['1300'] = "Error al crear asignación de cursos";
        
        if(array_key_exists($codigo, $error)){
            return $error[$codigo];
        }else{
            return $error['default'];
        }
    }
    
    private function getRazon($codigo = false){
        if($codigo){
            if(is_numeric($codigo)){
                $codigo = $codigo;
            }
        }else{
            $codigo = 'default';
        }
        
        $error['default'] = "Ha ocurrido un error desconocido";
        $error['10'] = "No existe período de asignación activo para este ciclo";
        $error['11'] = "Cantidad de intentos de asignación por ciclo excede el límite establecido en parámetro";
        $error['12'] = "Cursos a asignar superan el límite establecido en parámetro";
        $error['13'] = "Curso no acepta traslape";
        $error['14'] = "Cursos traslapados sobrepasan el máximo establecido por parámetro";
        $error['15'] = "Tiempo de traslape entre cursos sobrepasa el máximo establecido por parámetro";
        $error['16'] = "Tiempo de traslape entre cursos sobrepasa el máximo establecido por parámetro";
        $error['17'] = "No existe criterio de tiempo de traslape entre cursos";
        $error['18'] = "No hay cupo disponible en esta sección";
        
        if(array_key_exists($codigo, $error)){
            return $error[$codigo];
        }else{
            return $error['default'];
        }
    }
}
<?php

/**
 * Description of gestionAreaController
 *
 * @author amoino   
 */
class gestionAreaController extends Controller {

    private $_post;
    private $_encriptar;
    private $_ajax;

    public function __construct() {
        parent::__construct();
        $this->getLibrary('session');
        $this->_session = new session();
        if(!$this->_session->validarSesion()){
            $this->redireccionar('login/salir');
            exit;
        }
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel('gestionArea');
        $this->_ajax = $this->loadModel("ajax");
    }
    
    public function listadoArea() {
        //session_start();
        $rol = $_SESSION["rol"];        
        $rolValidoGestion = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_GESTIONAREA);
        $rolValidoAgregar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_CREARAREA);
        $rolValidoModificar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_MODIFICARAREA);
        $rolValidoEliminar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_ELIMINARAREA);
        $this->_view->permisoGestion = $rolValidoGestion[0]["valido"];
        $this->_view->permisoAgregar = $rolValidoAgregar[0]["valido"];
        $this->_view->permisoModificar = $rolValidoModificar[0]["valido"];
        $this->_view->permisoEliminar = $rolValidoEliminar[0]["valido"];
                    
        if($this->_view->permisoGestion!=PERMISO_GESTIONAR){        
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionPensum/inicio';
                </script>";
        }
        
        $info = $this->_post->allAreas();
        if(is_array($info)){
            $this->_view->lstArea = $info;
        }else{
            $this->redireccionar("error/sql/" . $info);
            exit;
        }
        
        $this->_view->titulo = 'Gestión de Areas - ' . APP_TITULO;
        $this->_view->setJs(array('listadoAreas'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('listadoAreas');
        
    }
    
    public function index($id=0){
//        if($this->getInteger('hdArea')){
//            $idArea = $this->getInteger('hdArea');
//        }else{
//            $idArea = $id;
//        }
//        $this->_view->id = $idArea;
//
//        $info = $this->_post->consultaArea($idArea);
//        if(is_array($info)){
//            $this->_view->lstArea = $info;                
//        }else{
//            $this->redireccionar("error/sql/" . $info);
//            exit;
//        }

        $this->_view->titulo = 'Gestión de Areas - ' . APP_TITULO;
        $this->_view->setJs(array('gestionArea'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('gestionArea');
        
    }
    
     public function actualizarArea($intIdArea = 0) {
//        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_MODIFICARAREA);
       
        if($rolValido[0]["valido"]!= PERMISO_MODIFICAR){
           echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionArea/listadoArea/" . "';
                </script>";
        }
        
        $valorPagina = $this->getInteger('hdEnvio');
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarArea'));
        $this->_view->setCSS(array('jquery.dataTables.min'));
        
        $arrayEdif = array();
        $this->_view->id = $intIdArea;
        
        $datosEdif = $this->_post->consultaArea($intIdArea);
        if(is_array($datosEdif)){
            $this->_view->datosEdif = $datosEdif;
        }else{
            $this->redireccionar("error/sql/" . $datosEdif);
            exit;
        }
        
        if ($valorPagina == 1) {
            $arrayEdif["edificio"] = $intIdArea;  
            $arrayEdif["nombre"] = $this->getTexto('txtNombre');         
            $arrayEdif["descripcion"] = $this->getTexto('txtDescripcion');         
            
            $info = $this->_post->actualizarArea($arrayEdif);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
             
            $this->redireccionar('gestionArea/listadoArea');
       
        }
        $this->_view->renderizar('actualizarArea', 'gestionArea');
    }

    public function agregarArea() {
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_CREARAREA);
         
        if($rolValido[0]["valido"]!= PERMISO_CREAR){
           echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionArea/listadoArea/" . "';
                </script>";
        }
        
        $this->_view->titulo = 'Agregar Area - ' . APP_TITULO;
        $this->_view->setJs(array('agregarArea'));
        $this->_view->setJs(array('jquery.validate'), "public");
        $arrayCar = array();

        if ($this->getInteger('hdEnvio')) {
            $nombreArea = $this->getTexto('txtNombre');
            $nombreDescripcion = $this->getTexto('txtDescripcion');

            $arrayCar['nombre'] = $nombreArea;
            $arrayCar['descripcion'] = $nombreDescripcion;
            $arrayCar['estado'] = ESTADO_PENDIENTE;
            $this->_post->agregarArea($arrayCar);
            $this->redireccionar('gestionArea/listadoArea');
        }

        $this->_view->renderizar('agregarArea', 'gestionArea');
    }
    
     public function activarDesactivarArea($intNuevoEstado, $intIdArea) {
//        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_ELIMINARAREA);
        
        if($rolValido[0]["valido"]== PERMISO_ELIMINAR){
            if ($intNuevoEstado == ESTADO_INACTIVO || $intNuevoEstado == ESTADO_ACTIVO) {
                $info = $this->_post->activarDesactivarArea($intIdArea, $intNuevoEstado);

                if(!is_array($info)){
                    $this->redireccionar("error/sql/" . $info);
                    exit;
                }
                $this->redireccionar('gestionArea/listadoArea');
            } else {
                echo "Error al desactivar el area";
            }
        }
        else
        {
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionArea/listadoArea" . "';
                </script>";
        }
        
    }       
}
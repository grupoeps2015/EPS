<?php

/**
 * Description of gestionPensumController
 *
 * @author Arias
 */
class gestionPensumController extends Controller {

    private $_post;
    private $_encriptar;
    private $_ajax;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel('gestionPensum');
        $this->_ajax = $this->loadModel("ajax");
    }

    public function index() {
         session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_CREARCARRERA);
         
        if($rolValido[0]["valido"]!= PERMISO_GESTIONAR){
           echo "<script>
                alert('No tiene permisos para acceder a esta función.');
                window.location.href='" . BASE_URL . "login/inicio';
                </script>";
        }
        
           
                $idCentroUnidad = $_SESSION["centrounidad"];
            
        $this->_view->id = $idCentroUnidad;
        $info = $this->_post->informacionCarrera($idCentroUnidad);
            if(is_array($info)){
                $this->_view->lstCar = $info;
            }else{
                $this->redireccionar("error/sql/" . $info);
                exit;
            }

            $this->_view->titulo = 'Gestión de carreras - ' . APP_TITULO;
            $this->_view->setJs(array('gestionCarrera'));
            $this->_view->setJs(array('jquery.dataTables.min'), "public");
            $this->_view->setCSS(array('jquery.dataTables.min'));

            $this->_view->renderizar('gestionCarrera');
        
    }
    
    public function inicio(){
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONPENSUM);
                    
        if($rolValido[0]["valido"]!=PERMISO_GESTIONAR){          
            echo "<script>
                alert('No tiene permisos para acceder a esta función.');
                window.location.href='" . BASE_URL . "login/inicio';
                </script>";
        }
           
            $this->_view->renderizar('inicio');
        
    }
    
    public function listadoCarrera() {
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONCARRERA);
                    
        if($rolValido[0]["valido"]!=PERMISO_GESTIONAR){         
            echo "<script>
                alert('No tiene permisos para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionPensum/inicio';
                </script>";
        }
         
            
                $idCentroUnidad = $_SESSION["centrounidad"];
            
            $this->_view->id = $idCentroUnidad;
            
            $info = $this->_post->informacionCarrera($idCentroUnidad);
            if(is_array($info)){
                $this->_view->lstCar = $info;
            }else{
                $this->redireccionar("error/sql/" . $info);
                exit;
            }

            $this->_view->titulo = 'Gestión de carreras - ' . APP_TITULO;
            $this->_view->setJs(array('gestionCarrera'));
            $this->_view->setJs(array('jquery.dataTables.min'), "public");
            $this->_view->setCSS(array('jquery.dataTables.min'));

            $this->_view->renderizar('gestionCarrera');
        
    }

    public function agregarCarrera() {
        session_start();
        
        $idCentroUnidad = $_SESSION["centrounidad"];
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_CREARCARRERA);
         
        if($rolValido[0]["valido"]!= PERMISO_CREAR){
           echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionPensum/listadoCarrera/" . "';
                </script>";
        }
        
        $this->_view->idCentroUnidad = $idCentroUnidad;
        
        $this->_view->titulo = 'Agregar Carrera - ' . APP_TITULO;
        $this->_view->setJs(array('agregarCarrera'));
        $this->_view->setJs(array('jquery.validate'), "public");
        $arrayCar = array();
        
        if ($this->getInteger('hdEnvio')) {
            $nombreCarrera = $this->getTexto('txtNombre');
            $arrayCar['nombre'] = $nombreCarrera;
            $arrayCar['estado'] = ESTADO_PENDIENTE;
            $arrayCar['centrounidadacademica'] = $idCentroUnidad;
            
            $info = $this->_post->agregarCarrera($arrayCar);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            $this->redireccionar('gestionPensum/listadoCarrera');
        }
        $this->_view->renderizar('agregarCarrera', 'gestionPensum');    
    }
    
    public function eliminarCarrera($intNuevoEstado, $intIdCarrera) {
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_ELIMINARCARRERA);
        
        if($rolValido[0]["valido"]== PERMISO_ELIMINAR){
            if ($intNuevoEstado == -1 || $intNuevoEstado == 1) {
                $info = $this->_post->eliminarCarrera($intIdCarrera, $intNuevoEstado);
                if(!is_array($info)){
                    $this->redireccionar("error/sql/" . $info);
                    exit;
                }
                $this->redireccionar('gestionPensum/listadoCarrera');
            } else {
                echo "Error al desactivar carrera";
            }
        }
        else
        {
            echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionPensum/listadoCarrera/" . "';
                </script>";
        }
    }
    
    public function actualizarCarrera($intIdCarrera = 0) {
        session_start();
        
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarCarrera'));
        
        $arrayCar = array();
        
        $this->_view->id = $intIdCarrera; 
        
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_MODIFICARCARRERA);
         
        if($rolValido[0]["valido"]!= PERMISO_MODIFICAR){
           echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionPensum/listadoCarrera" . "';
                </script>";
        }
        
        $info = $this->_post->datosCarrera($intIdCarrera);
        if(is_array($info)){
            $this->_view->datosCar = $info;
        }else{
            $this->redireccionar("error/sql/" . $info);
            exit;
        }
        
        $this->_view->titulo = 'Actualizar Carrera - ' . APP_TITULO;
        $this->_view->renderizar('actualizarCarrera', 'gestionPensum');
        if ($this->getInteger('hdEnvio')) {
            $nombreCarrera = $this->getTexto('txtNombre');

            $arrayCar['id'] = $intIdCarrera;
            $arrayCar['nombre'] = $nombreCarrera;
            $respuesta = $this->_post->actualizarCarrera($arrayCar);
            if (is_array($respuesta)){
                $this->redireccionar('gestionPensum/actualizarCarrera/'. $intIdCarrera );
            }else{
                $this->redireccionar("error/sql/" . $respuesta);
                exit;
            }
        }
        
    }
    
    public function cargarCSV(){
//        $iden = $this->getInteger('hdFile');
//        $fileName = "";
//        $fileExt = "";
//        $rol = "";
//        
//        if($iden == 1){
//            $fileName=$_FILES['csvFile']['name'];
//            $fileExt = explode(".",$fileName);
//            if(strtolower(end($fileExt)) == "csv"){
//                $fileName=$_FILES['csvFile']['tmp_name'];
//                $handle = fopen($fileName, "r");
//                while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
//                    $arrayCur = array();
//                    $arrayCur['tipocurso'] = $data[2];
//                    $arrayCur['codigo'] = $data[0];
//                    $arrayCur['nombre'] = $data[1];
//                    $arrayCur['traslape'] = $data[3];
//                    $arrayCur['estado'] = $data[4];
//                    $this->_post->agregarCurso($arrayCur);
//    
//                }
//                fclose($handle);
//                $this->redireccionar('gestionCurso');
//            }else{
//                echo "<script>alert('El archivo cargado no cumple con el formato csv');</script>";
//            }
//        }
//        $this->redireccionar('gestionCurso/agregarCurso');
    }
}
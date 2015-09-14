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
        $this->_view->lstCur = $this->_post->informacionCurso();
        $this->_view->titulo = 'Gestión de cursos - ' . APP_TITULO;
        $this->_view->setJs(array('gestionCurso'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));
        $this->_view->renderizar('gestionCurso');
        
        
    }
    
    public function inicio(){
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_CREARPENSUM);
                    
        if($rolValido[0]["valido"]!=0){        
            $this->_view->renderizar('inicio');
        }
        else
        {         
            echo "<script>
                alert('No tiene permisos para acceder a esta función.');
                window.location.href='" . BASE_URL . "login/inicio';
                </script>";
        }
    }
    
    public function listadoCarrera() {
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONCARRERA);
                    
        if($rolValido[0]["valido"]!=0){        
            if($this->getInteger('hdCentroUnidad')){
                $idCentroUnidad = $this->getInteger('hdCentroUnidad');
            }else{
                $idCentroUnidad = CENTRO_UNIDADACADEMICA;
            }

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
        else
        {         
            echo "<script>
                alert('No tiene permisos para acceder a esta función.');
                window.location.href='" . BASE_URL . "login/inicio';
                </script>";
        }
    }

    public function agregarCarrera() {
        $this->_view->titulo = 'Agregar Carrera - ' . APP_TITULO;
        $this->_view->setJs(array('agregarCarrera'));
        $this->_view->setJs(array('jquery.validate'), "public");
        $arrayCar = array();
        
        if ($this->getInteger('hdEnvio')) {
            $nombreCarrera = $this->getTexto('txtNombre');
            $arrayCar['nombre'] = $nombreCarrera;
            $arrayCar['estado'] = ESTADO_ACTIVO;
            $arrayCar['centrounidadacademica'] = CENTRO_UNIDADACADEMICA;
            
            $info = $this->_post->agregarCarrera($arrayCar);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            $this->redireccionar('gestionPensum/inicio');
        }
        $this->_view->renderizar('agregarCarrera', 'gestionPensum');    
    }
    
    public function eliminarCarrera($intNuevoEstado, $intIdCarrera) {
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
    
    public function actualizarCarrera($intIdCarrera = 0) {
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarCarrera'));
        
        $arrayCar = array();
        
        $this->_view->id = $intIdCarrera;
        $info = $this->_post->datosCarrera($intIdCarrera);
        if(is_array($info)){
            $this->_view->datosCar = $info;
        }else{
            $this->redireccionar("error/sql/" . $info);
            exit;
        }
        
        $this->_view->titulo = 'Actualizar Carrera - ' . APP_TITULO;
        
        if ($this->getInteger('hdEnvio')) {
            $nombreCarrera = $this->getTexto('txtNombre');

            $arrayCar['id'] = $intIdCarrera;
            $arrayCar['nombre'] = $nombreCarrera;
            $respuesta = $this->_post->actualizarCarrera($arrayCar);
            if (is_array($respuesta)){
                $this->redireccionar('gestionPensum/listadoCarrera');
            }else{
                $this->redireccionar("error/sql/" . $respuesta);
                exit;
            }
        }
        $this->_view->renderizar('actualizarCarrera', 'gestionPensum');
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
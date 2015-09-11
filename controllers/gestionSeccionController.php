<?php

/**
 * Description of gestionSeccionController
 *
 * @author Arias
 */
class gestionSeccionController extends Controller {

    private $_post;
    private $_encriptar;

    private $_ajax;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel('gestionSeccion');
        $this->_postCurso = $this->loadModel('gestionCurso');
        $this->_ajax = $this->loadModel("ajax");
    }

    public function index($id=0) {
        if($this->getInteger('hdCentroUnidad')){
            $idCentroUnidad = $this->getInteger('hdCentroUnidad');
        }else if ($id != 0){
            $idCentroUnidad = $id;
        }else{
            session_start();
            $idCentroUnidad = $_SESSION["centrounidad"];
        }
        $this->_view->id= $idCentroUnidad;
        
        $lstSec = $this->_post->informacionSeccion($idCentroUnidad);
        if(is_array($lstSec)){
            $this->_view->lstSec = $lstSec;
        }else{
            $this->redireccionar("error/sql/" . $lstSec);
            exit;
        }
        
        $this->_view->titulo = 'Gestión de secciones - ' . APP_TITULO;
        $this->_view->setJs(array('gestionSeccion'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));
        $this->_view->renderizar('gestionSeccion');
    }

    public function agregarSeccion() {
        $idCentroUnidad = $this->getInteger('hdCentroUnidad');
        
        $secciones = $this->_post->getTiposSeccion();
        if(is_array($secciones)){
            $this->_view->tiposSeccion = $secciones;
        }else{
            $this->redireccionar("error/sql/" . $secciones);
            exit;
        }
        
        $cursos = $this->_postCurso->informacionCurso(CENTRO_UNIDADACADEMICA);
        if(is_array($cursos)){
            $this->_view->cursos = $cursos;
        }else{
            $this->redireccionar("error/sql/" . $cursos);
            exit;
        }
        
        $this->_view->titulo = 'Agregar Sección - ' . APP_TITULO;
        $this->_view->id = $idCentroUnidad;
        $this->_view->setJs(array('agregarSeccion'));
        $this->_view->setJs(array('jquery.validate'), "public");
        $arraySec = array();
        
        if ($this->getInteger('hdEnvio')) {
            $tipoSeccion = $this->getInteger('slTiposSeccion');
            $nombreSeccion = $this->getTexto('txtNombre');
            $descSeccion = $this->getTexto('txtDesc');
            $curso = $this->getTexto('slCursos');

            $arraySec['tiposeccion'] = $tipoSeccion;
            $arraySec['descripcion'] = $descSeccion;
            $arraySec['nombre'] = $nombreSeccion;
            $arraySec['curso'] = $curso;
            $arraySec['estado'] = ESTADO_ACTIVO;

            $info = $this->_post->agregarSeccion($arraySec);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            
            $this->redireccionar('gestionSeccion/index/'.$idCentroUnidad);
        }
        
        $this->_view->renderizar('agregarSeccion', 'gestionSeccion');    
    }
    
    public function eliminarSeccion($intNuevoEstado, $intIdSeccion, $idCentroUnidad) {
        if ($intNuevoEstado == -1 || $intNuevoEstado == 1) {
            $info = $this->_post->eliminarSeccion($intIdSeccion, $intNuevoEstado);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            $this->redireccionar('gestionSeccion/index/'.$idCentroUnidad);
        } else {
            echo "Error al desactivar sección";
        }
    }
    
    public function actualizarSeccion($intIdSeccion = 0, $idCentroUnidad = 0) {
        $arraySec = array();
        
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarSeccion'));
        
        $this->_view->id = $intIdSeccion;
        $this->_view->idCentroUnidad = $idCentroUnidad;
        
        $this->_view->titulo = 'Actualizar Sección - ' . APP_TITULO;
        
        $secciones = $this->_post->getTiposSeccion();
        if(is_array($secciones)){
            $this->_view->tiposSeccion = $secciones;
        }else{
            $this->redireccionar("error/sql/" . $secciones);
            exit;
        }
        
        $info = $this->_post->datosSeccion($intIdSeccion);
        if(is_array($info)){
            $this->_view->datosSec = $info;
        }else{
            $this->redireccionar("error/sql/" . $info);
            exit;
        }
        
        $cursos = $this->_postCurso->informacionCurso(CENTRO_UNIDADACADEMICA);
        if(is_array($cursos)){
            $this->_view->cursos = $cursos;
        }else{
            $this->redireccionar("error/sql/" . $cursos);
            exit;
        }
        
        if ($this->getInteger('hdEnvio')) {
            $tipoSeccion = $this->getInteger('slTiposSeccion');
            $nombreSeccion = $this->getTexto('txtNombre');
            $descSeccion = $this->getTexto('txtDesc');
            $curso = $this->getTexto('slCursos');

            $arraySec['id'] = $intIdSeccion;
            $arraySec['tiposeccion'] = $tipoSeccion;
            $arraySec['descripcion'] = $descSeccion;
            $arraySec['nombre'] = $nombreSeccion;
            $arraySec['curso'] = $curso;

            $respuesta = $this->_post->actualizarSeccion($arraySec);
            if (is_array($respuesta)){
                $this->redireccionar('gestionSeccion/index/'. $idCentroUnidad);
            }else{
                $this->redireccionar("error/sql/" . $respuesta);
                exit;
            }
        }
        $this->_view->renderizar('actualizarSeccion', 'gestionSeccion');
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
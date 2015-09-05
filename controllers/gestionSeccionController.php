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

    public function index() {
        $this->_view->lstSec = $this->_post->informacionSeccion(CENTRO_REGIONAL, UNIDAD_ACADEMICA);
        $this->_view->titulo = 'Gestión de secciones - ' . APP_TITULO;
        $this->_view->setJs(array('gestionSeccion'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('gestionSeccion');
    }

    public function agregarSeccion() {
        $this->_view->tiposSeccion = $this->_post->getTiposSeccion();
        $this->_view->cursos = $this->_postCurso->informacionCurso(CENTRO_REGIONAL, UNIDAD_ACADEMICA);
        $this->_view->titulo = 'Agregar Sección - ' . APP_TITULO;
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

            $this->_post->agregarSeccion($arraySec);
            $this->redireccionar('gestionSeccion');
        }
        
        $this->_view->renderizar('agregarSeccion', 'gestionSeccion');    
    }
    
    public function eliminarSeccion($intNuevoEstado, $intIdSeccion) {
        if ($intNuevoEstado == -1 || $intNuevoEstado == 1) {
            $this->_post->eliminarSeccion($intIdSeccion, $intNuevoEstado);

            $this->redireccionar('gestionSeccion');
        } else {
            echo "Error al desactivar sección";
        }
    }
    
    public function actualizarSeccion($intIdSeccion = 0) {
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarSeccion'));
        
        $this->_view->tiposSeccion = $this->_post->getTiposSeccion();
        $this->_view->cursos = $this->_postCurso->informacionCurso(CENTRO_REGIONAL, UNIDAD_ACADEMICA);
        $arraySec = array();
        $actualizar = false;
        $this->_view->id = $intIdSeccion;
        $this->_view->datosSec = $this->_post->datosSeccion($intIdSeccion);
        $this->_view->titulo = 'Actualizar Sección - ' . APP_TITULO;
        
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
            if (isset($respuesta[0][0])){
                $this->redireccionar('gestionSeccion');
            }
        }
        $this->_view->renderizar('actualizarSeccion', 'gestionSeccion');
    }
    
    public function cargarCSV(){
        $iden = $this->getInteger('hdFile');
        $fileName = "";
        $fileExt = "";
        $rol = "";
        
        if($iden == 1){
            $fileName=$_FILES['csvFile']['name'];
            $fileExt = explode(".",$fileName);
            if(strtolower(end($fileExt)) == "csv"){
                $fileName=$_FILES['csvFile']['tmp_name'];
                $handle = fopen($fileName, "r");
                while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
                    $arrayCur = array();
                    $arrayCur['tipocurso'] = $data[2];
                    $arrayCur['codigo'] = $data[0];
                    $arrayCur['nombre'] = $data[1];
                    $arrayCur['traslape'] = $data[3];
                    $arrayCur['estado'] = $data[4];
                    $this->_post->agregarCurso($arrayCur);
    
                }
                fclose($handle);
                $this->redireccionar('gestionCurso');
            }else{
                echo "<script>alert('El archivo cargado no cumple con el formato csv');</script>";
            }
        }
        $this->redireccionar('gestionCurso/agregarCurso');
        
    }
}
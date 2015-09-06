<?php

/**
 * Description of gestionHorarioController
 *
 * @author Arias
 */
class gestionHorarioController extends Controller {

    private $_post;
    private $_encriptar;

    private $_ajax;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel('gestionHorario');
        $this->_postSeccion = $this->loadModel('gestionSeccion');
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
    
    public function seleccionarCicloCurso(){
        $this->_view->lstTipos = $this->_ajax->getTipoCiclo();
        $this->_view->lstSec = $this->_postSeccion->informacionSeccion(CENTRO_UNIDADACADEMICA);
        $this->_view->titulo = 'Seleccionar Ciclo y Sección por Curso - ' . APP_TITULO;
        $this->_view->url = "";
        $this->_view->setJs(array('seleccionarCicloCurso'));
        $this->_view->renderizar('seleccionarCicloCurso');
    }
    
    public function listadoCarrera() {
        if($this->getInteger('hdCentroUnidad')){
            $idCentroUnidad = $this->getInteger('hdCentroUnidad');
        }else{
            $idCentroUnidad = CENTRO_UNIDADACADEMICA;
        }
        $this->_view->lstCar = $this->_post->informacionCarrera($idCentroUnidad);
        $this->_view->titulo = 'Gestión de carreras - ' . APP_TITULO;
        $this->_view->setJs(array('gestionCarrera'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('gestionCarrera');
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
            $this->_post->agregarCarrera($arrayCar);
            $this->redireccionar('gestionPensum/inicio');
        }
        
        $this->_view->renderizar('agregarCarrera', 'gestionPensum');    
    }
    
    public function eliminarCarrera($intNuevoEstado, $intIdCarrera) {
        if ($intNuevoEstado == -1 || $intNuevoEstado == 1) {
            $this->_post->eliminarCarrera($intIdCarrera, $intNuevoEstado);

            $this->redireccionar('gestionPensum/listadoCarrera');
        } else {
            echo "Error al desactivar carrera";
        }
    }
    
    public function actualizarCarrera($intIdCarrera = 0) {
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarCarrera'));
        
        $arrayCar = array();
        $actualizar = false;
        $this->_view->id = $intIdCarrera;
        $this->_view->datosCar = $this->_post->datosCarrera($intIdCarrera);
        $this->_view->titulo = 'Actualizar Carrera - ' . APP_TITULO;
        
        if ($this->getInteger('hdEnvio')) {
            $nombreCarrera = $this->getTexto('txtNombre');

            $arrayCar['id'] = $intIdCarrera;
            $arrayCar['nombre'] = $nombreCarrera;
            $respuesta = $this->_post->actualizarCarrera($arrayCar);
            if (isset($respuesta[0][0])){
                $this->redireccionar('gestionPensum/listadoCarrera');
            }
        }
        $this->_view->renderizar('actualizarCarrera', 'gestionPensum');
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
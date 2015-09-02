<?php

/**
 * Description of gestionCursoController
 *
 * @author Arias
 */
class gestionCursoController extends Controller {

    private $_post;
    private $_encriptar;

    private $_ajax;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel('gestionCurso');
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

    public function agregarCurso() {
        $this->_view->tiposCurso = $this->_post->getTiposCurso();
        $this->_view->titulo = 'Agregar Curso - ' . APP_TITULO;
        $this->_view->setJs(array('agregarCurso'));
        $this->_view->setJs(array('jquery.validate'), "public");
        $arrayCur = array();
        
        if ($this->getInteger('hdEnvio')) {
            $tipoCurso = $this->getInteger('slTiposCurso');
            $codigoCurso = $this->getTexto('txtCodigo');
            $nombreCurso = $this->getTexto('txtNombre');
            $traslapeCurso = $this->getTexto('slTraslape');

            $arrayCur['tipocurso'] = $tipoCurso;
            $arrayCur['codigo'] = $codigoCurso;
            $arrayCur['nombre'] = $nombreCurso;
            $arrayCur['traslape'] = $traslapeCurso;
            $arrayCur['estado'] = 1;

            $this->_post->agregarCurso($arrayCur);
            $this->redireccionar('gestionCurso');
        }
        
        $this->_view->renderizar('agregarCurso', 'gestionCurso');    
    }
    
    public function eliminarCurso($intNuevoEstado, $intIdCurso) {
        if ($intNuevoEstado == -1 || $intNuevoEstado == 1) {
            $this->_post->eliminarCurso($intIdCurso, $intNuevoEstado);

            $this->redireccionar('gestionCurso');
        } else {
            echo "Error al desactivar curso";
        }
        //$this->redireccionar('admHistoriaCrearCurso');
        //$this->_view->cambio = $intNuevoEstado;
        //$this->_view->titulo = 'Eliminar curso - ' . APP_TITULO;
        //$this->_view->renderizar(ADM_FOLDER, 'eliminarUsuario', 'admCrearUsuario');
    }
    
    public function actualizarCurso($intIdCurso = 0) {
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarCurso'));
        
        $this->_view->tiposCurso = $this->_post->getTiposCurso();
        $arrayUsr = array();
        $actualizar = false;
        $this->_view->id = $intIdCurso;
        $this->_view->datosCur = $this->_post->datosCurso($intIdCurso);
        $this->_view->titulo = 'Actualizar curso - ' . APP_TITULO;
        
        if ($this->getInteger('hdEnvio')) {
            $tipoCurso = $this->getInteger('slTiposCurso');
            $codigoCurso = $this->getTexto('txtCodigo');
            $nombreCurso = $this->getTexto('txtNombre');
            $traslapeCurso = $this->getTexto('slTraslape');

            $arrayCur['id'] = $intIdCurso;
            $arrayCur['tipocurso'] = $tipoCurso;
            $arrayCur['codigo'] = $codigoCurso;
            $arrayCur['nombre'] = $nombreCurso;
            $arrayCur['traslape'] = $traslapeCurso;

            $respuesta = $this->_post->actualizarCurso($arrayCur);
            if (isset($respuesta[0][0])){
                $this->redireccionar('gestionCurso');
            }
        }
        $this->_view->renderizar('actualizarCurso', 'gestionCurso');
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
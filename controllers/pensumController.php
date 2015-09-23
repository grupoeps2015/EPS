<?php

/**
 * Description of gestionPensumController
 *
 * @author amoino
 */
class pensumController extends Controller {

    private $_post;
    private $_encriptar;
    private $_ajax;

    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel('pensum');
        $this->_ajax = $this->loadModel("ajax");
    }

    public function index() {
//        session_start();
//        $rol = $_SESSION["rol"];
//        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_CREARCARRERA);
//
//        if ($rolValido[0]["valido"] != PERMISO_GESTIONAR) {
//            echo "<script>
//                alert('No tiene permisos para acceder a esta función.');
//                window.location.href='" . BASE_URL . "login/inicio';
//                </script>";
//        }
//        if ($this->getInteger('hdPensum')) {
//            $idPensum = $this->getInteger('hdPensum');
//        } else if ($id != 0) {
//            $idPensum = $id;
//        } else {
//            session_start();
//            $idPensum = $_SESSION["pensum"];
//        }


        $this->_view->titulo = 'Gestión de Pensum - ' . APP_TITULO;
//        $this->_view->setJs(array('gestionPensum'));
//        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('listadoPensum');
    }

    public function listadoPensum() {
//        session_start();
//        $rol = $_SESSION["rol"];
//        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_GESTIONCARRERA);
//
//        if ($rolValido[0]["valido"] != PERMISO_GESTIONAR) {
//            echo "<script>
//                alert('No tiene permisos para acceder a esta función.');
//                window.location.href='" . BASE_URL . "gestionPensum/inicio';
//                </script>";
//        }
//        if ($this->getInteger('hdPensum')) {
        $pensum = $this->getInteger('hdPensum');
//        } else if ($id != 0) {
//            $pensum = $id;
//        } else {
//            //session_start();
//            $pensum = $_SESSION["pensum"];
//        }
        $this->_view->id = $pensum;
        /* informacionPensum */
        $info = $this->_post->getAllPensum();
        if (is_array($info)) {
            $this->_view->lstPensum = $info;
        } else {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }

        $this->_view->titulo = 'Pensum Registrados - ' . APP_TITULO;
        $this->_view->setJs(array('admPensum'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('listadoPensum');
    }

    public function agregarPensum() {
//        session_start();
//
        $pensum = $this->getInteger('hdPensum');
//        $rol = $_SESSION["rol"];
//        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_CREARCARRERA);
//
//        if ($rolValido[0]["valido"] != PERMISO_CREAR) {
//            echo "<script>
//                alert('No tiene permisos suficientes para acceder a esta función.');
//                window.location.href='" . BASE_URL . "pensum/listadoPensum/" . $pensum . "';
//                </script>";
//        }
//

        $lsCarreras = $this->_view->carreras = $this->_ajax->getAllCarreras();
        if (is_array($lsCarreras)) {
            $this->_view->carreras = $lsCarreras;
        } else {
            $this->redireccionar("error/sql/" . $lsCarreras);
            exit;
        }

        $lsPensumActivos = $this->_post->getAllPensumActivos();
        if (!is_array($lsPensumActivos)) {
            $this->redireccionar("error/sql/" . $lsCarreras);
            exit;
        }

        $this->_view->idPensum = $pensum;


        $this->_view->titulo = 'Agregar Pensum - ' . APP_TITULO;
        $this->_view->setJs(array('agregarPensum'));
        $this->_view->setJs(array('jquery.validate'), "public");
        $arrayPensum = array();

        if ($this->getInteger('hdEnvio')) {
            $carrera = $this->getInteger('slCarreras');

            for ($p = 0; $p < count($lsPensumActivos); $p++) :
                //print_r($lsPensumActivos[$p]['carrera'] . '-' . $lsCarreras[$carrera-1]['nombre']);
                if ($lsPensumActivos[$p]['carrera'] == $lsCarreras[$carrera - 1]['nombre']) {
                    $this->redireccionar("error/sql/yaExiste");
                    exit;
                }

            endfor;


            $tipo = $this->getInteger('slTipos');
            $duracion = $this->getTexto('txtTiempo');
            $descripcion = $this->getTexto('txtDescripcion');
            $inicio = $this->getTexto('inputFecha');


                $arrayPensum['carrera'] = $carrera;
                $arrayPensum['tipo'] = $tipo;
                $arrayPensum['inicioVigencia'] = $inicio;
                $arrayPensum['duracionAnios'] = $duracion;
                $arrayPensum['descripcion'] = $descripcion;

                $info = $this->_post->agregarPensum($arrayPensum);

                if (!is_array($info)) {
                    $this->redireccionar("error/sql/" . $info);
                    exit;
                }
                $this->redireccionar('pensum/listadoPensum');
            }
        $this->_view->renderizar('agregarPensum', 'pensum');
    }

    public function finalizarVigenciaPensum($intIdPensum) {
//        session_start();
//        $rol = $_SESSION["rol"];
//        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_ELIMINARCARRERA);
//
//        if ($rolValido[0]["valido"] == PERMISO_ELIMINAR) {

        $info = $this->_post->spfinalizarVigenciaPensum($intIdPensum);
        if (!is_array($info)) {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }
        $this->redireccionar('pensum/listadoPensum');
//        } else {
//            echo "<script>
//                alert('No tiene permisos suficientes para acceder a esta función.');
//                window.location.href='" . BASE_URL . "gestionPensum/listadoCarrera/" . "';
//                </script>";
//        }
    }

}


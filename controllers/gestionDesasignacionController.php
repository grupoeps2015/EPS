<?php

/**
 * Description of gestionPensumController
 *
 * @author amoino   
 */
class gestionDesasignacionController extends Controller {

    private $_post;
    private $_encriptar;
    private $_ajax;

    public function __construct() {
        parent::__construct();
        $this->getLibrary('session');
        $this->_session = new session();
        if (!$this->_session->validarSesion()) {
            $this->redireccionar('login/salir');
            exit;
        }
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel('gestionDesasignacion');
        $this->_ajax = $this->loadModel("ajax");
    }

    public function listadoAsignaciones($carnet) {

        $info = $this->_post->allAsignaciones($carnet);
        if (is_array($info)) {
            $this->_view->lstAsignaciones = $info;
        } else {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }

        $this->_view->titulo = 'Gestión de Desasignaciones - ' . APP_TITULO;
        $this->_view->setJs(array('listadoAsignaciones'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('listadoAsignaciones');
    }

    public function index() {

        $this->_view->titulo = 'Desasignar Curso - ' . APP_TITULO;
        $this->_view->setJs(array('gestionDesasignacion'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('gestionDesasignacion');
    }

    public function detalleAsignacion($idAsignacion) {

        $info = $this->_post->getAsignacion($idAsignacion);
        if (is_array($info)) {
            $this->_view->asignacion = $info;
        } else {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }

        $this->_view->titulo = 'Desasignar Curso - ' . APP_TITULO;
        $this->_view->setJs(array('listadoAsignaciones'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('desasignarCurso');
    }

    public function desasignarCurso($idEstado, $idAsignacion) {
        $carnet = $this->getInteger('hdCarnet');


//        session_start();
//        $rol = $_SESSION["rol"];        
//        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_ELIMINAREDIFICIO);
//        if($rolValido[0]["valido"]== PERMISO_ELIMINAR){
        if ($idEstado == ESTADO_INACTIVO || $idEstado == ESTADO_ACTIVO) {
            $info = $this->_post->activarDesactivarAsignacion($idAsignacion, $idEstado);
            if (!is_array($info)) {
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            if ($this->getInteger('hdEnvio')) {
                $vDescripcion = $this->getTexto('descripcion');
                $carnet = $this->getInteger('hdCarnet');
                $arrayDes['asignacion'] = $idAsignacion;
                $arrayDes['descripcion'] = $vDescripcion;
                $this->_post->agregarDesasignacion($arrayDes);
                echo "<script>
                alert('Desasignacion de curso para el estudiante ". $carnet." realizada exitosamente.');
                </script>";
                $this->redireccionar('gestionDesasignacion/listadoAsignaciones/'.$carnet);
            }
        } else {
            echo "Error al agregar desasignacion";
        }
    }

//        else
//        {
//            echo "<script>
//                alert('No tiene permisos suficientes para acceder a esta función.');
//                window.location.href='" . BASE_URL . "gestionArea/listadoArea" . "';
//                </script>";
//        }
//}
}
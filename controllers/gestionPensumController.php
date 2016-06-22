<?php

/**
 * Description of gestionPensumController
 *
 * @author Arias, amoino
 */
class gestionPensumController extends Controller {

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
        $this->_post = $this->loadModel('gestionPensum');
        $this->_ajax = $this->loadModel("ajax");
    }

    public function index() {
        $rol = $_SESSION["rol"];
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_GESTIONCARRERA);

        if ($rolValido[0]["valido"] != PERMISO_GESTIONAR) {
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "login/inicio';
                </script>";
        }


        $idCentroUnidad = $_SESSION["centrounidad"];

        $this->_view->id = $idCentroUnidad;
        $info = $this->_post->informacionCarrera($idCentroUnidad);
        if (is_array($info)) {
            $this->_view->lstCar = $info;
        } else {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }

        $this->_view->titulo = 'Gestión de carreras - ' . APP_TITULO;
        $this->_view->setJs(array('gestionCarrera'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('gestionCarrera');
    }

    public function inicio() {
        $rol = $_SESSION["rol"];
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_GESTIONPENSUM);

        if ($rolValido[0]["valido"] != PERMISO_GESTIONAR) {
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "login/inicio';
                </script>";
        }

        $this->_view->renderizar('inicio');
    }

    public function asignarAreaCarrera($intIdCarrera = 0) {
//        session_start();

        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('asignarArea'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $arrayAsignacion = array();

        $this->_view->id = $intIdCarrera;

//        $rol = $_SESSION["rol"];
//        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_MODIFICARCARRERA);
//        if ($rolValido[0]["valido"] != PERMISO_MODIFICAR) {
//            echo "<script>
//                alert('No tiene permisos suficientes para acceder a esta función.');
//                window.location.href='" . BASE_URL . "gestionPensum/listadoCarrera" . "';
//                </script>";
//        }

        $lsAreas = $this->_view->lstAreas = $this->_ajax->getAllAreasCarreraNoAsignadas($intIdCarrera);
        if (is_array($lsAreas)) {
            $this->_view->lstAreas = $lsAreas;
        } else {
            $this->redireccionar("error/sql/" . $lsAreas);
            exit;
        }
        $lsCarAreas = $this->_view->lstCarAreas = $this->_ajax->getAllCarreraAreas($intIdCarrera);
        if (is_array($lsCarAreas)) {
            $this->_view->lstCarAreas = $lsCarAreas;
        } else {
            $this->redireccionar("error/sql/" . $lsCarAreas);
            exit;
        }

        $info = $this->_post->datosCarrera($intIdCarrera);
        if (is_array($info)) {
            $this->_view->datosCar = $info;
        } else {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }

        $this->_view->titulo = 'Asignar Areas Academicas - ' . APP_TITULO;
        $this->_view->renderizar('asignarArea', 'gestionPensum');

        if ($this->getInteger('hdEnvio')) {

            if (isset($_POST['submit'])) {

                if (!empty($_POST['check_list'])) {

                    foreach ($_POST['check_list'] as $selected) {
                        $arrayAsignacion['carrera'] = $intIdCarrera;
                        $arrayAsignacion['area'] = $selected;
                        $arrayAsignacion['estado'] = ESTADO_ACTIVO;
                        $asignacion = $this->_post->asignarAreaCarrera($arrayAsignacion);
                        if (is_array($asignacion)) {
                            $this->insertarBitacoraUsuario(CONS_FUNC_PENSUM_ASIGNARAREACARRERA, "Asignacion ".$intIdCarrera." en el sistema"); 
                            $this->redireccionar('gestionPensum/asignarAreaCarrera/' . $intIdCarrera);
                        } else {
                            $this->redireccionar("error/sql/" . $asignacion);
                            exit;
                        }
//                        echo '<script>alert("' . $selected . '");</script>';
                    }
                }
            }
        }
    }

    public function listadoCarrera($centroUnidad = -1) {
        $rol = $_SESSION["rol"];
        $rolValidoGestion = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONCARRERA);
        $rolValidoAgregar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_CREARCARRERA);
        $rolValidoModificar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_MODIFICARCARRERA);
        $rolValidoEliminar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_ELIMINARCARRERA);
        $this->_view->permisoGestion = $rolValidoGestion[0]["valido"];
        $this->_view->permisoAgregar = $rolValidoAgregar[0]["valido"];
        $this->_view->permisoModificar = $rolValidoModificar[0]["valido"];
        $this->_view->permisoEliminar = $rolValidoEliminar[0]["valido"];

        if ($this->_view->permisoGestion != PERMISO_GESTIONAR) {
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionPensum/inicio';
                </script>";
        }

        if($centroUnidad <= 0){
            $idCentroUnidad = $_SESSION["centrounidad"];
        }else{
            $idCentroUnidad = $centroUnidad;
            $this->_view->vieneDeUnidad = true;
        }

        $this->_view->id = $idCentroUnidad;

        $info = $this->_post->informacionCarrera($idCentroUnidad);
        if (is_array($info)) {
            $this->_view->lstCar = $info;
        } else {
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

        $idCentroUnidad = $_SESSION["centrounidad"];
        $rol = $_SESSION["rol"];
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_CREARCARRERA);

        if ($rolValido[0]["valido"] != PERMISO_CREAR) {
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionPensum/listadoCarrera/" . "';
                </script>";
        }
        $this->_view->idCentroUnidad = $idCentroUnidad;
        $info = $this->_post->getExtensionesCentroUnidad($idCentroUnidad);
        $info = json_decode($info[0][0], true);
        if (is_array($info) || $info == '') {
            foreach(array_keys(array_column($info, 'estado'), '-1') as $key){
                unset($info[$key]);
            }
            foreach(array_keys(array_column($info, 'estado'), '0') as $key){
                unset($info[$key]);
            }
            $this->_view->lstExtensiones = $info;
        } else {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }
        $this->_view->titulo = 'Agregar Carrera - ' . APP_TITULO;
        $this->_view->setJs(array('agregarCarrera'));
        $this->_view->setJs(array('jquery.validate'), "public");
        $arrayCar = array();
        if ($this->getInteger('hdEnvio')) {
            $codigoCarrera = $this->getTexto('txtCodigo');
            $nombreCarrera = $this->getTexto('txtNombre');
            $extension = $this->getTexto('slExtensiones');
            $arrayCar['codigo'] = $codigoCarrera;
            $arrayCar['nombre'] = $nombreCarrera;
            $arrayCar['estado'] = ESTADO_PENDIENTE;
            $arrayCar['centrounidadacademica'] = $idCentroUnidad;
            $arrayCar['extension'] = $extension;
            $info = $this->_post->agregarCarrera($arrayCar);
            if (!is_array($info)) {
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            $this->insertarBitacoraUsuario(CONS_FUNC_CUR_CREARCARRERA, "Carrera ".$nombreCarrera." registrada en el sistema"); 
            $this->redireccionar('gestionPensum/listadoCarrera');
        }
        $this->_view->renderizar('agregarCarrera', 'gestionPensum');
    }
    
    public function eliminarCarreraArea($intIdCarrera,$intNuevoEstado, $intIdCarreraArea) {
//        session_start();
//        $rol = $_SESSION["rol"];
//        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_ELIMINARCARRERA);

//        if ($rolValido[0]["valido"] == PERMISO_ELIMINAR) {
            if ($intNuevoEstado == -1 || $intNuevoEstado == 1) {
                $info = $this->_post->eliminarCarreraArea($intIdCarreraArea, $intNuevoEstado);
                if (!is_array($info)) {
                    $this->redireccionar("error/sql/" . $info);
                    exit;
                }
                $this->insertarBitacoraUsuario(CONS_FUNC_CUR_ELIMINARCARRERAAREA, "Carrera ".$intIdCarrera." - ".$intIdCarreraArea." eliminada del sistema"); 
                $this->redireccionar('gestionPensum/asignarAreaCarrera/'.$intIdCarrera);
            } else {
                echo "Error al desactivar carrera";
            }
//        } else {
//            echo "<script>
//                alert('No tiene permisos suficientes para acceder a esta función.');
//                window.location.href='" . BASE_URL . "gestionPensum/listadoCarrera/" . "';
//                </script>";
//        }
    }

    public function eliminarCarrera($intNuevoEstado, $intIdCarrera) {
        $rol = $_SESSION["rol"];
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_ELIMINARCARRERA);

        if ($rolValido[0]["valido"] == PERMISO_ELIMINAR) {
            if ($intNuevoEstado == -1 || $intNuevoEstado == 1) {
                $info = $this->_post->eliminarCarrera($intIdCarrera, $intNuevoEstado);
                if (!is_array($info)) {
                    $this->redireccionar("error/sql/" . $info);
                    exit;
                }
                $this->insertarBitacoraUsuario(CONS_FUNC_CUR_ELIMINARCARRERA, "Carrera ".$intIdCarrera." eliminada del sistema"); 
                $this->redireccionar('gestionPensum/listadoCarrera');
            } else {
                echo "Error al desactivar carrera";
            }
        } else {
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionPensum/listadoCarrera/" . "';
                </script>";
        }
    }

    public function actualizarCarrera($intIdCarrera = 0) {
        $idCentroUnidad = $_SESSION["centrounidad"];
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarCarrera'));

        $arrayCar = array();

        $this->_view->id = $intIdCarrera;

        $rol = $_SESSION["rol"];
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_MODIFICARCARRERA);

        if ($rolValido[0]["valido"] != PERMISO_MODIFICAR) {
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionPensum/listadoCarrera" . "';
                </script>";
        }
        
        $ext = $this->_post->getExtensionesCentroUnidad($idCentroUnidad);
        $ext = json_decode($ext[0][0], true);
        if (is_array($ext) || $ext == '') {            
            $this->_view->lstExtensiones = $ext;
        } else {
            $this->redireccionar("error/sql/" . $ext);
            exit;
        }

        $info = $this->_post->datosCarrera($intIdCarrera);
        if (is_array($info)) {
            $this->_view->datosCar = $info;
        } else {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }

        $this->_view->titulo = 'Actualizar Carrera - ' . APP_TITULO;
        $this->_view->renderizar('actualizarCarrera', 'gestionPensum');
        if ($this->getInteger('hdEnvio')) {
            $nombreCarrera = $this->getTexto('txtNombre');
            $extension = $this->getTexto('slExtensiones');
            $arrayCar['id'] = $intIdCarrera;
            $arrayCar['nombre'] = $nombreCarrera;
            $arrayCar['extension'] = $extension;
            $respuesta = $this->_post->actualizarCarrera($arrayCar);
            if (is_array($respuesta)) {
                $this->insertarBitacoraUsuario(CONS_FUNC_CUR_MODIFICARCARRERA, "Carrera ".$intIdCarrera." modificada en el sistema");
                $this->redireccionar('gestionPensum/actualizarCarrera/' . $intIdCarrera);
            } else {
                $this->redireccionar("error/sql/" . $respuesta);
                exit;
            }
        }
    }

    public function cargarCSV() {
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

    public function listadoPensum() {
        $idCentroUnidad = $_SESSION["centrounidad"];
        $rol = $_SESSION["rol"];
        $rolValidoGestion = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONPENSUM);
        $rolValidoAgregar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_CREARPENSUM);
        $rolValidoModificar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_MODIFICARPENSUM);
        $rolValidoEliminar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_ELIMINARPENSUM);
        $rolValidoGestionCursoPensum = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONCURSOPENSUM);
        $this->_view->permisoGestion = $rolValidoGestion[0]["valido"];
        $this->_view->permisoAgregar = $rolValidoAgregar[0]["valido"];
        $this->_view->permisoModificar = $rolValidoModificar[0]["valido"];
        $this->_view->permisoEliminar = $rolValidoEliminar[0]["valido"];
        $this->_view->permisoGestionCursosPensum = $rolValidoGestionCursoPensum[0]["valido"];
       
        if ($this->_view->permisoGestion != PERMISO_GESTIONAR) {
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionPensum/inicio';
                </script>";
        }
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
        $info = $this->_post->getAllPensum($idCentroUnidad);
        if (is_array($info)) {
            $this->_view->lstPensum = $info;
        } else {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }

        $this->_view->titulo = 'Pensum Registrados - ' . APP_TITULO;
        $this->_view->setJs(array('listadoPensum'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('listadoPensum');
    }

    public function agregarPensum() {
       // session_start();

        $pensum = $this->getInteger('hdPensum');
        $rol = $_SESSION["rol"];
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_CREARCURSOPENSUM);

        if ($rolValido[0]["valido"] != PERMISO_CREAR) {
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionPensum/listadoPensum/';
                </script>";
        }


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
        $this->_view->setJs(array('jquery-ui'), "public");
        $this->_view->setCss(array('jquery-ui'), "public");
        $arrayPensum = array();

        if ($this->getInteger('hdEnvio')) {
            $carrera = $this->getInteger('slCarreras');

            for ($p = 0; $p < count($lsPensumActivos); $p++) :
                //print_r($lsPensumActivos[$p]['carrera'] . '-' . $lsCarreras[$carrera-1]['nombre']);
                if ($lsPensumActivos[$p]['carrera'] == $lsCarreras[$carrera - 1]['nombre']) {
                    //$this->redireccionar("error/sql/yaExiste");
                    $this->redireccionar('gestionPensum/listadoPensum');
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
            $arrayPensum['estado'] = ESTADO_PENDIENTE;
            $info = $this->_post->agregarPensum($arrayPensum);

            if (!is_array($info)) {
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            $this->insertarBitacoraUsuario(CONS_FUNC_CUR_CREARCURSOPENSUM, "Pensum ".$pensum." agregado al sistema");
            $this->redireccionar('gestionPensum/listadoPensum');
        }
        $this->_view->renderizar('agregarPensum', 'gestionPensum');
    }

    public function finalizarVigenciaPensum($intIdPensum, $estado) {
        //session_start();
        $rol = $_SESSION["rol"];
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_ELIMINARPENSUM);

        if ($rolValido[0]["valido"] == PERMISO_ELIMINAR) {

        $info = $this->_post->spfinalizarVigenciaPensum($intIdPensum, $estado);
        if (!is_array($info)) {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }
        $this->insertarBitacoraUsuario(CONS_FUNC_CUR_ELIMINARPENSUM, "Pensum ".$intIdPensum." eliminado del sistema");
        $this->redireccionar('gestionPensum/listadoPensum');
        } else {
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionPensum/listadoPensum/" . "';
                </script>";
        }
    }

    public function activarPensum($intIdPensum) {
        //session_start();
        $rol = $_SESSION["rol"];
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_ELIMINARPENSUM);

        if ($rolValido[0]["valido"] == PERMISO_ELIMINAR) {

        $info = $this->_post->activarPensum($intIdPensum);
        if (!is_array($info)) {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }
        $this->insertarBitacoraUsuario(CONS_FUNC_CUR_ELIMINARPENSUM, "Pensum ".$intIdPensum." activado en el sistema");
        $this->redireccionar('gestionPensum/listadoPensum');
        } else {
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionPensum/listadoPensum/" . "';
                </script>";
        }
    }

    public function gestionCursoPensum($idPensum = 0, $idCarrera = 0) {

        $iden = $this->getInteger('hdEnvio');
        $idCentroUnidad = $_SESSION["centrounidad"];

        $arrayCurPensum = array();

        $this->_view->idPensum = $idPensum;
        $this->_view->idCarrera = $idCarrera;
        
          $rol = $_SESSION["rol"];        
          $rolValidoGestion = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONCURSOPENSUM);
          $rolValidoAgregar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_CREARCURSOPENSUM);
          $rolValidoModificar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_MODIFICARCURSOPENSUM);
          $rolValidoEliminar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_ELIMINARCURSOPENSUM);
          $this->_view->permisoGestion = $rolValidoGestion[0]["valido"];
          $this->_view->permisoAgregar = $rolValidoAgregar[0]["valido"];
          $this->_view->permisoModificar = $rolValidoModificar[0]["valido"];
          $this->_view->permisoEliminar = $rolValidoEliminar[0]["valido"];
          
          if($this->_view->permisoGestion!= PERMISO_GESTIONAR){
          echo "<script>
          ".MSG_SINPERMISOS."
          window.location.href='" . BASE_URL . "gestionPensum/listadoPensum" . "';
          </script>";
          } 
        
        $this->_view->titulo = 'Gestión de Cursos de Pensum - ' . APP_TITULO;

        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('tree.jquery'), "public");
        $this->_view->setJs(array('gestionCursoPensum'));


        $info = $this->_post->listadoCursosPorPensum($idPensum);
        if (is_array($info)) {
            $this->_view->lstCurPensum = $info;
        } else {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }

        if ($iden == 1) {
            
        }

        $this->_view->renderizar('gestionCursoPensum', 'gestionPensum');
    }

    public function eliminarCursoPensum($intNuevoEstado, $intIdCursoPensum, $intIdPensum, $intIdCarrera) {
        $rol = $_SESSION["rol"];
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_ELIMINARCURSOPENSUM);

        if ($rolValido[0]["valido"] == PERMISO_ELIMINAR) {

            if ($intNuevoEstado == -1 || $intNuevoEstado == 1) {
                $info = $this->_post->eliminarCursoPensum($intIdCursoPensum, $intNuevoEstado);
                if (!is_array($info)) {
                    $this->redireccionar("error/sql/" . $info);
                    exit;
                }
                $this->insertarBitacoraUsuario(CONS_FUNC_CUR_ELIMINARCURSOPENSUM, "Curso ".$intIdCursoPensum." elimanado del pensum en el sistema");
                $this->redireccionar('gestionPensum/gestionCursoPensum/' . $intIdPensum . '/' . $intIdCarrera);
            } else {
                $this->_view->cambio = "No reconocio ningun parametro";
            }
        } else {
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionPensum/gestionCursoPensum/" . $intIdPensum .'/'.$intIdCarrera . "';
                </script>";
        }
    }

    public function agregarCursoPensum($idPensum = 0, $idCarrera = 0) {

        $iden = $this->getInteger('hdEnvio');
        $idCentroUnidad = $_SESSION["centrounidad"];
       
        $arrayCurPen = array();

        $this->_view->idPensum = $idPensum;
        $this->_view->idCarrera = $idCarrera;

        $this->_view->titulo = 'Agregar Curso al Pensum - ' . APP_TITULO;

        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('tree.jquery'), "public");
        $this->_view->setJs(array('agregarCursoPensum'));

        $info = $this->_post->listadoCursos($idCentroUnidad, ESTADO_ACTIVO);
        if (is_array($info)) {
            $this->_view->lstCursos = $info;
        } else {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }

        $info2 = $this->_post->listadoAreas($idCarrera);
        if (is_array($info2)) {
            $this->_view->lstAreas = $info2;
        } else {
            $this->redireccionar("error/sql/" . $info2);
            exit;
        }

        $info3 = $this->_post->listadoTipoCiclo();
        if (is_array($info3)) {
            $this->_view->lstTipoCiclo = $info3;
        } else {
            $this->redireccionar("error/sql/" . $info3);
            exit;
        }


         $rol = $_SESSION["rol"];        
          $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_CREARCURSOPENSUM);

          if($rolValido[0]["valido"]!= PERMISO_CREAR){
          echo "<script>
          ".MSG_SINPERMISOS."
          window.location.href='" . BASE_URL . "gestionPensum/gestionCursoPensum/".$idPensum.'/'.$idCarrera . "';
          </script>";
          } 

        if ($iden == 1) {

            $arrayCurPen["curso"] = $this->getInteger('slCursos');
            $arrayCurPen["pensum"] = $idPensum;
            $arrayCurPen["numerociclo"] = $this->getTexto('txtNumeroCiclo');
            $arrayCurPen["tipociclo"] = $this->getInteger('slTipoCiclo');
            $arrayCurPen["creditos"] = $this->getTexto('txtCreditos');
            $arrayCurPen["prerrequisitos"] = "null";
            $arrayCurPen["estado"] = ESTADO_PENDIENTE;
            $arrayCurPen["carreraarea"] = $this->getInteger('slAreas');

            $info = $this->_view->query = $this->_post->agregarCursoPensum($arrayCurPen);
            if (!is_array($info)) {
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            $this->insertarBitacoraUsuario(CONS_FUNC_CUR_CREARCURSOPENSUM, "Curso creado en el pensum ".$idPensum." en el sistema");
            $this->redireccionar('gestionPensum/gestionCursoPensum/' . $idPensum . '/' . $idCarrera);
        }

        $this->_view->renderizar('agregarCursoPensum', 'gestionPensum');
    }
    
    public function actualizarCursoPensum($idCursoPensum = 0, $idPensum = 0, $idCarrera = 0) {
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_MODIFICARSALON);
       
        if($rolValido[0]["valido"]!= PERMISO_MODIFICAR){
           echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionPensum/gestionCursoPensum/".$idPensum.'/'.$idCarrera . "';
                </script>";
        }
       $idCentroUnidad = $_SESSION["centrounidad"];
       
       $info = $this->_post->listadoCursos($idCentroUnidad);
        if (is_array($info)) {
            $this->_view->lstCursos = $info;
        } else {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }

        $info2 = $this->_post->listadoAreas($idCarrera);
        if (is_array($info2)) {
            $this->_view->lstAreas = $info2;
        } else {
            $this->redireccionar("error/sql/" . $info2);
            exit;
        }

        $info3 = $this->_post->listadoTipoCiclo();
        if (is_array($info3)) {
            $this->_view->lstTipoCiclo = $info3;
        } else {
            $this->redireccionar("error/sql/" . $info3);
            exit;
        }

        $valorPagina = $this->getInteger('hdEnvio');
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarCursoPensum'));
        $this->_view->setCSS(array('jquery.dataTables.min'));
        $this->_view->setJs(array('jquery-ui'), "public");
        $this->_view->setCss(array('jquery-ui'), "public");

        $arrayCursoPensum = array();
        $this->_view->idPensum = $idPensum;
        $this->_view->idCarrera = $idCarrera;
        $this->_view->idCursoPensum = $idCursoPensum;

        $datosCursoPensum = $this->_post->datosCursoPensum($idCursoPensum);
        if (is_array($datosCursoPensum)) {
            $this->_view->datosCursoPensum = $datosCursoPensum;
        } else {
            $this->redireccionar("error/sql/" . $datosCursoPensum);
            exit;
        }

        if ($valorPagina == 1) {
            $arrayCursoPensum["cursopensum"] = $idCursoPensum;
            $arrayCursoPensum["curso"] = $this->getInteger('slCursos');
            $arrayCursoPensum["carreraarea"] = $this->getInteger('slAreas');
            $arrayCursoPensum["numerociclo"] = $this->getTexto('txtNumeroCiclo');
            $arrayCursoPensum["tipociclo"] = $this->getInteger('slTipoCiclo');
            $arrayCursoPensum["creditos"] = $this->getTexto('txtCreditos');
            
            $info = $this->_post->actualizarCursoPensum($arrayCursoPensum);
            if (!is_array($info)) {
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            $this->insertarBitacoraUsuario(CONS_FUNC_CUR_MODIFICARSALON, "Curso modificando en el pensum ".$idCursoPensum." en el sistema");
            $this->redireccionar('gestionPensum/actualizarCursoPensum/'.$idCursoPensum.'/'.$idPensum.'/'.$idCarrera);
        }
        
        $this->_view->renderizar('actualizarCursoPensum', 'gestionPensum');
    }
    
    public function crearPensum($idPensum = 0, $idCursoPensum = 0, $idCarrera = 0) {
       // session_start();
         $pensum = $this->getInteger('hdPensum');
         $carrera = $this->getInteger('hdCarrera');
         $cursoPensumArea = $this->getInteger('hdCursoPensumArea');
         
         $prerrequisitos = $this->getTexto('hdPrerrequisitos');
         
         $iden = $this->getInteger('hdEnvio');
            $idCentroUnidad = $_SESSION["centrounidad"];

        $arrayPensum = array();

        $this->_view->idPensum = $idPensum;
        $this->_view->idCarrera = $idCarrera;
        $this->_view->idCursoPensum = $idCursoPensum;
        
        $this->_view->titulo = 'Crear Pensum - ' . APP_TITULO;

        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('crearPensum'));
        $this->_view->setJs(array('tree.jquery'), "public");
        $this->_view->setCSS(array('jqtree'));

        
        $info = $this->_post->listadoCursosPensum($idPensum);
        if (is_array($info)) {
            $this->_view->lstCursos = $info;
        } else {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }
        
        $datosCurso = $this->_post->getCursoCursoPensumArea($idCursoPensum);
        if (is_array($datosCurso)) {
            $this->_view->dCurso = $datosCurso;
        } else {
            $this->redireccionar("error/sql/" . $datosCurso);
            exit;
        }

        /* $rol = $_SESSION["rol"];        
          $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_CREARPARAMETRO);

          if($rolValido[0]["valido"]!= PERMISO_CREAR){
          echo "<script>
          alert('No tiene permisos suficientes para acceder a esta función.');
          window.location.href='" . BASE_URL . "gestionParametro" . "';
          </script>";
          } */
        
        if ($iden == 1) {
            $prerrequisitosRes = str_replace("&#039;","\"", $prerrequisitos);
             $result = str_replace("&gt;", ">", $prerrequisitosRes);
            
            //echo '<script>alert("'.$prerrequisitosRes.'");</script>';
           // echo '<script>alert("'.$iden3.'");</script>';
                 
            $info = $this->_post->actualizarCurPensumArea($cursoPensumArea,$result);
            //print_r($info.'-'.$cursoPensumArea.'-'.$prerrequisitosRes);
            if (!is_array($info)) {
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            $this->insertarBitacoraUsuario(CONS_FUNC_CUR_CREARPENSUM, "Pensum ".$pensum." creado en el sistema");
            $this->redireccionar('gestionPensum/gestionCursoPensum/'.$pensum.'/'.$carrera);
            
        }

        $this->_view->renderizar('crearPensum', 'gestionPensum');
    }

    public function actualizarPensum($intIdPensum = 0) {
        //session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_MODIFICARPENSUM);
       
        if($rolValido[0]["valido"]!= PERMISO_MODIFICAR){
           echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionPensum/listadoPensum/" . "';
                </script>";
        }

        $lsCarreras = $this->_view->carreras = $this->_ajax->getAllCarreras();
        if (is_array($lsCarreras)) {
            $this->_view->carreras = $lsCarreras;
        } else {
            $this->redireccionar("error/sql/" . $lsCarreras);
            exit;
        }

        $valorPagina = $this->getInteger('hdEnvio');
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarPensum'));
        $this->_view->setCSS(array('jquery.dataTables.min'));
        $this->_view->setJs(array('jquery-ui'), "public");
        $this->_view->setCss(array('jquery-ui'), "public");

        $arrayPensum = array();
        $this->_view->idPensum = $intIdPensum;

        $datosPensum = $this->_post->datosPensum($intIdPensum);
        if (is_array($datosPensum)) {
            $this->_view->datosPensum = $datosPensum;
        } else {
            $this->redireccionar("error/sql/" . $datosPensum);
            exit;
        }

        if ($valorPagina == 1) {
            $arrayPensum["pensum"] = $intIdPensum;
            $arrayPensum["carrera"] = $this->getInteger('slCarreras');
            $arrayPensum["tipo"] = $this->getInteger('slTipos');
            $arrayPensum["inicioVigencia"] = $this->getTexto('inputFecha');
            $arrayPensum["duracionAnios"] = $this->getInteger('txtTiempo');
            $arrayPensum["descripcion"] = $this->getTexto('txtDescripcion');


            $info = $this->_post->actualizarPensum($arrayPensum);
            if (!is_array($info)) {
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            $this->insertarBitacoraUsuario(CONS_FUNC_CUR_MODIFICARPENSUM, "Pensum ".$intIdPensum." actualizado en el sistema");
            $this->redireccionar('gestionPensum/listadoPensum');
        }
        $this->_view->renderizar('actualizarPensum', 'gestionPensum');
    }

    
    
}
if(!function_exists("array_column")){

    function array_column($array,$column_name){

        return array_map(function($element) use($column_name){return $element[$column_name];}, $array);

    }

}
?>
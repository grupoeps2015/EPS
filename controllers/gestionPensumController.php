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
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel('gestionPensum');
        $this->_ajax = $this->loadModel("ajax");
    }

    public function index() {
        session_start();
        $rol = $_SESSION["rol"];
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_CREARCARRERA);

        if ($rolValido[0]["valido"] != PERMISO_GESTIONAR) {
            echo "<script>
                alert('No tiene permisos para acceder a esta función.');
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
        session_start();
        $rol = $_SESSION["rol"];
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_GESTIONPENSUM);

        if ($rolValido[0]["valido"] != PERMISO_GESTIONAR) {
            echo "<script>
                alert('No tiene permisos para acceder a esta función.');
                window.location.href='" . BASE_URL . "login/inicio';
                </script>";
        }

        $this->_view->renderizar('inicio');
    }

    public function asignarAreaCarrera($intIdCarrera = 0) {
//        session_start();

        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('asignarArea'));

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

        $lsAreas = $this->_view->lstAreas = $this->_ajax->getAllAreas();
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
                        $arrayAsignacion['estado'] = ESTADO_PENDIENTE;
                        $asignacion = $this->_post->asignarAreaCarrera($arrayAsignacion);
                        if (is_array($asignacion)) {
                            $this->redireccionar('gestionPensum/asignarAreaCarrera/' . $intIdCarrera);
                        } else {
                            $this->redireccionar("error/sql/" . $asignacion);
                            exit;
                        }
//                        echo '<script>alert("' . $selected . '");</script>';
                    }
                }
            }
//            $idArea = $this->getInteger('check_list');
//            echo $idArea;
            //$nombreCarrera = $this->getTexto('txtNombre');
//            $arrayAsignacion['id'] = $intIdCarrera;
//            $arrayAsignacion['nombre'] = $nombreCarrera;
            //$respuesta = $this->_post->asignarAreaCarrera($arrayCar);
//            if (is_rray($respuesta)) {
//                
//               // $this->redireccionar('gestionPensum/asignarAreaCarrera/' . $intIdCarrera);
//            } else {
//                $this->redireccionar("error/sql/" . $respuesta);
//                exit;
//            }
        }
    }

    public function listadoCarrera() {
        session_start();
        $rol = $_SESSION["rol"];
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_GESTIONCARRERA);

        if ($rolValido[0]["valido"] != PERMISO_GESTIONAR) {
            echo "<script>
                alert('No tiene permisos para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionPensum/inicio';
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

    public function agregarCarrera() {
        session_start();

        $idCentroUnidad = $_SESSION["centrounidad"];
        $rol = $_SESSION["rol"];
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_CREARCARRERA);

        if ($rolValido[0]["valido"] != PERMISO_CREAR) {
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
            if (!is_array($info)) {
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
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_ELIMINARCARRERA);

        if ($rolValido[0]["valido"] == PERMISO_ELIMINAR) {
            if ($intNuevoEstado == -1 || $intNuevoEstado == 1) {
                $info = $this->_post->eliminarCarrera($intIdCarrera, $intNuevoEstado);
                if (!is_array($info)) {
                    $this->redireccionar("error/sql/" . $info);
                    exit;
                }
                $this->redireccionar('gestionPensum/listadoCarrera');
            } else {
                echo "Error al desactivar carrera";
            }
        } else {
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
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_MODIFICARCARRERA);

        if ($rolValido[0]["valido"] != PERMISO_MODIFICAR) {
            echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionPensum/listadoCarrera" . "';
                </script>";
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

            $arrayCar['id'] = $intIdCarrera;
            $arrayCar['nombre'] = $nombreCarrera;
            $respuesta = $this->_post->actualizarCarrera($arrayCar);
            if (is_array($respuesta)) {
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
        $this->_view->setJs(array('listadoPensum'));
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
        $this->_view->setJs(array('jquery-ui'), "public");
        $this->_view->setCss(array('jquery-ui'), "public");
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
            $arrayPensum['estado'] = ESTADO_PENDIENTE;
            $info = $this->_post->agregarPensum($arrayPensum);

            if (!is_array($info)) {
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            $this->redireccionar('gestionPensum/listadoPensum');
        }
        $this->_view->renderizar('agregarPensum', 'gestionPensum');
    }

    public function finalizarVigenciaPensum($intIdPensum, $estado) {
//        session_start();
//        $rol = $_SESSION["rol"];
//        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_ELIMINARCARRERA);
//
//        if ($rolValido[0]["valido"] == PERMISO_ELIMINAR) {

        $info = $this->_post->spfinalizarVigenciaPensum($intIdPensum, $estado);
        if (!is_array($info)) {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }
        $this->redireccionar('gestionPensum/listadoPensum');
//        } else {
//            echo "<script>
//                alert('No tiene permisos suficientes para acceder a esta función.');
//                window.location.href='" . BASE_URL . "gestionPensum/listadoCarrera/" . "';
//                </script>";
//        }
    }

    public function activarPensum($intIdPensum) {
//        session_start();
//        $rol = $_SESSION["rol"];
//        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_CUR_ELIMINARCARRERA);
//
//        if ($rolValido[0]["valido"] == PERMISO_ELIMINAR) {

        $info = $this->_post->activarPensum($intIdPensum);
        if (!is_array($info)) {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }
        $this->redireccionar('gestionPensum/listadoPensum');
//        } else {
//            echo "<script>
//                alert('No tiene permisos suficientes para acceder a esta función.');
//                window.location.href='" . BASE_URL . "gestionPensum/listadoCarrera/" . "';
//                </script>";
//        }
    }

    public function gestionCursoPensum($idPensum = 0, $idCarrera = 0) {
        session_start();

        $iden = $this->getInteger('hdEnvio');
        $idCentroUnidad = $_SESSION["centrounidad"];

        $arrayCurPensum = array();

        $this->_view->idPensum = $idPensum;
        $this->_view->idCarrera = $idCarrera;

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

        /* $rol = $_SESSION["rol"];        
          $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_CREARPARAMETRO);

          if($rolValido[0]["valido"]!= PERMISO_CREAR){
          echo "<script>
          alert('No tiene permisos suficientes para acceder a esta función.');
          window.location.href='" . BASE_URL . "gestionParametro" . "';
          </script>";
          } */

        if ($iden == 1) {
            
        }

        $this->_view->renderizar('gestionCursoPensum', 'gestionPensum');
    }

    public function eliminarCursoPensum($intNuevoEstado, $intIdCursoPensum, $intIdPensum, $intIdCarrera) {
        session_start();
        $rol = $_SESSION["rol"];
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_ADM_ELIMINARPARAMETRO);

        if ($rolValido[0]["valido"] == PERMISO_ELIMINAR) {

            if ($intNuevoEstado == -1 || $intNuevoEstado == 1) {
                $info = $this->_post->eliminarCursoPensum($intIdCursoPensum, $intNuevoEstado);
                if (!is_array($info)) {
                    $this->redireccionar("error/sql/" . $info);
                    exit;
                }
                $this->redireccionar('gestionPensum/gestionCursoPensum/' . $intIdPensum . '/' . $intIdCarrera);
            } else {
                $this->_view->cambio = "No reconocio ningun parametro";
            }
        } else {
            echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionParametro" . "';
                </script>";
        }
    }

    public function agregarCursoPensum($idPensum = 0, $idCarrera = 0) {
        session_start();

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





        /* $rol = $_SESSION["rol"];        
          $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_CREARPARAMETRO);

          if($rolValido[0]["valido"]!= PERMISO_CREAR){
          echo "<script>
          alert('No tiene permisos suficientes para acceder a esta función.');
          window.location.href='" . BASE_URL . "gestionParametro" . "';
          </script>";
          } */

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

            $this->redireccionar('gestionPensum/gestionCursoPensum/' . $idPensum . '/' . $idCarrera);
        }

        $this->_view->renderizar('agregarCursoPensum', 'gestionPensum');
    }
    
    
     public function actualizarCursoPensum($idCursoPensum = 0, $idPensum = 0, $idCarrera = 0) {
        session_start();
//        $rol = $_SESSION["rol"];        
//        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_MODIFICARSALON);
//       
//        if($rolValido[0]["valido"]!= PERMISO_MODIFICAR){
//           echo "<script>
//                alert('No tiene permisos suficientes para acceder a esta función.');
//                window.location.href='" . BASE_URL . "gestionEdificio/gestionSalon/" . $intIdEdificio . "';
//                </script>";
//        }
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
        //$this->_view->setJs(array('actualizarPensum'));
        $this->_view->setCSS(array('jquery.dataTables.min'));
        $this->_view->setJs(array('jquery-ui'), "public");
        $this->_view->setCss(array('jquery-ui'), "public");

        $arrayCursoPensum = array();
        $this->_view->idPensum = $idPensum;
        $this->_view->idCarrera = $idCarrera;
        $this->_view->idCursoPensum = $idCursoPensum;

        /*$datosCursoPensum = $this->_post->datosCursoPensum($idCursoPensum);
        if (is_array($datosCursoPensum)) {
            $this->_view->datosCursoPensum = $datosCursoPensum;
        } else {
            $this->redireccionar("error/sql/" . $datosCursoPensum);
            exit;
        }
*/
        if ($valorPagina == 1) {/*
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

            $this->redireccionar('gestionPensum/listadoPensum');*/
        }
        
        $this->_view->renderizar('actualizarCursoPensum', 'gestionPensum');
    }
    

    public function crearPensum($idPensum = 0, $idCursoPensum = 0, $idCarrera = 0) {
        session_start();

        $iden = $this->getInteger('hdEnvio');
        $idCentroUnidad = $_SESSION["centrounidad"];

        $arrayPen = array();

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

        $info = $this->_post->listadoCursos($idCentroUnidad);
        if (is_array($info)) {
            $this->_view->lstCursos = $info;
        } else {
            $this->redireccionar("error/sql/" . $info);
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
            /* $arrayPar["nombre"] = $this->getTexto('txtNombreParametro');
              $arrayPar["valor"] = $this->getTexto('txtValorParametro');
              $arrayPar["descripcion"] = $this->getTexto('txtDescripcionParametro');
              $arrayPar["centro_unidadacademica"] = $this->getInteger('slCentroUnidadAcademica');
              $arrayPar["carrera"] = $this->getInteger('slCarreras');
              $arrayPar["extension"] = $this->getTexto('txtExtensionParametro');
              $arrayPar["tipoparametro"] =  $this->getInteger('slTipoParametro');

              $info = $this->_view->query = $this->_post->agregarParametro($arrayPar);
              if(!is_array($info)){
              $this->redireccionar("error/sql/" . $info);
              exit;
              }

              $this->redireccionar('gestionParametro'); */
        }

        $this->_view->renderizar('crearPensum', 'gestionPensum');
    }

    public function actualizarPensum($intIdPensum = 0) {
//        session_start();
//        $rol = $_SESSION["rol"];        
//        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_MODIFICARSALON);
//       
//        if($rolValido[0]["valido"]!= PERMISO_MODIFICAR){
//           echo "<script>
//                alert('No tiene permisos suficientes para acceder a esta función.');
//                window.location.href='" . BASE_URL . "gestionEdificio/gestionSalon/" . $intIdEdificio . "';
//                </script>";
//        }

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

            $this->redireccionar('gestionPensum/listadoPensum');
        }
        $this->_view->renderizar('actualizarPensum', 'gestionPensum');
    }

    
    
}

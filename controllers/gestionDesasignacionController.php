<?php

/**
 * Description of gestionPensumController
 *
 * @author amoino   
 */
class gestionDesasignacionController extends Controller {

    private $estudiante;
    private $_post;
    private $_encriptar;
    private $_ajax;
    private $_bitacora;

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
        $this->_bitacora = $this->loadModel("bitacora");
        if ($this->getInteger('slEstudiantes')) {
            $this->estudiante = $this->getInteger('slEstudiantes');
        } else {
            $estudiante = $this->_ajax->getEstudianteUsuario($_SESSION["usuario"]);
            if (is_array($estudiante)) {
                $this->estudiante = (isset($estudiante[0]['id']) ? $estudiante[0]['id'] : -1);
            } else {
                $this->redireccionar("error/sql/" . $estudiante);
                exit;
            }
        }
        if ($this->getInteger('slEstudiantes') && $this->getInteger('slCarreras')) {
            $this->carrera = $this->getInteger('slCarreras');
        } else if (isset($_SESSION["carrera"])) {
            $this->carrera = $_SESSION["carrera"];
        }
    }

    public function listadoAsignaciones($idestudiante = 0) {

        $this->_view->estudiante = $this->estudiante;
        if ($idestudiante != 0) {
            $this->estudiante = $idestudiante;
            $info = $this->_post->allAsignaciones($idestudiante);
        } else {
            $info = $this->_post->allAsignaciones($this->estudiante);
        }


        if (is_array($info)) {
            $this->_view->lstAsignaciones = $info;
        } else {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }

        $rol = $_SESSION["rol"];
        $rolValidoGestion = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_ADM_GESTIONDESASIGNACION);
        $this->_view->permisoGestion = $rolValidoGestion[0]["valido"];
        if ($this->_view->permisoGestion != PERMISO_GESTIONAR) {
            echo "<script>
                " . MSG_SINPERMISOS . "
                window.location.href='" . BASE_URL . "login/inicio';
                </script>";
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

    public function desasignarCurso($idEstado, $idAsignacion, $codigoCurso) {
        $carnet = $this->getInteger('hdCarnet');
        $idestudiante = $this->getInteger('hdEst');
        $codigo = $this->getInteger('hdCodigo');
        echo "<script>
                alert('----".$codigoCurso."----');
                </script>";

//        session_start();
//        $rol = $_SESSION["rol"];        
//        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_ELIMINAREDIFICIO);
//        if($rolValido[0]["valido"]== PERMISO_ELIMINAR){
        if ($idEstado == ESTADO_INACTIVO || $idEstado == ESTADO_ACTIVO) {

            $infoDesasignacion = $this->_post->getdesasignacion($carnet, $codigoCurso);
            
            if (is_array($infoDesasignacion)) {
                if(count($infoDesasignacion)>0){
                    
                    echo "<script>
                alert('Aaaaaaaaaaaaaaaaaaaaaaaa');
                </script>";
                $this->redireccionar('gestionDesasignacion/listadoAsignaciones/' . $idestudiante);
                }else{
                    echo "<script>
                alert('bbbbbbbbbbbbbbbbbbbbb');
                </script>";
                $this->redireccionar('gestionDesasignacion/listadoAsignaciones/' . $idestudiante);
                    
                }
                echo "<script>
                alert('No se puede realizar la desasignacion debido a que el estudiante ya ha realizado este proceso para este curso.');
                </script>";
                $this->redireccionar('gestionDesasignacion/listadoAsignaciones/' . $idestudiante);
            } else {
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
                    //Insertar en bitácora            
                    $arrayBitacora = array();
                    $arrayBitacora[":usuario"] = $_SESSION["usuario"];
                    $arrayBitacora[":nombreusuario"] = $_SESSION["nombre"];
                    $arrayBitacora[":funcion"] = CONS_FUNC_LOGIN;
                    $arrayBitacora[":ip"] = $this->get_ip_address();
                    $arrayBitacora[":registro"] = 0; //no se que es esto
                    $arrayBitacora[":tablacampo"] = ''; //tampoco se que es esto
                    $arrayBitacora[":descripcion"] = 'Se ha realizado desasignacion de curso';
                    $insert = $this->_bitacora->insertarBitacoraAsignacion($arrayBitacora);
                    if (!is_array($insert)) {
                        $this->redireccionar("error/sql/" . $insert);
                        exit;
                    }

                    echo "<script>
                alert('Desasignacion de curso para el estudiante " . $carnet . " realizada exitosamente.');
                </script>";
                    $this->redireccionar('gestionDesasignacion/listadoAsignaciones/' . $idestudiante);
                }
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

    private function get_ip_address() {
        // check for shared internet/ISP IP
        if (!empty($_SERVER['HTTP_CLIENT_IP']) && validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
            return $_SERVER['HTTP_CLIENT_IP'];
        }

        // check for IPs passing through proxies
        if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            // check if multiple ips exist in var
            if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',') !== false) {
                $iplist = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                foreach ($iplist as $ip) {
                    if (validate_ip($ip))
                        return $ip;
                }
            } else {
                if (validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']))
                    return $_SERVER['HTTP_X_FORWARDED_FOR'];
            }
        }
        if (!empty($_SERVER['HTTP_X_FORWARDED']) && validate_ip($_SERVER['HTTP_X_FORWARDED']))
            return $_SERVER['HTTP_X_FORWARDED'];
        if (!empty($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']) && validate_ip($_SERVER['HTTP_X_CLUSTER_CLIENT_IP']))
            return $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
        if (!empty($_SERVER['HTTP_FORWARDED_FOR']) && validate_ip($_SERVER['HTTP_FORWARDED_FOR']))
            return $_SERVER['HTTP_FORWARDED_FOR'];
        if (!empty($_SERVER['HTTP_FORWARDED']) && validate_ip($_SERVER['HTTP_FORWARDED']))
            return $_SERVER['HTTP_FORWARDED'];

        // return unreliable ip since all else failed
        return $_SERVER['REMOTE_ADDR'];
    }

}
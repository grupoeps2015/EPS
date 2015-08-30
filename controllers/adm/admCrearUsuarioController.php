<?php

/**
 * Description of admCrearUsuarioController
 *
 * @author Rickardo, Maythee
 */
class admCrearUsuarioController extends Controller {

    private $_post;
    private $_encriptar;

    private $_ajax;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel(ADM_FOLDER, 'admCrearUsuario');
        $this->_ajax = $this->loadModel("", "ajax");
    }

    public function index() {
        $this->_view->lstUsr = $this->_post->informacionUsuario();
        $this->_view->titulo = 'Gestión de usuarios - ' . APP_TITULO;
        $this->_view->setJs(ADM_FOLDER, array('admCrearUsuario'));
        $this->_view->setJs("public", array('jquery.dataTables.min'));
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar(ADM_FOLDER, 'admCrearUsuario');
    }

    public function agregarUsuario() {
        $iden = $this->getInteger('hdEnvio');
        $idUsr = 0;
        $nombreUsr = '';
        $correoUsr = '';
        $fotoUsr = '';
        $crearUsr = false;

        $arrayUsr = array();
        $arrayEst = array();
        $arrayEmp = array();
        $arrayCat = array();
        
        $this->_view->centros = $this->_post->getCentros();
        $this->_view->docentes = $this->_post->getDocentes();

        $this->_view->titulo = 'Agregar Usuario - ' . APP_TITULO;
        $this->_view->setJs(ADM_FOLDER, array('agregarUsuario'));
        $this->_view->setJs("public", array('jquery.validate'));

        if ($iden == 1) {
            $this->_view->datos = $_POST;
            if (!$this->getTexto('txtNombreEst1')) {
                $this->_view->renderizar(ADM_FOLDER, 'agregarUsuario', 'admCrearUsuario');
                exit;
            }

            if (!$this->getTexto('txtCorreoEst')) {
                $this->_view->renderizar(ADM_FOLDER, 'agregarUsuario', 'admCrearUsuario');
                exit;
            }

            if (!$this->getTexto('txtApellidoEst1')) {
                $this->_view->renderizar(ADM_FOLDER, 'agregarUsuario', 'admCrearUsuario');
                exit;
            }

            if (!$this->getTexto('txtCarnetEst')) {
                $this->_view->renderizar(ADM_FOLDER, 'agregarUsuario', 'admCrearUsuario');
                exit;
            }

            $nombreUsr = $this->getTexto('txtNombreEst1');
            $correoUsr = $this->getTexto('txtCorreoEst');
            $fotoUsr = $this->getTexto('txtFotoEst');
            $crearUsr = true;
        } elseif ($iden == 2) {
            $this->_view->datos = $_POST;
            $this->_view->preguntas = $this->_post->getPreguntas();
            if (!$this->getTexto('txtNombreCat1')) {
                $this->_view->renderizar(ADM_FOLDER, 'agregarUsuario', 'admCrearUsuario');
                exit;
            }

            if (!$this->getTexto('txtCorreoCat')) {
                $this->_view->renderizar(ADM_FOLDER, 'agregarUsuario', 'admCrearUsuario');
                exit;
            }

            if (!$this->getTexto('txtApellidoCat1')) {
                $this->_view->renderizar(ADM_FOLDER, 'agregarUsuario', 'admCrearUsuario');
                exit;
            }

            if (!$this->getTexto('txtCodigoCat')) {
                $this->_view->renderizar(ADM_FOLDER, 'agregarUsuario', 'admCrearUsuario');
                exit;
            }

            $nombreUsr = $this->getTexto('txtNombreCat1');
            $correoUsr = $this->getTexto('txtCorreoCat');
            $fotoUsr = $this->getTexto('txtFotoCat');
            $crearUsr = true;
        } elseif ($iden == 3) {
            $this->_view->datos = $_POST;
            $this->_view->preguntas = $this->_post->getPreguntas();
            if (!$this->getTexto('txtNombreEmp1')) {
                $this->_view->renderizar(ADM_FOLDER, 'agregarUsuario', 'admCrearUsuario');
                exit;
            }

            if (!$this->getTexto('txtCorreoEmp')) {
                $this->_view->renderizar(ADM_FOLDER, 'agregarUsuario', 'admCrearUsuario');
                exit;
            }

            if (!$this->getTexto('txtApellidoEmp1')) {
                $this->_view->renderizar(ADM_FOLDER, 'agregarUsuario', 'admCrearUsuario');
                exit;
            }

            if (!$this->getTexto('txtCodigoEmp')) {
                $this->_view->renderizar(ADM_FOLDER, 'agregarUsuario', 'admCrearUsuario');
                exit;
            }

            $nombreUsr = $this->getTexto('txtNombreEmp1');
            $correoUsr = $this->getTexto('txtCorreoEmp');
            $fotoUsr = $this->getTexto('txtFotoEmp');
            $crearUsr = true;
        }

        if ($crearUsr) {
            $arrayUsr["nombreUsr"] = $nombreUsr;
            $arrayUsr["correoUsr"] = $correoUsr;
            $arrayUsr["fotoUsr"] = $fotoUsr;
            $claveAleatoria = $this->_encriptar->keyGenerator();
            $arrayUsr["claveUsr"] = $this->_encriptar->encrypt($claveAleatoria, UNIDAD_ACADEMICA);
            $arrayUsr["preguntaUsr"] = 0;
            $arrayUsr["respuestaUsr"] = "USAC";
            $arrayUsr["intentosUsr"] = 5;
            $arrayUsr["unidadUsr"] = UNIDAD_ACADEMICA;
            $idUsr = $this->_post->agregarUsuario($arrayUsr)[0][0];
            //$this->_view->query = $this->_post->agregarUsuario($arrayUsr);
            if ($iden == 1) {
                $arrayEst["id"] = $idUsr;
                $arrayEst["carnetEst"] = $this->getTexto('txtCarnetEst');
                $arrayEst["nombreEst"] = $nombreUsr;
                $arrayEst["nombreEst2"] = $this->getTexto('txtNombreEst2');
                $arrayEst["apellidoEst"] = $this->getTexto('txtApellidoEst1');
                $arrayEst["apellidoEst2"] = $this->getTexto('txtApellidoEst2');
                $arrayEst["direccionEst"] = "ciudad";
                $arrayEst["zonaEst"] = 0;
                $arrayEst["municipioEst"] = 1;
                $arrayEst["telefonoEst"] = "22220000";
                $arrayEst["telefono2Est"] = "22220000";
                $arrayEst["sangreEst"] = "desconocida";
                $arrayEst["alergiasEst"] = "desconocidas";
                $arrayEst["seguroEst"] = 'false';
                $arrayEst["centroEst"] = "desconocido";
                $arrayEst["paisEst"] = 1;
                $this->_post->agregarEstudiante($arrayEst); //aca estamos dando valor a la variable query
                $this->_post->asignarRolUsuario(ROL_ESTUDIANTE, $idUsr);
            } elseif ($iden == 2) {
                $arrayCat["id"] = $idUsr;
                $arrayCat["registroCat"] = $this->getTexto('txtCodigoCat');
                $arrayCat["nombreCat"] = $nombreUsr;
                $arrayCat["nombreCat2"] = $this->getTexto('txtNombreCat2');
                $arrayCat["apellidoCat"] = $this->getTexto('txtApellidoCat1');
                $arrayCat["apellidoCat2"] = $this->getTexto('txtApellidoCat2');
                $arrayCat["direccionCat"] = "ciudad";
                $arrayCat["zonaCat"] = 0;
                $arrayCat["municipioCat"] = 1;
                $arrayCat["telefonoCat"] = "22220000";
                $arrayCat["paisCat"] = 1;
                $arrayCat["tipoCat"] = $this->getInteger('slDocente');
                $this->_post->agregarCatedratico($arrayCat);
                $this->_post->asignarRolUsuario(ROL_DOCENTE, $idUsr);
            } elseif ($iden == 3) {
                $arrayEmp["id"] = $idUsr;
                $arrayEmp["registroEmp"] = $this->getTexto('txtCodigoEmp');
                $arrayEmp["nombreEmp"] = $nombreUsr;
                $arrayEmp["nombreEmp2"] = $this->getTexto('txtNombreEmp2');
                $arrayEmp["apellidoEmp"] = $this->getTexto('txtApellidoEmp1');
                $arrayEmp["apellidoEmp2"] = $this->getTexto('txtApellidoEmp2');
                $arrayEmp["direccionEmp"] = "ciudad";
                $arrayEmp["zonaEmp"] = 0;
                $arrayEmp["municipioEmp"] = 1;
                $arrayEmp["telefonoEmp"] = "22220000";
                $arrayEmp["paisEmp"] = 1;
                $this->_post->agregarEmpleado($arrayEmp);
                $this->_post->asignarRolUsuario(ROL_EMPLEADO, $idUsr);
            }
            $this->notificacionEMAIL();
            $this->redireccionar('admCrearUsuario');
        }

        $this->_view->renderizar(ADM_FOLDER, 'agregarUsuario', 'admCrearUsuario');
    }

    public function eliminarUsuario($intNuevoEstado, $intIdUsuario) {
        if ($intNuevoEstado == -1 || $intNuevoEstado == 1) {
            $this->_post->eliminarUsuario($intIdUsuario, $intNuevoEstado);

            $this->redireccionar('admCrearUsuario');
        } else {
            $this->_view->cambio = "No reconocio ningun parametro";
        }
        $this->redireccionar('admCrearUsuario');
        //$this->_view->cambio = $intNuevoEstado;
        $this->_view->titulo = 'Eliminar usuario - ' . APP_TITULO;
        $this->_view->renderizar(ADM_FOLDER, 'eliminarUsuario', 'admCrearUsuario');
    }

    public function actualizarUsuario($intIdUsuario = 0) {

        $valorPagina = $this->getInteger('hdEnvio');
        $this->_view->setJs("public", array('jquery.validate'));
        $this->_view->setJs(ADM_FOLDER, array('actualizarUsuario'));
        
        $arrayUsr = array();
        $actualizar = false;
        $this->_view->id = $intIdUsuario;
        $this->_view->rol = $this->_post->getRol($intIdUsuario)[0][0];
        $this->_view->preguntas = $this->_post->getPreguntas();
        $this->_view->datosUsr = $this->_post->datosUsuario($intIdUsuario);
        $this->_view->unidades = $this->_ajax->getUnidades();

        if ($valorPagina == 1) {
            
            if (!$this->getTexto('txtNombre') || !$this->getTexto('txtCorreo') || !$this->getInteger('slPregunta') || !$this->getTexto('txtRespuesta')) {
                $this->_view->renderizar(ADM_FOLDER, 'admCrearUsuario', 'actualizarUsuario');
                //echo "<script> alert('Al exit') </script>";
                exit;
            }
            
            $actualizar = true;
        }
        if ($actualizar) {
            $arrayUsr['id'] = $intIdUsuario;
            $arrayUsr['nombreUsr'] = $this->getTexto('txtNombre');
            $arrayUsr['correoUsr'] = $this->getTexto('txtCorreo');
            if(!$this->getTexto('txtPasswordNuevo')&&!$this->getTexto('txtPasswordNuevo2')){
                $arrayUsr['clave'] = $this->getTexto('pass');
            }
            $arrayUsr['clave'] = $this->getTexto('txtPasswordNuevo');;
             //getTexto('txtUnidadAcademica');//para que funcione tiene que mandar un entero... dato quemado
            $arrayUsr['preguntaUsr'] = $this->getInteger('slPregunta');
            $arrayUsr['respuestaUsr'] = $this->getTexto('txtRespuesta');
            
            //$this->_view->query = $this->_post->actualizarUsuario($arrayUsr);
            $this->_post->actualizarUsuario($arrayUsr);
            //echo "<script> alert('".$this->_post->actualizarUsuario($arrayUsr)."') </script>";
            //se queda en la pagina
            $this->redireccionar('admCrearUsuario/actualizarUsuario/'.$intIdUsuario);
            
        }
        $this->_view->renderizar(ADM_FOLDER, 'actualizarUsuario', 'admCrearUsuario');

//        $actualizar = false;
//        $arrayGen = array();
//        $arrayEmg = array();
//
//        $this->_view->titulo = APP_TITULO;
//        $this->_view->infoGeneral = $this->_est->datosUsuario($intIdUsuario);
//        $this->_view->setJs(ADM_FOLDER, array('admEstudiante'));
//        
//        
//            $this->_view->datos = $_POST;
//            if (!$this->getTexto('txtNombre')) {
//                $this->_view->renderizar(ADM_FOLDER, 'admCrearUsuario', 'actualizarUsuario');
//                exit;
//            }
//            if (!$this->getTexto('txtCorreo')) {
//                $this->_view->renderizar(ADM_FOLDER, 'admCrearUsuario', 'actualizarUsuario');
//                exit;
//            }
//            if (!$this->getTexto('txtUnidadAcademica')) {
//                $this->_view->renderizar(ADM_FOLDER, 'admCrearUsuario', 'actualizarUsuario');
//                exit;
//            }
//
//            $actualizar = true;
//        } else if ($iden == 2) {
//            $actualizar = true;
//        }
//
//        if ($actualizar) {
//            $this->_view->datosUsr = $this->_post->datosUsuario($intIdUsuario);
//            $arrayGen["nombreUsr"] = $this->getTexto('txtNombre');
//            $arrayGen["correoUsr"] = $this->getTexto('txtCorreo');
//            $arrayGen["preguntaUsr"] = 0;
//            $arrayGen["respuestaUsr"] = "USAC";
//            $arrayGen["unidadUsr"] = $this->getTexto('txtUnidadAcademica');
//            $this->_est->datosUsuario($arrayGen);
//
//            $this->redireccionar('admCrearUsuario/actualizarUsuario/2');
//        }
//
//        $this->_view->renderizar(ADM_FOLDER, 'actualizarUsuario');
    }

    protected function notificacionEMAIL() {
        // El mensaje
        $mensaje = "Línea 1\r\nLínea 2\r\nLínea 3";

        // Si cualquier línea es más larga de 70 caracteres, se debería usar wordwrap()
        //$mensaje = wordwrap($mensaje, 70, "\r\n");
        // Enviarlo
        mail('rick.shark130@gmail.com', 'Mi título', $mensaje);
    }

}

?>

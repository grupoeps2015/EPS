<?php

/**
 * Description of admCrearUsuarioController
 *
 * @author Rickardo, Maythee
 */
class gestionUsuarioController extends Controller {

    private $_post;
    private $_encriptar;

    private $_ajax;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel('gestionUsuario');
        $this->_ajax = $this->loadModel("ajax");
    }

    public function index() {
        $this->_view->lstUsr = $this->_post->informacionUsuario();
        $this->_view->titulo = 'Gestión de usuarios - ' . APP_TITULO;
        $this->_view->setJs(array('gestionUsuario'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('gestionUsuario');
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
        $this->_view->setJs(array('agregarUsuario'));
        $this->_view->setJs(array('jquery.validate'), "public");

        if ($iden == 1) {
            $nombreUsr = $this->getTexto('txtNombreEst1');
            $correoUsr = $this->getTexto('txtCorreoEst');
            $fotoUsr = $this->getTexto('txtFotoEst');
            $crearUsr = true;
        } elseif ($iden == 2) {
            $nombreUsr = $this->getTexto('txtNombreCat1');
            $correoUsr = $this->getTexto('txtCorreoCat');
            $fotoUsr = $this->getTexto('txtFotoCat');
            $crearUsr = true;
        } elseif ($iden == 3) {
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
                $this->_post->agregarEstudiante($arrayEst);
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
            //$this->notificacionEMAIL();
            $this->redireccionar('gestionUsuario');
        }

        $this->_view->renderizar('agregarUsuario', 'gestionUsuario');
    }

    public function eliminarUsuario($intNuevoEstado, $intIdUsuario) {
        if ($intNuevoEstado == -1 || $intNuevoEstado == 1) {
            $this->_post->eliminarUsuario($intIdUsuario, $intNuevoEstado);
        } else {
            $this->_view->cambio = "No reconocio ningun parametro";
        }
        $this->redireccionar('gestionUsuario');
    }

    public function actualizarUsuario($intIdUsuario = 0) {
        $valorPagina = $this->getInteger('hdEnvio');
        $this->_view->setJs(array('actualizarUsuario'));
        $this->_view->setJs(array('jquery.validate'), "public");
        
        $arrayUsr = array();
        $actualizar = false;
        $this->_view->id = $intIdUsuario;
        $this->_view->rol = $this->_post->getRol($intIdUsuario)[0][0];
        $this->_view->preguntas = $this->_post->getPreguntas();
        $this->_view->datosUsr = $this->_post->datosUsuario($intIdUsuario);
        $this->_view->unidades = $this->_ajax->getUnidades();

        if ($valorPagina == 1) {
            if (!$this->getTexto('txtNombre') || !$this->getTexto('txtCorreo') || !$this->getInteger('slPregunta') || !$this->getTexto('txtRespuesta')) {
                $this->_view->renderizar('gestionUsuario', 'actualizarUsuario');
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
            $arrayUsr['preguntaUsr'] = $this->getInteger('slPregunta');
            $arrayUsr['respuestaUsr'] = $this->getTexto('txtRespuesta');
            
            $this->_post->actualizarUsuario($arrayUsr);
            $this->redireccionar('gestionUsuario/actualizarUsuario/'.$intIdUsuario);
            
        }
        $this->_view->renderizar('actualizarUsuario', 'admCrearUsuario');
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
                    $cadena .= $data[0] . ", ";
                    $arrayUsr = array();
                    $arrayEst = array();
                    $arrayEmp = array();
                    $arrayCat = array();
                    $rol = $data[6];
                    $arrayUsr["nombreUsr"] = $data[1];
                    $arrayUsr["correoUsr"] = $data[5];
                    $arrayUsr["fotoUsr"] = "";
                    $claveAleatoria = $this->_encriptar->keyGenerator();
                    $arrayUsr["claveUsr"] = $this->_encriptar->encrypt($claveAleatoria, UNIDAD_ACADEMICA);
                    $arrayUsr["preguntaUsr"] = 0;
                    $arrayUsr["respuestaUsr"] = "USAC";
                    $arrayUsr["intentosUsr"] = 5;
                    $arrayUsr["unidadUsr"] = UNIDAD_ACADEMICA;
                    $idUsr = $this->_post->agregarUsuario($arrayUsr)[0][0];
                    switch($rol){
                        case "1":
                            $arrayEst["id"] = $idUsr;
                            $arrayEst["carnetEst"] = $data[0];
                            $arrayEst["nombreEst"] = $data[1];
                            $arrayEst["nombreEst2"] = $data[2];
                            $arrayEst["apellidoEst"] = $data[3];
                            $arrayEst["apellidoEst2"] = $data[4];
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
                            $this->_post->agregarEstudiante($arrayEst);
                            $this->_post->asignarRolUsuario(ROL_ESTUDIANTE, $idUsr);
                            break;
                        case "2":
                            $arrayCat["id"] = $idUsr;
                            $arrayCat["registroCat"] = $data[0];
                            $arrayCat["nombreCat"] = $data[1];
                            $arrayCat["nombreCat2"] = $data[2];
                            $arrayCat["apellidoCat"] = $data[3];
                            $arrayCat["apellidoCat2"] = $data[4];
                            $arrayCat["direccionCat"] = "ciudad";
                            $arrayCat["zonaCat"] = 0;
                            $arrayCat["municipioCat"] = 1;
                            $arrayCat["telefonoCat"] = "22220000";
                            $arrayCat["paisCat"] = 1;
                            $arrayCat["tipoCat"] = 1;
                            $this->_post->agregarCatedratico($arrayCat);
                            $this->_post->asignarRolUsuario(ROL_DOCENTE, $idUsr);
                            break;
                        case "0":
                        case "3":
                            $arrayEmp["id"] = $idUsr;
                            $arrayEmp["registroEmp"] = $data[0];
                            $arrayEmp["nombreEmp"] = $data[1];
                            $arrayEmp["nombreEmp2"] = $data[2];
                            $arrayEmp["apellidoEmp"] = $data[3];
                            $arrayEmp["apellidoEmp2"] = $data[4];
                            $arrayEmp["direccionEmp"] = "ciudad";
                            $arrayEmp["zonaEmp"] = 0;
                            $arrayEmp["municipioEmp"] = 1;
                            $arrayEmp["telefonoEmp"] = "22220000";
                            $arrayEmp["paisEmp"] = 1;
                            $this->_post->agregarEmpleado($arrayEmp);
                            $this->_post->asignarRolUsuario($data[6], $idUsr);
                            break;
                    }
                }
                fclose($handle);
                $this->redireccionar('gestionUsuario');
            }else{
                echo "<script>alert('El archivo cargado no cumple con el formato csv');</script>";
            }
        }
        $this->redireccionar('gestionUsuario/agregarUsuario');
    }
    
    protected function notificacionEMAIL() {
        // El mensaje
        $mensaje = "Este es un mensaje de prueba";
        
        // Si cualquier línea es más larga de 70 caracteres, se debería usar wordwrap()
        $mensaje = wordwrap($mensaje, 70, "\r\n");
        
        // Enviarlo
        mail('rick.shark130@gmail.com', 'Mi título', $mensaje);
    }
}

?>

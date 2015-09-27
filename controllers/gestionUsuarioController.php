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

    public function index(){
        session_start();

        if(isset($_SESSION["rol"])){
            $rol = $_SESSION["rol"];
            $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_GESTIONUSUARIO);
        }else{
            $this->redireccionar("error/noRol/1000");
            exit;
        }
        
        if($rolValido[0]["valido"]!=PERMISO_GESTIONAR){
            echo "<script>
                alert('No tiene permisos para acceder a esta función.');
                window.location.href='" . BASE_URL . "login/inicio';
                </script>";
        }
        
            
        $idCentroUnidad = $_SESSION["centrounidad"];

        $this->_view->titulo = 'Gestión de usuarios - ' . APP_TITULO;
        $this->_view->id = $idCentroUnidad;
        $this->_view->setJs(array('gestionUsuario'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $lstUsr = $this->_post->informacionUsuario($idCentroUnidad);
        if(is_array($lstUsr)){
            $this->_view->lstUsr = $lstUsr;
        }else{
            $this->redireccionar("error/sql/" . $lstUsr);
            exit;
        }

        $this->_view->renderizar('gestionUsuario');
        
    }
    
    public function agregarUsuario() {
        session_start();
        
        $iden = $this->getInteger('hdEnvio');
        $idCentroUnidad = $_SESSION["centrounidad"];
        $idUsr = 0;
        $nombreUsr = '';
        $correoUsr = '';
        $fotoUsr = '';
        $crearUsr = false;

        $arrayUsr = array();
        $arrayEst = array();
        $arrayEmp = array();
        $arrayCat = array();
        
        $lstCentros = $this->_post->getCentros();
        if(is_array($lstCentros)){
            $this->_view->centros = $lstCentros;
        }else{
            $this->redireccionar("error/sql/" . $lstCentros);
            exit;
        }
        
        $lstDocentes = $this->_post->getDocentes();
        if(is_array($lstDocentes)){
            $this->_view->docentes = $lstDocentes;
        }else{
            $this->redireccionar("error/sql/" . $lstDocentes);
            exit;
        }
        
        $this->_view->titulo = 'Agregar Usuario - ' . APP_TITULO;
        $this->_view->idCentroUnidad = $idCentroUnidad;
        $this->_view->setJs(array('agregarUsuario'));
        $this->_view->setJs(array('jquery.validate'), "public");

        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_CREARUSUARIO);
         
        if($rolValido[0]["valido"]!= PERMISO_CREAR){
           echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionUsuario" . "';
                </script>";
        }
        
        if ($iden == 1) {
            $carnet = $this->getTexto('txtCarnetEst');
            $nombreUsr = $this->getTexto('txtNombreEst1');
            $correoUsr = $this->getTexto('txtCorreoEst');
            $fotoUsr = $this->getTexto('txtFotoEst');
            $crearUsr = $this->validarExistencia($carnet,$idCentroUnidad,1);
        } elseif ($iden == 2) {
            $registro = $this->getTexto('txtCodigoCat');
            $nombreUsr = $this->getTexto('txtNombreCat1');
            $correoUsr = $this->getTexto('txtCorreoCat');
            $fotoUsr = $this->getTexto('txtFotoCat');
            $crearUsr = $this->validarExistencia($registro,$idCentroUnidad,2);
        } elseif ($iden == 3) {
            $registro = $this->getTexto('txtCodigoEmp');
            $nombreUsr = $this->getTexto('txtNombreEmp1');
            $correoUsr = $this->getTexto('txtCorreoEmp');
            $fotoUsr = $this->getTexto('txtFotoEmp');
            $crearUsr = $this->validarExistencia($registro,$idCentroUnidad,3);
        }

        if ($crearUsr) {
            $arrayUsr["nombreUsr"] = $nombreUsr;
            $arrayUsr["correoUsr"] = $correoUsr;
            $arrayUsr["fotoUsr"] = $fotoUsr;
            $claveAleatoria = $this->_encriptar->keyGenerator();
            $arrayUsr["claveUsr"] = $this->_encriptar->encrypt($claveAleatoria, DB_KEY);
            $arrayUsr["preguntaUsr"] = 0;
            $arrayUsr["respuestaUsr"] = "USAC";
            $arrayUsr["intentosUsr"] = 5;
            $arrayUsr["centroUnidad"] = $_SESSION["centrounidad"];
            
            $nuevoUsr = $this->_post->agregarUsuario($arrayUsr);
            if(is_array($nuevoUsr)){
                $idUsr = $nuevoUsr[0][0];
            }else{
                $this->redireccionar("error/sql/" . $nuevoUsr);
                exit;
            }
            
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
                
                $nuevoEST = $this->_post->agregarEstudiante($arrayEst);
                if(!is_array($nuevoEST)){
                    $this->redireccionar("error/sql/" . $nuevoEST);
                    exit;
                }
                
                $nuevoRol = $this->_post->asignarRolUsuario(ROL_ESTUDIANTE, $idUsr);
                if(!is_array($nuevoRol)){
                    $this->redireccionar("error/sql/" . $nuevoRol);
                    exit;
                }
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
                
                $nuevoCAT = $this->_post->agregarCatedratico($arrayCat);
                if(!is_array($nuevoCAT)){
                    $this->redireccionar("error/sql/" . $nuevoCAT);
                    exit;
                }
                
                $nuevoRol = $this->_post->asignarRolUsuario(ROL_DOCENTE, $idUsr);
                if(!is_array($nuevoRol)){
                    $this->redireccionar("error/sql/" . $nuevoRol);
                    exit;
                }
                
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
                
                $nuevoEmp = $this->_post->agregarEmpleado($arrayEmp);
                if(!is_array($nuevoEmp)){
                    $this->redireccionar("error/sql/" . $nuevoEmp);
                    exit;
                }
                
                $nuevoRol = $this->_post->asignarRolUsuario(ROL_EMPLEADO, $idUsr);
                if(!is_array($nuevoRol)){
                    $this->redireccionar("error/sql/" . $nuevoRol);
                    exit;
                }
            }
            //$this->notificacionEMAIL();
            $this->redireccionar('gestionUsuario');
            exit;
        }

        $this->_view->renderizar('agregarUsuario', 'gestionUsuario');
    }

    public function eliminarUsuario($intNuevoEstado, $intIdUsuario) {
        session_start();
        $rol = $_SESSION["rol"];
        $idCentroUnidad = $_SESSION["centrounidad"];
        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_ELIMINARUSUARIO);
        
        if($rolValido[0]["valido"]== PERMISO_ELIMINAR){
            if ($intNuevoEstado == -1 || $intNuevoEstado == 1) {
                $borrar = $this->_post->eliminarUsuario($intIdUsuario, $idCentroUnidad, $intNuevoEstado);
                if(is_array($borrar)){
                    $this->_view->docentes = $borrar;
                }else{
                    $this->redireccionar("error/sql/" . $borrar);
                    exit;
                }
            } else {
                $this->_view->cambio = "No reconocio ningun parametro";
            }
            $this->redireccionar('gestionUsuario');
        }
        else
        {         
            echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionUsuario" . "';
                </script>";
        }
    }

    public function actualizarUsuario($intIdUsuario = 0) {
        session_start();
        $rol = $_SESSION["rol"];
        $idCentroUnidad = $_SESSION["centrounidad"];
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_MODIFICARUSUARIO);
         
        if($rolValido[0]["valido"]!= PERMISO_MODIFICAR){
           echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionUsuario" . "';
                </script>";
        }
        
        $valorPagina = $this->getInteger('hdEnvio');
        
        $arrayUsr = array();
        $actualizar = false;
        $this->_view->id = $intIdUsuario;
        
        $idRol = $this->_post->getRol($intIdUsuario);
        if(is_array($idRol)){
            $this->_view->rol = $idRol[0][0];
        }else{
            $this->redireccionar("error/sql/" . $idRol);
            exit;
        }
        
        $lsPreguntas = $this->_post->getPreguntas();
        if(is_array($lsPreguntas)){
            $this->_view->preguntas = $lsPreguntas;
        }else{
            $this->redireccionar("error/sql/" . $lsPreguntas);
            exit;
        }
        
        $dtUsr = $this->_post->datosUsuario($intIdUsuario,$idCentroUnidad);
        if(is_array($dtUsr)){
            $this->_view->datosUsr = $dtUsr;
        }else{
            $this->redireccionar("error/sql/" . $dtUsr);
            exit;
        }
        
        $lsUnidades = $this->_view->unidades = $this->_ajax->getUnidades();
        if(is_array($lsUnidades)){
            $this->_view->unidades = $lsUnidades;
        }else{
            $this->redireccionar("error/sql/" . $lsUnidades);
            exit;
        }
        
        $this->_view->setJs(array('actualizarUsuario'));
        $this->_view->setJs(array('jquery.validate'), "public");
            
        $pass = $this->getTexto('pass');
        $passActual = $this->getTexto('txtPassword');
        $passNueva = $this->getTexto('txtPasswordNuevo');
        $passValida = $this->getTexto('txtPasswordNuevo2');
        $idPregunta = $this->getInteger('preguntaActual');
        $strRespuesta = $this->getTexto('txtRespuesta');
        
        if ($valorPagina == 1) {
            if(!$this->getTexto('txtCorreo')){
                $this->_view->renderizar('gestionUsuario', 'actualizarUsuario');
                exit;
            }
            
            //Actualizacion de contraseña
            if(strcmp($passActual,"")!=0 || strcmp($passNueva,"")!=0 || strcmp($passValida,"")!=0){
                $encriptar = $this->_encriptar->encrypt($passActual, DB_KEY);
                if(strcmp($pass,$encriptar) == 0){
                    if(strcmp($passNueva,$passValida) == 0 && strcmp($passNueva,"")!=0){
                        $passNueva = $this->_encriptar->encrypt($passValida, DB_KEY);
                    }else{
                        $this->_view->error = 'La contraseña nueva no coincide';
                        $this->_view->renderizar('actualizarUsuario', 'gestionUsuario');
                        exit;
                    }    
                }else{
                    $this->_view->error = 'La contraseña actual es incorrecta';
                    $this->_view->renderizar('actualizarUsuario', 'gestionUsuario');
                    exit;
                }
            }else{
                $passNueva = $pass;
            }
            
            //Actualizacion de pregunta secreta
            if($this->getInteger('slPregunta') != 0){
                if(strcmp($strRespuesta,"")!=0){
                    $idPregunta = $this->getInteger('slPregunta');
                }else{
                    $this->_view->error = 'Debe ingresar una respuesta';
                    $this->_view->renderizar('actualizarUsuario', 'gestionUsuario');
                    exit;
                }
            }else{
                if($idPregunta == 0){
                    $this->_view->error = 'Es necesario que establesca una pregunta secreta con respuesta';
                    $this->_view->renderizar('actualizarUsuario', 'gestionUsuario');
                    exit;
                }else{
                    $idPregunta = $this->getInteger('preguntaActual');
                    $strRespuesta = $this->_post->datosUsuario($intIdUsuario)[0]['respuestasecreta'];
                }
            }
            $actualizar = true;
        }
        
        if ($actualizar) {
            //Actualizacion de correo electronico
            $arrayUsr['id'] = $intIdUsuario;
            $arrayUsr['correoUsr'] = $this->getTexto('txtCorreo');
            $arrayUsr['clave'] = $passNueva;
            $arrayUsr['preguntaUsr'] = $idPregunta;
            $arrayUsr['respuestaUsr'] = $strRespuesta;
            
            $actualizarUsr = $this->_post->actualizarUsuario($arrayUsr);
            if(!is_array($actualizarUsr)){
                $this->redireccionar("error/sql/" . $actualizarUsr);
                exit;
            }
            
            $this->redireccionar('gestionUsuario/actualizarUsuario/'.$intIdUsuario);
        }
        $this->_view->renderizar('actualizarUsuario', 'gestionUsuario');
    }

    public function validarUsuario($intIdUsuario){
        if(!$this->usuarioCorrecto($intIdUsuario)){
            $this->redireccionar("error/index/1000");
            exit;
        }
        
        $paises = $this->_ajax->getPais();
        if(is_array($paises)){
            $this->_view->paises = $paises;
        }else{
            $this->redireccionar("error/sql/" . $paises);
            exit;
        }
        
        $lsDeptos = $this->_ajax->getDeptos();
        if(is_array($lsDeptos)){
            $this->_view->deptos = $lsDeptos;
        }else{
            $this->redireccionar("error/sql/" . $lsDeptos);
            exit;
        }
        
        $dtUsr = $this->_post->datosUsuario($intIdUsuario,1);
        if(is_array($dtUsr)){
            $this->_view->datosUsr = $dtUsr;
        }else{
            $this->redireccionar("error/sql/" . $dtUsr);
            exit;
        }
        
        $lsPreguntas = $this->_post->getPreguntas();
        if(is_array($lsPreguntas)){
            $this->_view->preguntas = $lsPreguntas;
        }else{
            $this->redireccionar("error/sql/" . $lsPreguntas);
            exit;
        }
        
        $this->_view->titulo = 'Gestión de usuarios - ' . APP_TITULO;
        $this->_view->setJs(array('validarUsuario'));
        $this->_view->setJs(array('jquery.validate'), "public");
        
        
        $this->_view->renderizar('validarUsuario');
    }
    
    public function activarUsuario(){
        $arrayUsr = array();
        $arrayGen = array();
        $idUsuario = $this->getInteger('hdWho');
        $arrayUsr['id'] = $idUsuario;
        $arrayUsr['correoUsr'] = $this->getTexto('txtCorreo');
        $passNueva = $this->_encriptar->encrypt($this->getTexto('txtPasswordNuevo'), DB_KEY);
        $arrayUsr['clave'] = $passNueva;
        $arrayUsr['preguntaUsr'] = $this->getInteger('slPregunta');
        $arrayUsr['respuestaUsr'] = $this->getTexto('txtRespuesta');
        
        $actualizarUsr = $this->_post->actualizarUsuario($arrayUsr);
        if(!is_array($actualizarUsr)){
            $this->redireccionar("error/sql/" . $actualizarUsr);
            exit;
        }
        
        $rol = $this->getInteger('hdRol');
        $arrayGen["id"] = $idUsuario;
        $arrayGen["direccion"] = $this->getTexto('txtDireccion');
        $arrayGen["zona"] = $this->getInteger('txtZona');
        $arrayGen["muni"] = $this->getInteger('slMunis');
        $arrayGen["telefono"] = $this->getTexto('txtTelefono');
        $arrayGen["pais"] = $this->getInteger('slPaises');
        if($rol == 1){
            $est = $this->loadModel("estudiante");
            $info = $est->setInfoGeneral($arrayGen);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            
            $arrayEmg = array();
            $arrayEmg["id"] = $idUsuario;
            $arrayEmg["telefonoE"] = $this->getTexto('txtTelefonoE');
            $arrayEmg["alergias"] = $this->getTexto('txtAlergias');
            $arrayEmg["sangre"] = $this->getTexto('txtTipoSangre');
            $arrayEmg["centro"] = $this->getTexto('txtHospital');
            $arrayEmg["seguro"] = $this->getInteger('rbSeguro');
            $infoEm = $est->setInfoEmergencia($arrayEmg);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $infoEm);
                exit;
            }
        }else if($rol == 2){
            $cat = $this->loadModel("catedratico");
            $info = $cat->setInfo($arrayGen);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
        }else if($rol == 3 || $rol == 0){
            $emp = $this->loadModel("empleado");
            $info = $emp->setInfo($arrayGen);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
        }
        $activar = $this->_post->activarUsuario($idUsuario, 1);
        if(!is_array($activar)){
            $this->redireccionar("error/sql/" . $activar);
            exit;
        }
        $this->redireccionar('login/bienvenida');
    }
    
    public function cargarCSV(){
        $iden = $this->getInteger('hdFile');
        session_start();
        $idCentroUnidad = $_SESSION["centrounidad"];
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
                    $arrayUsr = array();
                    $arrayEst = array();
                    $arrayEmp = array();
                    $arrayCat = array();
                    $rol = $data[6];
                    $arrayUsr["nombreUsr"] = $data[1];
                    $arrayUsr["correoUsr"] = $data[5];
                    $arrayUsr["fotoUsr"] = "";
                    $claveAleatoria = $this->_encriptar->keyGenerator();
                    $arrayUsr["claveUsr"] = $this->_encriptar->encrypt($claveAleatoria, DB_KEY);
                    $arrayUsr["preguntaUsr"] = 0;
                    $arrayUsr["respuestaUsr"] = "USAC";
                    $arrayUsr["intentosUsr"] = 5;
                    $arrayUsr["centroUnidad"] = $idCentroUnidad;
                    $nuevoUsr = $this->_post->agregarUsuario($arrayUsr);
                    if(is_array($nuevoUsr)){
                        $idUsr = $nuevoUsr[0][0];
                    }else{
                        fclose($handle);
                        $this->redireccionar("error/sql/" . $nuevoUsr);
                        exit;
                    }
                    
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
                            
                            $nuevoEST = $this->_post->agregarEstudiante($arrayEst);
                            if(!is_array($nuevoEST)){
                                fclose($handle);
                                $this->redireccionar("error/sql/" . $nuevoEST);
                                exit;
                            }

                            $nuevoRol = $this->_post->asignarRolUsuario(ROL_ESTUDIANTE, $idUsr);
                            if(!is_array($nuevoRol)){
                                fclose($handle);
                                $this->redireccionar("error/sql/" . $nuevoRol);
                                exit;
                            }
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
                            $nuevoCAT = $this->_post->agregarCatedratico($arrayCat);
                            if(!is_array($nuevoCAT)){
                                fclose($handle);
                                $this->redireccionar("error/sql/" . $nuevoCAT);
                                exit;
                            }

                            $nuevoRol = $this->_post->asignarRolUsuario(ROL_DOCENTE, $idUsr);
                            if(!is_array($nuevoRol)){
                                fclose($handle);
                                $this->redireccionar("error/sql/" . $nuevoRol);
                                exit;
                            }
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
                            
                            $nuevoEmp = $this->_post->agregarEmpleado($arrayEmp);
                            if(!is_array($nuevoEmp)){
                                fclose($handle);
                                $this->redireccionar("error/sql/" . $nuevoEmp);
                                exit;
                            }

                            $nuevoRol = $this->_post->asignarRolUsuario($data[6], $idUsr);
                            if(!is_array($nuevoRol)){
                                fclose($handle);
                                $this->redireccionar("error/sql/" . $nuevoRol);
                                exit;
                            }
                            break;
                    }
                }
                fclose($handle);
                $this->redireccionar('gestionUsuario');
                exit;
            }else{
                echo "<script>alert('El archivo cargado no cumple con el formato csv');</script>";
            }
        }
        $this->redireccionar('gestionUsuario/agregarUsuario');
    }
    
    private function usuarioCorrecto($idUsuario){
        session_start();
        if(isset($_SESSION['usuario'])){
            if($_SESSION['usuario'] == $idUsuario){
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    
    private function validarExistencia($id, $cen, $tipo){
        $existe;
        if($tipo == 1){
            $existe = $this->_post->buscarEstudiante($id);
        }else if($tipo == 2){
            $existe = $this->_post->buscarCatedratico($id);
        }else if($tipo==3){
            $existe = $this->_post->buscarEmpleado($id);
        }
        
        if(!is_array($existe)){
            $this->redireccionar("error/sql/" . $existe);
            exit;
        }else{
            if(is_numeric($existe[0][0])){
                $agrega = $this->_post->setCentroUnidadUsuario($existe[0][0],$cen);
                if(!is_array($agrega)){
                    $this->redireccionar("error/sql/" . $agrega);
                    exit;
                }
                $this->redireccionar('gestionUsuario');
                exit;
            }
        }
        return true;
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

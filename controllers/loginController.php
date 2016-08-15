<?php

/**
 * Description of gestionPensumController
 *
 * @author Arias
 */
class loginController extends Controller{
    
    private $_login;
    private $_bitacora;
    private $_encriptar;
    private $_ajax;
    private $_verifica_usuario;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->getLibrary('wsVerificaUsuario');
        $this->_encriptar = new encripted();
        $this->_login = $this->loadModel('login');
        $this->_bitacora = $this->loadModel('bitacora');
        $this->_ajax = $this->loadModel('ajax');
    }

    public function index(){
        $this->_view->titulo = 'Escuela de Historia - USAC';
        $this->_view->setJs(array('logearUsuario'));
        $this->_view->setJs(array('jquery.validate'),"public");
        $this->_view->renderizar('login');
    }
    
    public function inicio(){
        session_start();
        if(isset($_SESSION["rol"]) && $_SESSION["rol"]==0 || $_SESSION["rol"]==3){
            $this->_view->renderizar('inicio','login');
        }else{
            $this->redireccionar("error/norol/1000");
            exit;
        }
    }
    
    public function bienvenida(){
        session_start();
        if(isset($_SESSION["usuario"])){
            $this->_view->renderizar('bienvenida','login');
        }else{
            $this->redireccionar("error/norol/1000");
            exit;
        }
    }
    
    public function autenticar(){
        $urlCentroUnidad = '';
        $this->_view->titulo = APP_TITULO;
        
        $usuario = $this->getTexto('usuario');
        $pass = $this->getTexto('pass');
        $tipo = $this->getInteger('tipo');
        
        $passEncrypt = $this->_encriptar->encrypt($pass, DB_KEY);
        $maxintentos = $this->_ajax->valorParametro(CONS_PARAM_APP_MAXREINTENTOS, -1, -1);
        if(!is_array($maxintentos)){
            $this->redireccionar("error/sql/" . $maxintentos);
            exit;
        }
        $maxintentos = (isset($maxintentos[0]['valorparametro']) ? $maxintentos[0]['valorparametro'] : -1);
        $respuesta = $this->_login->autenticarUsuario($tipo, $usuario, $passEncrypt, $maxintentos);
        if(!is_array($respuesta)){
            $this->redireccionar("error/login/" . $respuesta);
            exit;
        }
        
        if (count($respuesta) > 0){
            session_start();
            if($respuesta[0]['estado'] == ESTADO_INACTIVO){
                echo "<script>
                alert('El usuario se encuentra bloqueado. Comuníquese con la administración para resolver el problema.');
                window.location.href='" . BASE_URL . "login/" . "';
                </script>";
                exit;
            }
            if (count($respuesta) > 1){
                if($respuesta[0]['rol'] <> ROL_ADMINISTRADOR){
                    $urlCentroUnidad = 'general/seleccionarCentroUnidad/';
                }
                else{
                    $_SESSION["centrounidad"] = $respuesta[0]['centrounidadacademica'];
                    $tipociclo = $this->_ajax->valorParametro(CONS_PARAM_CENTROUNIDAD_TIPOCICLO, -1, $_SESSION["centrounidad"]);
                    if(!is_array($tipociclo)){
                        $this->redireccionar("error/sql/" . $tipociclo);
                        exit;
                    }
                    $_SESSION["tipociclo"] = (isset($tipociclo[0]['valorparametro']) ? $tipociclo[0]['valorparametro'] : NULL);
                }
            }
            else{
                $_SESSION["centrounidad"] = $respuesta[0]['centrounidadacademica'];
                $tipociclo = $this->_ajax->valorParametro(CONS_PARAM_CENTROUNIDAD_TIPOCICLO, -1, $_SESSION["centrounidad"]);
                if(!is_array($tipociclo)){
                    $this->redireccionar("error/sql/" . $tipociclo);
                    exit;
                }
                $_SESSION["tipociclo"] = (isset($tipociclo[0]['valorparametro']) ? $tipociclo[0]['valorparametro'] : NULL);
            }
            
            $_SESSION["usuario"] = $respuesta[0]['usuario'];
            $_SESSION["rol"] = $respuesta[0]['rol'];
            $_SESSION["nombre"] = $respuesta[0]['nombre'];
            $_SESSION["tiempo"] = time();
            
            //Insertar en bitácora
            $this->insertarBitacoraUsuario(CONS_FUNC_LOGIN, 'El usuario ha iniciado sesión'); 

            $actualizarAutenticacion = $this->_login->actualizarAutenticacion($_SESSION["usuario"]);
            if(!is_array($actualizarAutenticacion)){
                $this->redireccionar("error/sql/" . $actualizarAutenticacion);
                exit;
            }
            
            if($respuesta[0]['estado'] == ESTADO_ACTIVO){
                if($respuesta[0]['rol']==1){
                    $this->redireccionar($urlCentroUnidad.'estudiante/inicio');
                    exit;
                }elseif($respuesta[0]['rol']==2){
                    $this->redireccionar($urlCentroUnidad.'catedratico/inicio');
                    exit;
                }else{
                    $this->redireccionar($urlCentroUnidad.'login/inicio');
                    exit;
                }
            }else if($respuesta[0]['estado'] == ESTADO_PENDIENTE){
                $this->redireccionar($urlCentroUnidad.'gestionUsuario/validarUsuario/'.$_SESSION["usuario"]);
                exit;
            }
            else{
                $this->redireccionar('login/salir');
                exit;
            }
        }
        else{
            echo "<script>alert('Credenciales incorrectas');</script>";
            $this->index();
        }
    }

    public function salir(){
        session_start();
        if(isset($_SESSION["usuario"])){
            //Insertar en bitácora       
            $this->insertarBitacoraUsuario(CONS_FUNC_LOGOUT, 'El usuario ha finalizado sesión'); 
            
            session_destroy();
        }
        $this->redireccionar('login');
        exit;
    }
    
    public function existe(){
        $this->_verifica_usuario = new wsVerificaUsuario();
        echo $this->_verifica_usuario->consultar_estudiante(200516231,5391) . '<br/><br/>';
        echo $this->_verifica_usuario->consultar_estudiante(200611199,'ffb89b9c') . '<br/><br/>';
        echo $this->_verifica_usuario->consultar_estudiante(200410339,'UA2890061');
    }
}
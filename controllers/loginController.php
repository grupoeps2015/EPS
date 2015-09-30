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
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
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
        $respuesta = $this->_login->autenticarUsuario($tipo, $usuario, $passEncrypt);
        if(!is_array($respuesta)){
            $this->redireccionar("error/login/" . $respuesta);
            exit;
        }
        
        if (count($respuesta) > 0){
            session_start();
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
            $arrayBitacora = array();
            $arrayBitacora[":usuario"] = $_SESSION["usuario"];
            $arrayBitacora[":nombreusuario"] = $_SESSION["nombre"];
            $arrayBitacora[":funcion"] = CONS_FUNC_LOGIN;
            $arrayBitacora[":ip"] = $this->get_ip_address();
            $arrayBitacora[":registro"] = 0; //no se que es esto
            $arrayBitacora[":tablacampo"] = ''; //tampoco se que es esto
            $arrayBitacora[":descripcion"] = 'El usuario ha iniciado sesión.';
            $insert = $this->_bitacora->insertarBitacoraUsuario($arrayBitacora, $_SESSION["rol"]);
            if(!is_array($insert)){
                $this->redireccionar("error/sql/" . $insert);
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
            }
        }
        else{
            echo "<script>alert('Credenciales incorrectas');</script>";
            $this->index();
        }
    }

    public function salir(){
        session_start();
        if($_SESSION["usuario"]){
            //Insertar en bitácora            
            $arrayBitacora = array();
            $arrayBitacora[":usuario"] = $_SESSION["usuario"];
            $arrayBitacora[":nombreusuario"] = $_SESSION["nombre"];
            $arrayBitacora[":funcion"] = CONS_FUNC_LOGOUT;
            $arrayBitacora[":ip"] = $this->get_ip_address();
            $arrayBitacora[":registro"] = 0; //no se que es esto
            $arrayBitacora[":tablacampo"] = ''; //tampoco se que es esto
            $arrayBitacora[":descripcion"] = 'El usuario ha finalizado sesión.';
            $insert = $this->_bitacora->insertarBitacoraUsuario($arrayBitacora, $_SESSION["rol"]);
            if(!is_array($insert)){
                $this->redireccionar("error/sql/" . $insert);
                exit;
            }
            session_destroy();
        }
        $this->redireccionar('login');
    }
    
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
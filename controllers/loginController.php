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
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_login = $this->loadModel('login');
        $this->_bitacora = $this->loadModel('bitacora');
    }

    public function index(){
        $this->_view->titulo = 'Escuela de Historia - USAC';
        $this->_view->setJs(array('logearUsuario'));
        $this->_view->setJs(array('jquery.validate'),"public");
        $this->_view->renderizar('login');
    }
    
    public function inicio(){
        $this->_view->renderizar('inicio','login');
    }
    
    public function bienvenida(){
        $this->_view->renderizar('bienvenida','login');
    }
    
    public function autenticar(){
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
            for ($i=0;$i<count($respuesta);$i++){
                if($respuesta[$i]['rol'] == ROL_ADMINISTRADOR){
                    $indice = $i;
                    break;
                }
                else{
                    //El empleado, estudiante o catedratico escoge a qué centro_unidad entrar
                }
//                else if($respuesta[$i]['centrounidadacademica'] == CENTRO_UNIDADACADEMICA){
//                    $indice = $i;
//                    break;
//                }
            }
            if(isset($indice)){
                session_start();
                $_SESSION["usuario"] = $respuesta[$indice]['usuario'];
                $_SESSION["rol"] = $respuesta[$indice]['rol'];
                $_SESSION["nombre"] = $respuesta[$indice]['nombre'];
                $_SESSION["centrounidad"] = $respuesta[$indice]['centrounidadacademica'];
                
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
                    $this->redireccionar('login/inicio');
                }else if($respuesta[0]['estado'] == ESTADO_PENDIENTE){
                    $this->redireccionar('gestionUsuario/validarUsuario/'.$_SESSION["usuario"]);
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
        else{
            echo "<script>alert('Credenciales incorrectas');</script>";
            $this->index();
        }
    }

    public function salir(){
        session_start();
        session_destroy();
        
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
<?php

class loginController extends Controller{
    
    private $_login;
    private $_encriptar;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_login = $this->loadModel('autenticarUsuario');
    }

    public function index(){
        $this->_view->titulo = 'Escuela de Historia - USAC';
        $this->_view->setJs(array('logearUsuario'));
        $this->_view->setJs(array('jquery.validate'),"public");
        $this->_view->renderizar('login');
    }
    
    public function inicio(){
        $this->_view->renderizar('inicio');
    }
    
    public function autenticar(){
        $this->_view->titulo = APP_TITULO;
        
        $usuario = $this->getTexto('usuario');
        $pass = $this->getTexto('pass');
        $tipo = $this->getInteger('tipo');
        
        $passEncrypt = $this->_encriptar->encrypt($pass, UNIDAD_ACADEMICA);
        $respuesta = $this->_login->autenticarUsuario($tipo, $usuario, $passEncrypt);
        
        if (isset($respuesta) && count($respuesta) == 1){
            session_start();
            $_SESSION["usuario"] = $respuesta[0]['usuario'];
            $_SESSION["rol"] = $respuesta[0]['rol'];
            $_SESSION["nombre"] = $respuesta[0]['nombre'];
            //echo $this->get_ip_address();
            $this->redireccionar('login/inicio');
        }
        else{
            echo "<script>alert('Credenciales incorrectas');</script>";
            $this->_view->renderizar('login');
        }
    }

    public function salir(){
        session_start();
        session_destroy();
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
?>
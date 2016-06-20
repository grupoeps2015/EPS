<?php

abstract class Controller{
    protected $_view;
    private $_bitacora;
//    
    public function __construct(){
        $this->_view = new View(new Request);
        $this->_bitacora = $this->loadModel('bitacora');
    }
    
    abstract public function index();
    
    protected function loadModel($modelo){
        $modelo = $modelo . 'Model';
        $rutaModelo = ROOT . 'models' . DS . $modelo . '.php';
        if (is_readable($rutaModelo)){
            require_once $rutaModelo;
            $modelo = new $modelo;
            return $modelo;
        }else{
            throw new Exception("Model File not found " . $rutaModelo);
        }
    }
    
    protected function getLibrary($libreria){
        $rutaLibreria = ROOT . 'libs' . DS . $libreria . '.php';
        
        if(is_readable($rutaLibreria)){
            require_once $rutaLibreria;
        }else{
            throw new Exception('Library not found');
        }
    }
    
    protected function getTexto($entrada){
        if(isset($_POST[$entrada]) && !empty($_POST[$entrada])){
            $_POST[$entrada] = htmlspecialchars($_POST[$entrada],ENT_QUOTES);
            return $_POST[$entrada];
        }
        return '';
    }
    
    protected function getInteger($entrada){
        if(isset($_POST[$entrada]) && !empty($_POST[$entrada])){
            $_POST[$entrada] = filter_input(INPUT_POST, $entrada, FILTER_VALIDATE_INT);
            return $_POST[$entrada];
        }
        return 0;
    }
    
    protected function redireccionar($ruta = false){
        $urlEnvio=BASE_URL;
        if($ruta){
            $urlEnvio = $urlEnvio . $ruta;
        }
        echo '<script language="javascript">window.location.href="' . $urlEnvio . '"</script>';
    }
    
    protected function redireccionar2($ruta = false){
        if($ruta){
            header('Location:' . BASE_URL . $ruta);
            exit;
        }else{
            header('Location:' . BASE_URL);
            exit;
        }
    }
    
    protected function get_ip_address() {
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

    protected function insertarBitacoraUsuario($funcion, $descripcion){
        //Insertar en bitácora 
        $arrayBitacora = array();
        $arrayBitacora[":usuario"] = $_SESSION["usuario"];
        $arrayBitacora[":nombreusuario"] = $_SESSION["nombre"];
        $arrayBitacora[":funcion"] = $funcion;//CONS_FUNC_CUR_CONSULTARCURSO;
        $arrayBitacora[":ip"] = $this->get_ip_address();
        $arrayBitacora[":registro"] = 0;
        $arrayBitacora[":tablacampo"] = '';
        $arrayBitacora[":descripcion"] = $descripcion;//'El usuario ha consultado el catálogo de cursos';
        $insert = $this->_bitacora->insertarBitacoraUsuario($arrayBitacora, $_SESSION["rol"]);
        if(!is_array($insert)){
            $this->redireccionar("error/sql/" . $insert);
            exit;
        }
    }
    
}

?>
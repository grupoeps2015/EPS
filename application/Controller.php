<?php

abstract class Controller{
    protected $_view;
//    
    public function __construct(){
        $this->_view = new View(new Request);
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
}

?>
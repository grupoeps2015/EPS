<?php

class View{
    private $_controlador;
    
    public function __construct(Request $peticion) {
        $this->_controlador = $peticion->getControlador();
    }
    
    public function renderizarAdm($vista, $item = false){
        $_layoutParams = array(
            'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/',
            'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/',
            'ruta_js'  => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/'
        );
        $rutaView = ROOT . 'views' . DS . 'adm' . DS . $this->_controlador . DS . $vista . '.php';
        if(is_readable($rutaView)){
            include_once ROOT . 'views' . DS . 'layout' . DS . ADM_LAYOUT . DS . 'header.php';
            include_once $rutaView;
            include_once ROOT . 'views' . DS . 'layout' . DS . ADM_LAYOUT . DS . 'footer.php';
        }else{
            throw new Exception('View not found ' . $rutaView);
        }
    }
    
    public function renderizarAdmHistoria($vista, $item = false){
        $_layoutParams = array(
            'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/',
            'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/',
            'ruta_js'  => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/'
        );
        $rutaView = ROOT . 'views' . DS . 'admHistoria' . DS . $this->_controlador . DS . $vista . '.php';
        if(is_readable($rutaView)){
            include_once ROOT . 'views' . DS . 'layout' . DS . ADMH_LAYOUT . DS . 'header.php';
            include_once $rutaView;
            include_once ROOT . 'views' . DS . 'layout' . DS . ADMH_LAYOUT . DS . 'footer.php';
        }else{
            throw new Exception('View not found ' . $rutaView);
        }
    }
    
    public function renderizarUsrHistoria($vista, $item = false){
        $_layoutParams = array(
            'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/',
            'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/',
            'ruta_js'  => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/'
        );
        $rutaView = ROOT . 'views' . DS . 'usrHistoria' . DS . $this->_controlador . DS . $vista . '.php';
        if(is_readable($rutaView)){
            include_once ROOT . 'views' . DS . 'layout' . DS . USRH_LAYOUT . DS . 'header.php';
            include_once $rutaView;
            include_once ROOT . 'views' . DS . 'layout' . DS . USRH_LAYOUT . DS . 'footer.php';
        }else{
            throw new Exception('View not found ' . $rutaView);
        }
    }
    
}

?>
<?php

class View{
    private $_controlador;
    private $_publicJs;
    private $_js;
    
    public function __construct(Request $peticion) {
        $this->_controlador = $peticion->getControlador();
        $this->_publicJs = array();
        $this->_js = array();
    }
    
    public function renderizar($vista){
        $rutaView = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.php';
        if(is_readable($rutaView)){
            include_once $rutaView;
        }else{
            throw new Exception('View not found ' . $rutaView);
        }
    }
    
    public function renderizarAdm($vista, $item = false){
        $js = array();
        if(count($this->_js)){
            $js=$this->_js;
        }
        
        $publicjs = array();
        if(isset($this->_publicJs) && count($this->_publicJs)){
            $publicjs=$this->_publicJs;   
        }
        
        $publiccss = array();
        if(isset($this->_publicCss) && count($this->_publicCss)){
            $publiccss=$this->_publicCss;
        }
        
        $_layoutParams = array(
            'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/',
            'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/',
            'ruta_js'  => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/',
            'pubilc_js' => $publicjs,
            'js' => $js,
            'public_css' => $publiccss
        );
        
        $rutaView = ROOT . 'views' . DS . 'adm' . DS . $this->_controlador . DS . $vista . '.php';
        if(is_readable($rutaView)){
            include_once ROOT . 'views' . DS . 'layout' . DS . ADM_FOLDER . DS . 'header.php';
            include_once $rutaView;
            include_once ROOT . 'views' . DS . 'layout' . DS . ADM_FOLDER . DS . 'footer.php';
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
            include_once ROOT . 'views' . DS . 'layout' . DS . ADMH_FOLDER . DS . 'header.php';
            include_once $rutaView;
            include_once ROOT . 'views' . DS . 'layout' . DS . ADMH_FOLDER . DS . 'footer.php';
        }else{
            throw new Exception('View not found ' . $rutaView);
        }
    }
    
    public function renderizarUsrHistoria($vista, $item = false){
        $js = array();
        if(count($this->_js)){
            $js=$this->_js;
        }
        $_layoutParams = array(
            'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/',
            'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/',
            'ruta_js'  => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/',
            'js' => $js,
        );
        $rutaView = ROOT . 'views' . DS . 'usrHistoria' . DS . $this->_controlador . DS . $vista . '.php';
        if(is_readable($rutaView)){
            include_once ROOT . 'views' . DS . 'layout' . DS . USRH_FOLDER . DS . 'header.php';
            include_once $rutaView;
            include_once ROOT . 'views' . DS . 'layout' . DS . USRH_FOLDER . DS . 'footer.php';
        }else{
            throw new Exception('View not found ' . $rutaView);
        }
    }
    
    public function setJs($folder, array $js){
        if(is_array($js) && count($js)){
            for($i=0; $i<count($js); $i++){
                $this->_js[] = BASE_URL . 'views/' . $folder. '/' . $this->_controlador . '/js/' . $js[$i] . '.js';
            }
        }else{
            throw new Exception("JS file not found");
        }
    }
    
    public function setPublicJs(array $js1){
        if(is_array($js1) && count($js1)){
            for($i=0; $i<count($js1); $i++){
                $this->_publicJs[] = BASE_URL . 'public/js/' . $js1[$i] . '.js';
            }
        }else{
            throw new Exception("JS file not found");
        }
    }
    
    public function setPublicCSS(array $css1){
        if(is_array($css1) && count($css1)){
            for($i=0; $i<count($css1); $i++){
                $this->_publicCss[] = BASE_URL . 'public/css/' . $css1[$i] . '.css';
            }
        }else{
            throw new Exception("CSS file not found");
        }
    }
}

?>
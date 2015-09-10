<?php

class View{
    private $_controlador;
    private $_css;
    private $_js;
    
    public function __construct(Request $peticion) {
        $this->_controlador = $peticion->getControlador();
        $this->_publicJs = array();
        $this->_js = array();
    }
    
    public function renderizar($vista, $item = false){
        $js = array();
        $css = array();
        
        if(count($this->_js)){
            $js=$this->_js; 
        }
        
        if(isset($this->_css) && count($this->_css)){
            $css=$this->_css;
        }
        
        $_layoutParams = array(
            'ruta_css' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/css/',
            'ruta_img' => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/img/',
            'ruta_js'  => BASE_URL . 'views/layout/' . DEFAULT_LAYOUT . '/js/',
            'js' => $js, 'css' => $css
        );
        
        $rutaView = ROOT . 'views' . DS . $this->_controlador . DS . $vista . '.php';
        if(is_readable($rutaView)){
            include_once ROOT . 'views' . DS . 'layout' . DS . 'header.php';
            include_once $rutaView;            
            include_once ROOT . 'views' . DS . 'layout' . DS . 'footer.php';
        }else{
            throw new Exception('View not found ' . $rutaView);
        }
    }
    
    public function setJs(array $js, $folder=""){
        if(is_array($js) && count($js)){
            for($i=0; $i<count($js); $i++){
                if(strcmp($folder,"public") == 0){
                    $this->_js[] = BASE_URL . 'public/js/' . $js[$i] . '.js';
                }else{
                    $this->_js[] = BASE_URL . 'views/' . $this->_controlador . '/js/' . $js[$i] . '.js';
                }
            }
        }else{
            throw new Exception("JS file not found");
        }
    }
    
    public function setCSS(array $css){
        if(is_array($css) && count($css)){
            for($i=0; $i<count($css); $i++){
                $this->_css[] = BASE_URL . 'public/css/' . $css[$i] . '.css';
            }
        }else{
            throw new Exception("CSS file not found");
        }
    }
    
}
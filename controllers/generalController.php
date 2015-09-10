<?php

/**
 * Description of gestionCursoController
 *
 * @author Arias
 */
class generalController extends Controller{
    
    private $_ajax;
    
    public function __construct() {
        parent::__construct();
        $this->_ajax = $this->loadModel("ajax");
    }

    public function index(){
        
    }
    
    public function seleccionarCentroUnidad(){
        $url = "";
        $numargs = func_num_args();
        if($numargs > 0){
            for($i =0; $i < $numargs; $i++){
                $url .= func_get_arg($i) . "/" ;
            }
        }
        session_start();
        if (isset($_SESSION["rol"]) && $_SESSION["rol"] == ROL_ADMINISTRADOR){
            $lstCentros = $this->_ajax->getCentro();
            if(is_array($lstCentros)){
                $this->_view->lstCentros = $lstCentros;
            }else{
                $this->redireccionar("error/sql/" . $lstCentros);
                exit;
            }
            
            $this->_view->titulo = 'Seleccionar Centro y Unidad - ' . APP_TITULO;
            $this->_view->url = $url;
            $this->_view->setJs(array('seleccionarCentroUnidad'));
            $this->_view->renderizar('seleccionarCentroUnidad');
        }
        else {
            $this->redireccionar($url);
        }
    }
    
}
?>
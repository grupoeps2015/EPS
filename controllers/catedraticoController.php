<?php

/**
 * Description of gestionNotas
 *
 * @author Rickardo
 */
class catedraticoController extends Controller{
    
    private $_cat;
    private $_ajax;
    private $_encriptar;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('session');
        $this->_session = new session();
        if(!$this->_session->validarSesion()){
            $this->redireccionar('login/salir');
            exit;
        }
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_cat = $this->loadModel('catedratico');
        $this->_ajax = $this->loadModel('ajax');
    }

    public function index(){
        $this->redireccionar('catedratico/infoCatedratico');
    }
    
    public function infoCatedratico($idUsuario=0){
        $iden = $this->getInteger('hdEnvio');
        $arrayInfo = array();
        
        $this->_view->titulo = APP_TITULO;
        $this->_view->id = $idUsuario;
        
        $deptos = $this->_view->deptos = $this->_ajax->getDeptos();
        if(is_array($deptos)){
            $this->_view->deptos = $deptos;
        }else{
            $this->redireccionar("error/sql/" . $deptos);
            exit;
        }
        
        $paises = $this->_ajax->getPais();
        if(is_array($paises)){
            $this->_view->paises = $paises;
        }else{
            $this->redireccionar("error/sql/" . $paises);
            exit;
        }
        
        
        $infoGeneral = $this->_cat->getInfoGeneral($idUsuario);
        if(is_array($infoGeneral)){
            $this->_view->infoGeneral = $infoGeneral;
        }else{
            $this->redireccionar("error/sql/" . $infoGeneral);
            exit;
        }
        
        $this->_view->setJs(array('catedratico'));
        $this->_view->setJs(array('jquery.validate'), "public");
        
        if($iden == 1){
            $arrayInfo["id"] = $idUsuario;
            $arrayInfo["direccion"] = $this->getTexto('txtDireccion');
            $arrayInfo["zona"] = $this->getInteger('txtZona');
            $arrayInfo["muni"] = $this->getInteger('slMunis');
            $arrayInfo["telefono"] = $this->getTexto('txtTelefono');
            $arrayInfo["pais"] = $this->getInteger('slPaises');
            $info = $this->_cat->setInfo($arrayInfo);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            $this->redireccionar('catedratico/infoCatedratico/'. $idUsuario);
        }
        
        $this->_view->renderizar('catedratico');
    }

    public function inicio(){
        if(isset($_SESSION['usuario'])){
            $idUsuario = $_SESSION['usuario'];
            $infoGeneral = $this->_cat->getInfoGeneral($idUsuario);
            if(is_array($infoGeneral)){
                $this->_view->infoGeneral = $infoGeneral;
            }else{
                $this->redireccionar("error/sql/" . $infoGeneral);
                exit;
            }
            
            $this->_view->titulo = APP_TITULO;
            $this->_view->id = $idUsuario;
            $this->_view->setJs(array('inicio'));
            $this->_view->setJs(array('jquery.validate'), "public");
            $this->_view->renderizar('inicio','catedratico');
            
        }else{
            $this->redireccionar("error/noRol/1000");
            exit;
        }
    }
    
}

<?php

/**
 * Description of gestionCentroUnidadController
 *
 * @author Rickardo
 */
class gestionCentroUnidadController extends Controller {

    private $_gCenUni;
    private $_ajax;
    
    public function __construct() {
        parent::__construct();
        $this->_ajax = $this->loadModel("ajax");
        $this->_gCenUni = $this->loadModel('gestionCentroUnidad');
    }

    public function index() {
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONCURSO);
        
        if($rolValido[0]["valido"]!=PERMISO_GESTIONAR){        
            echo "<script>
                alert('No tiene permisos para acceder a esta función.');
                window.location.href='" . BASE_URL . "login/inicio';
                </script>";
        }
         
        $this->_view->titulo = 'Gestión de Centros Regionales - ' . APP_TITULO;
        

        $lstCentros = $this->_gCenUni->getInfoCentros();
        if(is_array($lstCentros)){
            $this->_view->lstCentros = $lstCentros;
        }else{
            $this->redireccionar("error/sql/" . $lstCentros);
            exit;
        }

        $this->_view->setJs(array('gestionCentroUnidad'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('gestionCentroUnidad');
        
    }

    public function agregarCentro() {
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_CREARCURSO);
         
        if($rolValido[0]["valido"]!= PERMISO_CREAR){
           echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionCurso';
                </script>";
        }
        
        $lsDeptos = $this->_ajax->getDeptos();
        if(is_array($lsDeptos)){
            $this->_view->lsDeptos = $lsDeptos;
        }else{
            $this->redireccionar('error/sql/' . $lsDeptos);
        }
        
        $this->_view->titulo = 'Agregar Centro - ' . APP_TITULO;
        $this->_view->setJs(array('agregarCentro'));
        $this->_view->setJs(array('jquery.validate'), "public");
        
        if ($this->getInteger('hdEnvio')) {
            $arrayCentro = array();
            $arrayCentro[":nombre"] = $this->getTexto('txtNombreCen');
            $arrayCentro[":direccion"] = $this->getTexto('txtDireccion');
            $arrayCentro[":municipio"] = $this->getInteger('slMunis');
            $arrayCentro[":zona"] = $this->getInteger('txtZona');
            
            $info = $this->_gCenUni->setCentro($arrayCentro);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            
            $this->redireccionar('gestionCentroUnidad');
            exit;
        }
        
        $this->_view->renderizar('agregarCentro', 'gestionCentroUnidad');
    }
    
    public function actualizarCentro($idCentro){
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_MODIFICARCURSO);
         
        if($rolValido[0]["valido"]!= PERMISO_MODIFICAR){
           echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionCurso';
                </script>";
        }
        
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarCentro'));
        
        $lsDeptos = $this->_ajax->getDeptos();
        if(is_array($lsDeptos)){
            $this->_view->lsDeptos = $lsDeptos;
        }else{
            $this->redireccionar('error/sql/' . $lsDeptos);
        }
        
        $datosCentro = $this->_gCenUni->getDatosCentro($idCentro);
        if(is_array($datosCentro)){
            $this->_view->datosCentro = $datosCentro;
        }else{
            $this->redireccionar("error/sql/" . $datosCentro);
            exit;
        }
        
        $this->_view->titulo = 'Actualizar Centro Universitario - ' . APP_TITULO;
        $this->_view->id = $idCentro;
        
        if ($this->getInteger('hdEnvio')) {
            $arrayCentro = array();
            $arrayCentro[":id"] = $idCentro;
            $arrayCentro[":nombre"] = $this->getTexto('txtNombreCen');
            $arrayCentro[":direccion"] = $this->getTexto('txtDireccion');
            $arrayCentro[":municipio"] = $this->getInteger('slMunis');
            $arrayCentro[":zona"] = $this->getInteger('txtZona');
            
            $info = $this->_gCenUni->updateCentro($arrayCentro);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }else{
                $this->_view->exito = "Informaci&oacute;n actualizada con &eacute;xito";
            }
            $this->redireccionar('gestionCentroUnidad/actualizarCentro/' . $idCentro);
            exit;
        }
        $this->_view->renderizar('actualizarCentro', 'gestionCentroUnidad');
    }
}
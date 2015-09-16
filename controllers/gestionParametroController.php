<?php

/**
 * Description of gestionParametroController
 *
 * @author Gerson
 */

class gestionParametroController extends Controller{
    private $_post;
    private $_ajax;
    
    public function __construct() {
        parent::__construct();
        $this->_post = $this->loadModel('gestionParametro');
        $this->_ajax = $this->loadModel("ajax");
    }

    public function index($id=0){
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_GESTIONPARAMETRO);
         
        if($rolValido[0]["valido"]!= PERMISO_GESTIONAR){
           echo "<script>
                alert('No tiene permisos para acceder a esta función.');
                window.location.href='" . BASE_URL . "login/inicio';
                </script>";
        }
        
            if($this->getInteger('hdCentroUnidad')){
                $idCentroUnidad = $this->getInteger('hdCentroUnidad');
            }else if ($id != 0){
                $idCentroUnidad = $id;
            }else{
                //session_start();
                $idCentroUnidad = $_SESSION["centrounidad"];
            }

            $this->_view->titulo = 'Gestión de parámetros - ' . APP_TITULO;
            $this->_view->id = $idCentroUnidad;
            
            //Se agregan los archivos JS, CSS, locales y publicos
            $this->_view->setJs(array('gestionParametro'));
            $this->_view->setJs(array('jquery.dataTables.min'), "public");
            $this->_view->setCSS(array('jquery.dataTables.min'));
            $this->_view->lstPar = $this->_post->informacionParametro($idCentroUnidad);
            
            //se renderiza la vista a mostrar
            $this->_view->renderizar('gestionParametro');
       
        
    }
    
    public function agregarParametro(){
        session_start();
                
        $iden = $this->getInteger('hdEnvio');
        $idCentroUnidad = $this->getInteger('hdCentroUnidad');
        
        $arrayPar = array();
        
        $this->_view->idCentroUnidad = $idCentroUnidad;
        $unicentro = $this->_post->getCentro_UnidadAcademica($idCentroUnidad);
        if(is_array($unicentro)){
            $this->_view->centro_unidadacademica = $unicentro;
        }else{
            $this->redireccionar("error/sql/" . $unicentro);
            exit;
        }
        
        $tipoparam = $this->_post->getTipoParametro();
        if(is_array($tipoparam)){
            $this->_view->tipoparametro = $tipoparam;
        }else{
            $this->redireccionar("error/sql/" . $tipoparam);
            exit;
        }
        
        $this->_view->titulo = 'Agregar Parametro - ' . APP_TITULO;
        
        $this->_view->setJs(array('agregarParametro'));
        $this->_view->setJs(array('jquery.validate'), "public");
        
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_CREARPARAMETRO);
         
        if($rolValido[0]["valido"]!= PERMISO_CREAR){
           echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionParametro/index/" . $idCentroUnidad . "';
                </script>";
        }
        
        if($iden == 1){
            $arrayPar["nombre"] = $this->getTexto('txtNombreParametro');
            $arrayPar["valor"] = $this->getTexto('txtValorParametro');
            $arrayPar["descripcion"] = $this->getTexto('txtDescripcionParametro');
            $arrayPar["centro_unidadacademica"] = $this->getInteger('slCentroUnidadAcademica');
            $arrayPar["carrera"] = $this->getInteger('slCarreras');
            $arrayPar["extension"] = $this->getTexto('txtExtensionParametro');         
            $arrayPar["tipoparametro"] =  $this->getInteger('slTipoParametro');
            
            $info = $this->_view->query = $this->_post->agregarParametro($arrayPar);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            
            $this->redireccionar('gestionParametro/index/'.$idCentroUnidad);
        }
        
        $this->_view->renderizar('agregarParametro', 'gestionParametro');
    }
    
    public function eliminarParametro($intNuevoEstado, $intIdParametro, $idCentroUnidad){
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_ELIMINARPARAMETRO);
        
        if($rolValido[0]["valido"]== PERMISO_ELIMINAR){
       
            if($intNuevoEstado == -1 || $intNuevoEstado == 1){
                $info = $this->_post->eliminarParametro($intIdParametro,$intNuevoEstado);
                if(!is_array($info)){
                    $this->redireccionar("error/sql/" . $info);
                    exit;
                }
                $this->redireccionar('gestionParametro/index/'.$idCentroUnidad);
            }else{
                $this->_view->cambio = "No reconocio ningun parametro";    
            }
        }
        else
        {         
            echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionParametro';
                </script>";
        }
    }
    
    public function actualizarParametro($intIdParametro = 0,$idCentroUnidad = 0) {
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_MODIFICARPARAMETRO);
         
        if($rolValido[0]["valido"]!= PERMISO_MODIFICAR){
           echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionParametro';
                </script>";
        }
        
        $valorPagina = $this->getInteger('hdEnvio');
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarParametro'));
        
        $this->_view->idCentroUnidad = $idCentroUnidad;        
        $unicentro = $this->_post->getCentro_UnidadAcademica($idCentroUnidad);
        
        if(is_array($unicentro)){
            $this->_view->centro_unidadacademica = $unicentro;
        }else{
            $this->redireccionar("error/sql/" . $unicentro);
            exit;
        }
        
        $tipoparam = $this->_post->getTipoParametro();
        if(is_array($tipoparam)){
            $this->_view->tipoparametro = $tipoparam;
        }else{
            $this->redireccionar("error/sql/" . $tipoparam);
            exit;
        }
        
        $arrayPar = array();
        $this->_view->id = $intIdParametro;
        
        $datosPar = $this->_post->datosParametro($intIdParametro);
        if(is_array($datosPar)){
            $this->_view->datosPar = $datosPar;
        }else{
            $this->redireccionar("error/sql/" . $datosPar);
            exit;
        }
        
        if ($valorPagina == 1) {
            $arrayPar["parametro"] = $intIdParametro;
            $arrayPar["nombre"] = $this->getTexto('txtNombreParametro');
            $arrayPar["valor"] = $this->getTexto('txtValorParametro');
            $arrayPar["descripcion"] = $this->getTexto('txtDescripcionParametro');
            $arrayPar["centro_unidadacademica"] = $this->getInteger('slCentroUnidadAcademica');
            $arrayPar["carrera"] = $this->getInteger('slCarreras');
            $arrayPar["extension"] = $this->getTexto('txtExtensionParametro');         
            $arrayPar["tipoparametro"] =  $this->getInteger('slTipoParametro');
            
            $info = $this->_post->actualizarParametro($arrayPar);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            
            $this->redireccionar('gestionParametro/actualizarParametro/' . $intIdParametro);
        }
        $this->_view->renderizar('actualizarParametro', 'gestionParametro');
    }
 
}
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
            $arrayCentro[":codigo"] = $this->getInteger('txtCodigo');
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
    
    public function actualizarCentro($idCentro = -1){
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_MODIFICARCURSO);
         
        if($rolValido[0]["valido"]!= PERMISO_MODIFICAR){
           echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionCurso';
                </script>";
        }
        
        if($idCentro == -1){
            $idCentro = 0;
        }
        
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarCentro'));
        
        $lsDeptos = $this->_ajax->getDeptos();
        if(is_array($lsDeptos)){
            $this->_view->lsDeptos = $lsDeptos;
        }else{
            $this->redireccionar('error/sql/' . $lsDeptos);
        }
        
        $datosCentro = $this->_gCenUni->getDatosCentro((int)$idCentro);
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
            $this->redireccionar('gestionCentroUnidad');
            exit;
        }
        $this->_view->renderizar('actualizarCentro', 'gestionCentroUnidad');
    }

    public function cargaCentroCSV(){
        $fileName = "";
        $fileExt = "";
        
        if($this->getInteger('hdFile')){
            $fileName=$_FILES['csvFile']['name'];
            $fileExt = explode(".",$fileName);
            if(strtolower(end($fileExt)) == "csv"){
                $fileName=$_FILES['csvFile']['tmp_name'];
                $handle = fopen($fileName, "r");
                while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
                    $arrayCentro = array();
                    $arrayCentro[":codigo"] = $data[0];
                    $arrayCentro[":nombre"] = $data[1];
                    $arrayCentro[":direccion"] = $data[3];
                    $arrayCentro[":municipio"] = $data[2];
                    $arrayCentro[":zona"] = $data[4];
                    
                    $info = $this->_gCenUni->setCentro($arrayCentro);
                    if(!is_array($info)){
                        fclose($handle);
                        $this->redireccionar("error/sql/" . $info);
                        exit;
                    }
                }
                fclose($handle);
                $this->redireccionar('gestionCentroUnidad');
                exit;
            }else{
                echo "<script>alert('El archivo cargado no cumple con el formato csv');</script>";
            }
        }
        $this->_view->renderizar('agregarCentro', 'gestionCentroUnidad'); 
    }
    
    public function listadoUnidades($idCentro = -1){
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONCURSO);
        
        if($rolValido[0]["valido"]!=PERMISO_GESTIONAR){        
            echo "<script>
                alert('No tiene permisos para acceder a esta función.');
                window.location.href='" . BASE_URL . "login/inicio';
                </script>";
        }
        
        if($idCentro == -1){
            $idCentro = 0;
        }
        
        $this->_view->titulo = 'Gestión de Centros Regionales - ' . APP_TITULO;
        $this->_view->id = $idCentro;
        
        $nombreCentro = $this->_gCenUni->getNombreCentro($idCentro);
        if(is_array($nombreCentro)){
            $this->_view->nombreCentro = $nombreCentro[0][0];
        }else{
            $this->redireccionar('error/sql/' . $nombreCentro);
        }
        
        $lstUnidades = $this->_gCenUni->getInfoUnidades($idCentro);
        if(is_array($lstUnidades)){
            $this->_view->lstUnidades = $lstUnidades;
        }else{
            $this->redireccionar("error/sql/" . $lstUnidades);
            exit;
        }

        $lsExistentes = $this->_gCenUni->getUnidadesPropias($idCentro);
        if(is_array($lsExistentes)){
            $this->_view->lsExistentes = $lsExistentes;
        }else{
            $this->redireccionar('error/sql/' . $lsExistentes);
        }
        
        $lsPropias = $this->_gCenUni->getUnidadesPropias($idCentro);
        if(is_array($lsPropias)){
            $this->_view->lsPropias = $lsPropias;
        }else{
            $this->redireccionar('error/sql/' . $lsPropias);
        }
        
        $this->_view->setJs(array('listadoUnidades'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));
        $this->_view->renderizar('listadoUnidades', 'gestionCentroUnidad');
    }
    
    public function agregarExistente(){
        $idCentro = $this->getInteger('hdCentro');
        $idUnidad = $this->getInteger('slExistentes');
        
        $info = $this->_gCenUni->setCentroUnidad($idCentro,$idUnidad);
        if(!is_array($info)){
            $this->redireccionar("error/sql/" . $info);
            exit;
        }
        $this->redireccionar('gestionCentroUnidad/listadoUnidades/' . $idCentro);
    }
    
    public function quitarExistente(){
        $idCentro = $this->getInteger('hdCentro');
        $idUnidad = $this->getInteger('slPropias');
        
        $info = $this->_gCenUni->removeCentroUnidad($idCentro,$idUnidad);
        if(!is_array($info)){
            $this->redireccionar("error/sql/" . $info);
            exit;
        }
        $this->redireccionar('gestionCentroUnidad/listadoUnidades/' . $idCentro);
    }
    
    public function agregarUnidad($idCentro = -1){
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_CREARCURSO);
        if($rolValido[0]["valido"]!= PERMISO_CREAR){
           echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionCurso';
                </script>";
        }
        
        if($idCentro == -1){
            $idCentro = 0;
        }
        
        $lsExistentes = $this->_gCenUni->getUnidadesPropias($idCentro);
        if(is_array($lsExistentes)){
            $this->_view->lsExistentes = $lsExistentes;
        }else{
            $this->redireccionar('error/sql/' . $lsExistentes);
        }
        
        $lsTipos = $this->_ajax->getTipoUnidadAcademica();
        if(is_array($lsTipos)){
            $this->_view->lsTipos = $lsTipos;
        }else{
            $this->redireccionar('error/sql/' . $lsTipos);
        }
        
        $this->_view->titulo = 'Agregar Unidad Acad&eacute;mica - ' . APP_TITULO;
        $this->_view->id = $idCentro;
        $this->_view->setJs(array('agregarUnidad'));
        $this->_view->setJs(array('jquery.validate'), "public");
        
        if($this->getInteger('hdEnvio')){
            $arrayUni = array();
            if($this->getInteger('slExistentes')){
                $arrayUni[":padre"] = $this->getInteger('slExistentes');
            }else{
                $arrayUni[":padre"] = "NULL";
            }
            
            $arrayUni[":id"] = $this->getInteger('txtCodigoUni');
            $arrayUni[":nombre"] = $this->getTexto('txtNombreUni');
            $arrayUni[":tipo"] = $this->getInteger('slTipos');
            
            $info = $this->_gCenUni->setUnidad($arrayUni);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }else{
                $tupla = $this->_gCenUni->setCentroUnidad($idCentro,$arrayUni[":id"]);
                if(!is_array($tupla)){
                    $this->redireccionar("error/sql/" . $tupla);
                    exit;
                }
            }
            $this->redireccionar('gestionCentroUnidad/listadoUnidades/'.$idCentro);
            exit;   
        }
        
        $this->_view->renderizar('agregarUnidad', 'gestionCentroUnidad');
    }
    
    public function estadoNuevo($estado, $centro, $unidad){
        if ($estado == -1 || $estado == 1) {
            $borrar = $this->_gCenUni->estadoNuevo($estado, $centro, $unidad);
            if(!is_array($borrar)){
                $this->redireccionar("error/sql/" . $borrar);
                exit;
            }
        }
        $this->redireccionar('gestionCentroUnidad/listadoUnidades/' . $centro);
    }
    
}
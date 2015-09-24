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

    public function index(){
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_GESTIONPARAMETRO);
         
        if($rolValido[0]["valido"]!= PERMISO_GESTIONAR){
           echo "<script>
                alert('No tiene permisos para acceder a esta función.');
                window.location.href='" . BASE_URL . "login/inicio';
                </script>";
        }
        
            
            $idCentroUnidad = $_SESSION["centrounidad"];

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
        $idCentroUnidad = $_SESSION["centrounidad"];
        
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
                window.location.href='" . BASE_URL . "gestionParametro" . "';
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
            
            $this->redireccionar('gestionParametro');
        }
        
        $this->_view->renderizar('agregarParametro', 'gestionParametro');
    }
    
    public function eliminarParametro($intNuevoEstado, $intIdParametro){
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
                $this->redireccionar('gestionParametro');
            }else{
                $this->_view->cambio = "No reconocio ningun parametro";    
            }
        }
        else
        {         
            echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionParametro" . "';
                </script>";
        }
    }
    
    public function actualizarParametro($intIdParametro = 0,$idCentroUnidad = 0) {
        session_start();
        $rol = $_SESSION["rol"];  
        $idCentroUnidad = $_SESSION["centrounidad"];
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_MODIFICARPARAMETRO);
         
        if($rolValido[0]["valido"]!= PERMISO_MODIFICAR){
           echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionParametro" . "';
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
            
            $this->redireccionar('gestionParametro/actualizarParametro/' . $intIdParametro );
        }
        $this->_view->renderizar('actualizarParametro', 'gestionParametro');
    }
    
    public function listadoPeriodo() {
        session_start();
        $rol = $_SESSION["rol"];  
        
        //TODO: Marlen: Funciones de períodos
//        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONSECCION);
//                    
//        if($rolValido[0]["valido"]!=PERMISO_GESTIONAR){      
//            echo "<script>
//                alert('No tiene permisos para acceder a esta función.');
//                window.location.href='" . BASE_URL . "gestionCurso';
//                </script>";
//        }
        
            
            $idCentroUnidad = $_SESSION["centrounidad"];
            
            $this->_view->id= $idCentroUnidad;

            $lstPeriodos = $this->_post->informacionPeriodoParametro($idCentroUnidad);
            if(is_array($lstPeriodos)){
                $this->_view->lstPer = $lstPeriodos;
            }else{
                $this->redireccionar("error/sql/" . $lstPeriodos);
                exit;
            }

            $this->_view->titulo = 'Gestión de períodos - ' . APP_TITULO;
            $this->_view->setJs(array('gestionPeriodo'));
            $this->_view->setJs(array('jquery.dataTables.min'), "public");
            $this->_view->setCSS(array('jquery.dataTables.min'));
            $this->_view->renderizar('gestionPeriodo');
        
    }
    
    public function eliminarPeriodo($intNuevoEstado, $intIdPeriodo) {
        session_start();
        $rol = $_SESSION["rol"]; 
        //TODO: Marlen: Funciones de períodos
//        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_ELIMINARSECCION);
//        
//        if($rolValido[0]["valido"]== PERMISO_ELIMINAR){
       
            if ($intNuevoEstado == -1 || $intNuevoEstado == 1) {
                $info = $this->_post->eliminarPeriodoParametro($intIdPeriodo, $intNuevoEstado);
                if(!is_array($info)){
                    $this->redireccionar("error/sql/" . $info);
                    exit;
                }
                $this->redireccionar('gestionParametro/listadoPeriodo');
            } else {
                echo "Error al desactivar período";
            }
//        }
//        else
//        {         
//            echo "<script>
//                alert('No tiene permisos suficientes para acceder a esta función.');
//                window.location.href='" . BASE_URL . "gestionCurso/listadoSeccion" . "';
//                </script>";
//        }
        
    }
    
    public function agregarPeriodo() {
        
        
        session_start();
        $rol = $_SESSION["rol"];
        //TODO: Marlen: Funciones de períodos
//        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_CREARSECCION);
//         
//        if($rolValido[0]["valido"]!= PERMISO_CREAR){
//           echo "<script>
//                alert('No tiene permisos suficientes para acceder a esta función.');
//                window.location.href='" . BASE_URL . "gestionCurso/listadoSeccion';
//                </script>";
//        }
        
        $idCentroUnidad = $_SESSION["centrounidad"];
        
        if ($this->getInteger('hdEnvio')) {
            $idCiclo = $this->getInteger('slCiclo');
            $tipoPeriodo = $this->getInteger('slTiposPeriodo');
            $tipoAsign = $this->getInteger('slTiposAsign');
            $fechaInicial = $this->getTexto('txtFechaInicial');
            $fechaFinal = $this->getTexto('txtFechaFinal');

            $array['ciclo'] = $idCiclo;
            $array['tipoperiodo'] = $tipoPeriodo;
            $array['tipoasign'] = $tipoAsign;
            $array['fechainicial'] = $fechaInicial;
            $array['fechafinal'] = $fechaFinal;
            $array['centrounidad'] = $idCentroUnidad;
            
            $info = $this->_post->agregarPeriodoParametro($array);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            
            $this->redireccionar('gestionParametro/listadoPeriodo');
        }
        
        $tiposPeriodo = $this->_post->getTiposPeriodo();
        if(is_array($tiposPeriodo)){
            $this->_view->tiposPeriodo = $tiposPeriodo;
        }else{
            $this->redireccionar("error/sql/" . $tiposPeriodo);
            exit;
        }
        
        $tiposAsign = $this->_post->getTiposAsign();
        if(is_array($tiposAsign)){
            $this->_view->tiposAsign = $tiposAsign;
        }else{
            $this->redireccionar("error/sql/" . $tiposAsign);
            exit;
        }
        
        $tipociclo = 1;//TODO: Marlen: consultar parámetro en base de datos
        $lsAnios = $this->_ajax->getAniosAjax($tipociclo);
        if(is_array($lsAnios)){
            $this->_view->lstAnios = $lsAnios;
        }else{
            $this->redireccionar("error/sql/" . $lsAnios);
            exit;
        }
        
        $this->_view->titulo = 'Agregar Período - ' . APP_TITULO;
        $this->_view->id = $idCentroUnidad;
        $this->_view->setJs(array('agregarPeriodo'));
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('jquery-ui'), "public");
        $this->_view->setCss(array('jquery-ui'), "public");
        $this->_view->renderizar('agregarPeriodo');    
    }
    
    public function actualizarPeriodo($idPeriodo = 0) {
        session_start();
        $rol = $_SESSION["rol"];      
        //TODO: Marlen: Funciones de períodos
//        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_MODIFICARSECCION);
//        if($rolValido[0]["valido"]!= PERMISO_MODIFICAR){
//           echo "<script>
//                alert('No tiene permisos suficientes para acceder a esta función.');
//                window.location.href='" . BASE_URL . "gestionCurso/listadoSeccion" . "';
//                </script>";
//        }
        $idCentroUnidad = $_SESSION["centrounidad"];
        
        $array = array();
        if ($this->getInteger('hdEnvio')) {
            $idCiclo = $this->getInteger('slCiclo');
            $tipoPeriodo = $this->getInteger('slTiposPeriodo');
            $tipoAsign = $this->getInteger('slTiposAsign');
            $fechaInicial = $this->getTexto('txtFechaInicial');
            $fechaFinal = $this->getTexto('txtFechaFinal');

            $array['ciclo'] = $idCiclo;
            $array['tipoperiodo'] = $tipoPeriodo;
            $array['tipoasign'] = $tipoAsign;
            $array['fechainicial'] = $fechaInicial;
            $array['fechafinal'] = $fechaFinal;
            $array['id'] = $idPeriodo;

            $respuesta = $this->_post->actualizarPeriodoParametro($array);
            if (is_array($respuesta)){
                $this->redireccionar('gestionParametro/listadoPeriodo');
            }else{
                $this->redireccionar("error/sql/" . $respuesta);
                exit;
            }
        }
        $tipociclo = 1;//TODO: Marlen: consultar parámetro en base de datos
        
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('jquery-ui'), "public");
        $this->_view->setCss(array('jquery-ui'), "public");
        $this->_view->setJs(array('actualizarPeriodo'));
        
        $this->_view->id = $idPeriodo;
        
        
        $this->_view->titulo = 'Actualizar Período - ' . APP_TITULO;
        
        $lsAnios = $this->_ajax->getAniosAjax($tipociclo);
        if(is_array($lsAnios)){
            $this->_view->lstAnios = $lsAnios;
        }else{
            $this->redireccionar("error/sql/" . $lsAnios);
            exit;
        }
        
        $info = $this->_post->datosPeriodoParametro($idPeriodo);
        if(is_array($info)){
            $this->_view->datosSec = $info;
        }else{
            $this->redireccionar("error/sql/" . $info);
            exit;
        }
        
        $lsCiclos = $this->_ajax->getCiclosAjax($tipociclo, (isset($info[0]['anio']) ? $info[0]['anio'] : -1));
        if(is_array($lsCiclos)){
            $this->_view->lstCiclos = $lsCiclos;
        }else{
            $this->redireccionar("error/sql/" . $lsCiclos);
            exit;
        }
        
        $tiposPeriodo = $this->_post->getTiposPeriodo();
        if(is_array($tiposPeriodo)){
            $this->_view->tiposPeriodo = $tiposPeriodo;
        }else{
            $this->redireccionar("error/sql/" . $tiposPeriodo);
            exit;
        }
        
        $tiposAsign = $this->_post->getTiposAsign();
        if(is_array($tiposAsign)){
            $this->_view->tiposAsign = $tiposAsign;
        }else{
            $this->redireccionar("error/sql/" . $tiposAsign);
            exit;
        }
        
        
        $this->_view->renderizar('actualizarPeriodo');
    }
}
<?php

/**
 * Description of gestionPensumController
 *
 * @author amoino   
 */
class gestionEdificioController extends Controller {

    private $_post;
    private $_encriptar;
    private $_ajax;

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
        $this->_post = $this->loadModel('gestionEdificio');
        $this->_ajax = $this->loadModel("ajax");
    }
    
    public function listadoEdificio() {
        $rol = $_SESSION["rol"];        
        $rolValidoGestion = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_GESTIONEDIFICIO);
        $rolValidoAgregar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_CREAREDIFICIO);
        $rolValidoModificar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_MODIFICAREDIFICIO);
        $rolValidoEliminar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_ELIMINAREDIFICIO);
        $this->_view->permisoGestion = $rolValidoGestion[0]["valido"];
        $this->_view->permisoAgregar = $rolValidoAgregar[0]["valido"];
        $this->_view->permisoModificar = $rolValidoModificar[0]["valido"];
        $this->_view->permisoEliminar = $rolValidoEliminar[0]["valido"];
        $rolValidoGestionSalones = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONSALON);
        $this->_view->permisoGestionSalones = $rolValidoGestionSalones[0]["valido"];
        $rolValidoGestionAsigacionEdificio= $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_GESTIONASIGNACIONEDIFICIO);
        $this->_view->permisoGestionAsignacion = $rolValidoGestionAsigacionEdificio[0]["valido"];
        
        if($this->_view->permisoGestion!=PERMISO_GESTIONAR){        
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "login/inicio';
                </script>";
        }
        
        $info = $this->_post->allEdificios();
        if(is_array($info)){
            $this->_view->lstEdif = $info;
        }else{
            $this->redireccionar("error/sql/" . $info);
            exit;
        }
        
        $this->_view->titulo = 'Gestión de Edificios - ' . APP_TITULO;
        $this->_view->setJs(array('listadoEdificios'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('listadoEdificios');
        
    }
    
    public function index($id=0){
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValidoGestion= $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_GESTIONASIGNACIONEDIFICIO);
        $rolValidoAgregar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_CREARASIGNACIONEDIFICIO);
        $rolValidoModificar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_MODIFICARASIGNACIONEDIFICIO);
        $rolValidoEliminar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_ELIMINARASIGNACIONEDIFICIO);
        $this->_view->permisoGestion = $rolValidoGestion[0]["valido"];
        $this->_view->permisoAgregar = $rolValidoAgregar[0]["valido"];
        $this->_view->permisoModificar = $rolValidoModificar[0]["valido"];
        $this->_view->permisoEliminar = $rolValidoEliminar[0]["valido"];
        
         if($this->_view->permisoGestion != PERMISO_GESTIONAR){        
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionEdificio/listadoEdificio';
                </script>";
        }
        
        if($this->getInteger('hdEdificio')){
            $idEdificio = $this->getInteger('hdEdificio');
        }else{
            $idEdificio = $id;
        }
        $this->_view->id = $idEdificio;

        $info = $this->_post->informacionAsignacionEdificio($idEdificio);
        if(is_array($info)){
            $this->_view->lstEdificio = $info;                
        }else{
            $this->redireccionar("error/sql/" . $info);
            exit;
        }

        $this->_view->titulo = 'Gestión de Edificios - ' . APP_TITULO;
        $this->_view->setJs(array('gestionEdificio'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('gestionEdificio');
        
    }

    public function actualizarAsignacion($intIdAsignacion = 0, $intIdEdificio = 0) {
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_MODIFICARASIGNACIONEDIFICIO);
       
        if($rolValido[0]["valido"]!= PERMISO_MODIFICAR){
           echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionEdificio/gestionEdificio/" . $intIdEdificio . "';
                </script>";
        }
        
        $valorPagina = $this->getInteger('hdEnvio');
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarAsignacion'));
        $this->_view->setCSS(array('jquery.dataTables.min'));
        
        $arrayAsig = array();
        $this->_view->id = $intIdAsignacion;
        $this->_view->idEdificio = $intIdEdificio;
        
        $datosAsig = $this->_post->datosAsignacionEdificio($intIdAsignacion);
        if(is_array($datosAsig)){
            $this->_view->datosAsig = $datosAsig;
        }else{
            $this->redireccionar("error/sql/" . $datosAsig);
            exit;
        }
        
        $unicentro = $this->_post->getCentro_UnidadAcademica(0);
        if(is_array($unicentro)){
            $this->_view->centro_unidadacademica = $unicentro;
        }else{
            $this->redireccionar("error/sql/" . $unicentro);
            exit;
        }
        
        $lsJornadas = $this->_view->jornadas = $this->_ajax->getJornada();
        if(is_array($lsJornadas)){
            $this->_view->jornadas = $lsJornadas;
        }else{
            $this->redireccionar("error/sql/" . $lsJornadas);
            exit;
        }
        
        if ($valorPagina == 1) {
            $arrayAsig["centro_unidadacademica"] = $this->getInteger('slCentroUnidadAcademica');
            $arrayAsig["edificio"] = $intIdEdificio;  
            $arrayAsig["jornada"] = $this->getInteger('slJornadas');         
            $arrayAsig["centrounidad_edificio"] = $intIdAsignacion;
            
            $info = $this->_post->actualizarAsignacionEdificio($arrayAsig);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            
            $this->redireccionar('gestionEdificio/actualizarAsignacion/' . $intIdAsignacion . '/' . $intIdEdificio);
       
        }
        $this->_view->renderizar('actualizarAsignacion', 'gestionEdificio');
    }
    
     public function actualizarEdificio($intIdEdificio = 0) {

        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_MODIFICAREDIFICIO);
       
        if($rolValido[0]["valido"]!= PERMISO_MODIFICAR){
           echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionEdificio/listadoEdificio/" . $intIdEdificio . "';
                </script>";
        }
        
        $valorPagina = $this->getInteger('hdEnvio');
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarEdificio'));
        $this->_view->setCSS(array('jquery.dataTables.min'));
        
        $arrayEdif = array();
        $this->_view->id = $intIdEdificio;
        
        $datosEdif = $this->_post->consultaEdificio($intIdEdificio);
        if(is_array($datosEdif)){
            $this->_view->datosEdif = $datosEdif;
        }else{
            $this->redireccionar("error/sql/" . $datosEdif);
            exit;
        }
        
        if ($valorPagina == 1) {
            $arrayEdif["edificio"] = $intIdEdificio;  
            $arrayEdif["nombre"] = $this->getTexto('txtNombre');         
            $arrayEdif["descripcion"] = $this->getTexto('txtDescripcion');         
            
            $info = $this->_post->actualizarEdificio($arrayEdif);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
             
            $this->redireccionar('gestionEdificio/actualizarEdificio/' . $intIdEdificio);
       
        }
        $this->_view->renderizar('actualizarEdificio', 'gestionEdificio');
    }

    public function agregarEdificio() {
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_CREAREDIFICIO);
         
        if($rolValido[0]["valido"]!= PERMISO_CREAR){
           echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionEdificio/listadoEdificio/" . "';
                </script>";
        }
        
        $this->_view->titulo = 'Agregar Edificio - ' . APP_TITULO;
        $this->_view->setJs(array('agregarEdificio'));
        $this->_view->setJs(array('jquery.validate'), "public");
        $arrayCar = array();

        if ($this->getInteger('hdEnvio')) {
            $nombreEdificio = $this->getTexto('txtNombre');
            $nombreDescripcion = $this->getTexto('txtDescripcion');

            $arrayCar['nombre'] = $nombreEdificio;
            $arrayCar['descripcion'] = $nombreDescripcion;
            $arrayCar['estado'] = ESTADO_PENDIENTE;
            $this->_post->agregarEdificio($arrayCar);
            $this->redireccionar('gestionEdificio/listadoEdificio');
        }

        $this->_view->renderizar('agregarEdificio', 'gestionEdificio');
    }
    
     public function activarDesactivarEdificio($intNuevoEstado, $intIdEdificio) {
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_ELIMINAREDIFICIO);
        
        if($rolValido[0]["valido"]== PERMISO_ELIMINAR){
            if ($intNuevoEstado == ESTADO_INACTIVO || $intNuevoEstado == ESTADO_ACTIVO) {
                $info = $this->_post->activarDesactivarEdificio($intIdEdificio, $intNuevoEstado);

                if(!is_array($info)){
                    $this->redireccionar("error/sql/" . $info);
                    exit;
                }
                $this->redireccionar('gestionEdificio/listadoEdificio');
            } else {
                echo "Error al desactivar el edificio";
            }
        }
        else
        {
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionEdificio/listadoEdificio" . "';
                </script>";
        }
        
    }

    public function asignacionEdificio($intIdEdificio = 0) {
        
        $this->_view->id = $intIdEdificio;
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_CREARASIGNACIONEDIFICIO);
         
        if($rolValido[0]["valido"]!= PERMISO_CREAR){
           echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionEdificio/gestionEdificio/" . $intIdEdificio . "';
                </script>";
        }

        $lsCentros = $this->_view->centros = $this->_ajax->getDatosCentroUnidad();
        if(is_array($lsCentros)){
            $this->_view->centros = $lsCentros;
        }else{
            $this->redireccionar("error/sql/" . $lsCentros);
            exit;
        }
        
        $lsJornadas = $this->_view->jornadas = $this->_ajax->getJornada();
        if(is_array($lsJornadas)){
            $this->_view->jornadas = $lsJornadas;
        }else{
            $this->redireccionar("error/sql/" . $lsJornadas);
            exit;
        }
        
        $this->_view->titulo = 'Asignacion de Edificio - ' . APP_TITULO;
        $this->_view->setJs(array('asignacionEdificio'));
        $this->_view->setJs(array('jquery.validate'), "public");
        $arrayAsignacion = array();
        
        if ($this->getInteger('hdEnvio')) {
            $centroUnidadAcademica = $this->getInteger('slCentros');
            $jornada = $this->getInteger('slJornadas');

            $arrayAsignacion['centroUnidadAcademica'] = $centroUnidadAcademica;
            $arrayAsignacion['edificio'] = $intIdEdificio;
            $arrayAsignacion['jornada'] = $jornada;
            $arrayAsignacion['estado'] = ESTADO_PENDIENTE;
            $this->_post->asignarUnidadEdificio($arrayAsignacion);
            $this->redireccionar('gestionEdificio/gestionEdificio/'. $intIdEdificio);
        }

        $this->_view->renderizar('asignacionEdificio', 'gestionEdificio');
    }
    
     public function eliminarAsignacionEdificio($intNuevoEstado, $intIdAsignacion, $idEdificio){

        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_ELIMINARASIGNACIONEDIFICIO);
        
        if($rolValido[0]["valido"]== PERMISO_ELIMINAR){
       
            if($intNuevoEstado == ESTADO_INACTIVO || $intNuevoEstado == ESTADO_ACTIVO){
                $info = $this->_post->eliminarAsignacion($intIdAsignacion,$intNuevoEstado);
                if(!is_array($info)){
                    $this->redireccionar("error/sql/" . $info);
                    exit;
                }
                $this->redireccionar('gestionEdificio/gestionEdificio/' . $idEdificio);
            }else{
                $this->_view->cambio = "No reconocio ningun parametro";    
            }
        }
        else
        {
             echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionEdificio/gestionEdificio/" . $idEdificio . "';
                </script>";
        }
        }
        
        
        //Región de salones
        public function gestionSalon($intIdEdificio = 0) {
        $rol = $_SESSION["rol"];        
        $rolValidoGestion = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONSALON);
        $rolValidoAgregar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_CREARSALON);
        $rolValidoModificar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_MODIFICARSALON);
        $rolValidoEliminar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_ELIMINARSALON);
        $this->_view->permisoGestion = $rolValidoGestion[0]["valido"];
        $this->_view->permisoAgregar = $rolValidoAgregar[0]["valido"];
        $this->_view->permisoModificar = $rolValidoModificar[0]["valido"];
        $this->_view->permisoEliminar = $rolValidoEliminar[0]["valido"];
        
        if($rolValidoGestion[0]["valido"]!=PERMISO_GESTIONAR){        
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionEdificio/listadoEdificio';
                </script>";
        }
        
        $this->_view->id = $intIdEdificio;
        $info = $this->_post->listadoSalones($intIdEdificio,ESTADO_ACTIVO);
        if(is_array($info)){
            $this->_view->lstSalones= $info;
        }else{
            $this->redireccionar("error/sql/" . $info);
            exit;
        }
        
        $this->_view->titulo = 'Gestión de Salones - ' . APP_TITULO;
        $this->_view->setJs(array('gestionSalon'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('gestionSalon');
        
    }
    
    public function eliminarSalon($intNuevoEstado, $intIdSalon, $intIdEdificio){

        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_ELIMINARSALON);
        if($rolValido[0]["valido"]== PERMISO_ELIMINAR){
            
            if($intNuevoEstado == ESTADO_INACTIVO || $intNuevoEstado == ESTADO_ACTIVO){
                $info = $this->_post->eliminarSalon($intIdSalon,$intNuevoEstado);
                if(!is_array($info)){
                    $this->redireccionar("error/sql/" . $info);
                    exit;
                }
                $this->redireccionar('gestionEdificio/gestionSalon/' . $intIdEdificio);
            }else{
                $this->_view->cambio = "No reconocio ningun parametro";    
            }
        }
        else
        {         
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionEdificio/gestionSalon/" . $intIdEdificio . "';
                </script>";
        }
    }
    
    public function agregarSalon($intIdEdificio = 0){
                
        
        $arraySal = array();
        
        $this->_view->idEdificio = $intIdEdificio;
       
        $this->_view->titulo = 'Agregar Salón - ' . APP_TITULO;
        $this->_view->setJs(array('agregarSalon'));
        $this->_view->setJs(array('jquery.validate'), "public");
        
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_CREARSALON);
        $iden = $this->getInteger('hdEnvio');
       
        if($rolValido[0]["valido"]!= PERMISO_CREAR){
           echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionEdificio/gestionSalon/" . $intIdEdificio . "';
                </script>";
        }
        
        if($iden == 1){
            $arraySal["nombre"] = $this->getTexto('txtNombre');
            $arraySal["edificio"] = $intIdEdificio;
            $arraySal["nivel"] = $this->getInteger('txtNivel');
            $arraySal["capacidad"] = $this->getInteger('txtCapacidad');
           
            $info = $this->_view->query = $this->_post->agregarSalon($arraySal);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            
            $this->redireccionar('gestionEdificio/gestionSalon/'.$intIdEdificio);
        }
        
        $this->_view->renderizar('agregarSalon', 'gestionSalon');
    }
    
    
    public function actualizarSalon($intIdSalon = 0,$intIdEdificio = 0) {

        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_MODIFICARSALON);
       
        if($rolValido[0]["valido"]!= PERMISO_MODIFICAR){
           echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionEdificio/gestionSalon/" . $intIdEdificio . "';
                </script>";
        }
        
        $valorPagina = $this->getInteger('hdEnvio');
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarSalon'));
        $this->_view->setCSS(array('jquery.dataTables.min'));
        
        $arraySal = array();
        $this->_view->id = $intIdSalon;
        $this->_view->idEdificio = $intIdEdificio;
        
        $datosSal = $this->_post->consultaSalon($intIdSalon);
        if(is_array($datosSal)){
            $this->_view->datosSal = $datosSal;
        }else{
            $this->redireccionar("error/sql/" . $datosSal);
            exit;
        }
        
        if ($valorPagina == 1) {
          $arraySal["salon"] = $intIdSalon;
          $arraySal["nombre"] = $this->getTexto('txtNombre');
            $arraySal["nivel"] = $this->getInteger('txtNivel');         
            $arraySal["capacidad"] = $this->getInteger('txtCapacidad');         
            
            $info = $this->_post->actualizarSalon($arraySal);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
             
            $this->redireccionar('gestionEdificio/actualizarSalon/' . $intIdSalon .'/' . $intIdEdificio);
        
        }
        $this->_view->renderizar('actualizarSalon', 'gestionSalon');
    }
}
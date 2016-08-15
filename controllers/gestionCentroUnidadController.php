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
        $this->getLibrary('session');
        $this->_session = new session();
        if(!$this->_session->validarSesion()){
            $this->redireccionar('login/salir');
            exit;
        }
        $this->_ajax = $this->loadModel("ajax");
        $this->_gCenUni = $this->loadModel('gestionCentroUnidad');
    }

    public function index() {
        $rol = $_SESSION["rol"];        
        $rolValidoGestion = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_GESTIONCENTROUNIDAD);
        $rolValidoAgregar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_CREARCENTROUNIDAD);
        $rolValidoModificar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_MODIFICARCENTROUNIDAD);
        $rolValidoEliminar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_ELIMINARCENTROUNIDAD);
        $rolValidoGestionUnidades = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_GESTIONUNIDAD);
        $this->_view->permisoGestion = $rolValidoGestion[0]["valido"];
        $this->_view->permisoAgregar = $rolValidoAgregar[0]["valido"];
        $this->_view->permisoModificar = $rolValidoModificar[0]["valido"];
        $this->_view->permisoEliminar = $rolValidoEliminar[0]["valido"];
        $this->_view->permisoGestionUnidad = $rolValidoGestionUnidades[0]["valido"];
        
        if($this->_view->permisoGestion!=PERMISO_GESTIONAR){        
            echo "<script>
                ".MSG_SINPERMISOS."
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
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_CREARCENTROUNIDAD);
         
        if($rolValido[0]["valido"]!= PERMISO_CREAR){
           echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionCentroUnidad';
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
            $this->insertarBitacoraUsuario(CONS_FUNC_ADM_CREARCENTROUNIDAD, "Agregado centro universitario ".$this->getTexto('txtNombreCen')." al sistema");
            $this->redireccionar('gestionCentroUnidad');
            exit;
        }
        
        $this->_view->renderizar('agregarCentro', 'gestionCentroUnidad');
    }
    
    public function actualizarCentro($idCentro = -1){
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_MODIFICARCENTROUNIDAD);
         
        if($rolValido[0]["valido"]!= PERMISO_MODIFICAR){
           echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionCentroUnidad';
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
            $this->insertarBitacoraUsuario(CONS_FUNC_ADM_MODIFICARCENTROUNIDAD, "Se actualizó el centro universitario ".$this->getTexto('txtNombreCen'));
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
        $rol = $_SESSION["rol"];        
        $rolValidoGestion = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_GESTIONUNIDAD);
        $rolValidoAgregar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_CREARUNIDAD);
        $rolValidoModificar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_MODIFICARUNIDAD);
        $rolValidoEliminar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_ELIMINARUNIDAD);
        $rolValidoGestionCarrera = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONCARRERA);
        $this->_view->permisoGestion = $rolValidoGestion[0]["valido"];
        $this->_view->permisoAgregar = $rolValidoAgregar[0]["valido"];
        $this->_view->permisoModificar = $rolValidoModificar[0]["valido"];
        $this->_view->permisoEliminar = $rolValidoEliminar[0]["valido"];
        $this->_view->permisoGestionCarreras = $rolValidoGestionCarrera[0]["valido"];
        
        if($this->_view->permisoGestion!=PERMISO_GESTIONAR){        
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionCentroUnidad';
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
        $this->insertarBitacoraUsuario(CONS_FUNC_ADM_CONSULTACENTROUNIDAD, "Consulta listado de unidades académicas");
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
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_CREARUNIDAD);
        if($rolValido[0]["valido"]!= PERMISO_CREAR){
           echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionCentroUnidad/listadoUnidades/".$idCentro."';
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
            $this->insertarBitacoraUsuario(CONS_FUNC_ADM_CREARCENTROUNIDAD, "Agregada unidad académica al sistema ".$this->getTexto('txtNombreUni'));
            $this->redireccionar('gestionCentroUnidad/listadoUnidades/'.$idCentro);
            exit;   
        }
        
        $this->_view->renderizar('agregarUnidad', 'gestionCentroUnidad');
    }
    
    public function estadoNuevo($estado, $centro, $unidad){
         $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_ELIMINARUNIDAD);
        
        if($rolValido[0]["valido"]== PERMISO_ELIMINAR){
            if ($estado == -1 || $estado == 1) {
                $borrar = $this->_gCenUni->estadoNuevo($estado, $centro, $unidad);
                if(!is_array($borrar)){
                    $this->redireccionar("error/sql/" . $borrar);
                    exit;
                }
            }
            //$this->insertarBitacoraUsuario(CONS_FUNC_ADM_ELIMINAREXTENSION, "Extension ".$ext." eliminada ");
            $this->redireccionar('gestionCentroUnidad/listadoUnidades/' . $centro);
            exit;
            }
        else
        {         
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionCentroUnidad/listadoUnidades/" . $centro . "';
                </script>";
        }
    }
    
    public function listadoExtensiones($centroUnidad = -1) {
        if($centroUnidad <= 0){
            $idCentroUnidad = $_SESSION["centrounidad"];
        }else{
            $idCentroUnidad = $centroUnidad;
            $this->_view->vieneDeUnidad = true;
        }
        
        $rol = $_SESSION["rol"];
        $rolValidoGestion = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_GESTIONEXTENSION);
        $rolValidoAgregar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_CREAREXTENSION);
        $rolValidoModificar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_MODIFICAREXTENSION);
        $rolValidoEliminar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_ELIMINAREXTENSION);
        $this->_view->permisoGestion = $rolValidoGestion[0]["valido"];
        $this->_view->permisoAgregar = $rolValidoAgregar[0]["valido"];
        $this->_view->permisoModificar = $rolValidoModificar[0]["valido"];
        $this->_view->permisoEliminar = $rolValidoEliminar[0]["valido"];

        if ($this->_view->permisoGestion != PERMISO_GESTIONAR) {
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionCentroUnidad/listadoUnidades/".$idCentroUnidad."';
                </script>";
        }        

        $this->_view->id = $idCentroUnidad;

        $info = $this->_gCenUni->getExtensionesCentroUnidad($idCentroUnidad);
        $info = json_decode($info[0][0], true);
        if (is_array($info) || $info == '') {            
            $this->_view->lstExt = $info;
        } else {
            $this->redireccionar("error/sql/" . $info);
            exit;
        }

        $this->_view->titulo = 'Gestión de extensiones - ' . APP_TITULO;
        $this->_view->setJs(array('gestionExtension'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));
        $this->insertarBitacoraUsuario(CONS_FUNC_ADM_CONSULTAEXTENSION, "Consulta listado de extensiones");
        $this->_view->renderizar('gestionExtension');
    }
    
    public function agregarExtension($centroUnidad = -1) {

        if($centroUnidad <= 0){
            $idCentroUnidad = $_SESSION["centrounidad"];
        }else{
            $idCentroUnidad = $centroUnidad;
            $this->_view->vieneDeUnidad = true;
        }
        
        $rol = $_SESSION["rol"];
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_ADM_CREAREXTENSION);

        if ($rolValido[0]["valido"] != PERMISO_CREAR) {
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionCentroUnidad/listadoExtensiones/" . $idCentroUnidad . "';
                </script>";
        }

        $this->_view->idCentroUnidad = $idCentroUnidad;

        $this->_view->titulo = 'Agregar Extensión - ' . APP_TITULO;
        $this->_view->setJs(array('agregarExtension'));
        $this->_view->setJs(array('jquery.validate'), "public");

        if ($this->getInteger('hdEnvio')) {
            
            $codigoExtension = $this->getTexto('txtCodigo');
            $nombreExtension = $this->getTexto('txtNombre');
            
            $info = $this->_gCenUni->getExtensionesCentroUnidad($idCentroUnidad);
            $info = json_decode($info[0][0], true);
            if (is_array($info)) {     
                $arrayExt['id'] = $codigoExtension;
                $arrayExt['nombre'] = $nombreExtension;
                $arrayExt['estado'] = ESTADO_PENDIENTE;
                array_push($info, $arrayExt);
                $info = json_encode($info);
            } 
            else if($info == ''){
                $arrayExt[0]['id'] = $codigoExtension;
                $arrayExt[0]['nombre'] = $nombreExtension;
                $arrayExt[0]['estado'] = ESTADO_PENDIENTE;
                $info = json_encode($arrayExt);
            }
            else {
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            
            $ext = $this->_gCenUni->actualizarExtensiones($idCentroUnidad, $info);
            if (!is_array($ext)) {
                $this->redireccionar("error/sql/" . $ext);
                exit;
            }
            $this->insertarBitacoraUsuario(CONS_FUNC_ADM_CREAREXTENSION, "Nueva extensión ".$nombreExtension." creada");
            $this->redireccionar('gestionCentroUnidad/listadoExtensiones/'.$idCentroUnidad);
            exit;
        }
        $this->_view->renderizar('agregarExtension', 'gestionCentroUnidad');
    }
    
    public function actualizarExtension($strIdExt, $centroUnidad = -1) {
        if($centroUnidad <= 0){
            $idCentroUnidad = $_SESSION["centrounidad"];
        }else{
            $idCentroUnidad = $centroUnidad;
            $this->_view->vieneDeUnidad = true;
        }
        
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarExtension'));

        $arrayCar = array();
        
        $this->_view->idCU = $idCentroUnidad;
        $this->_view->id = $strIdExt;

        $rol = $_SESSION["rol"];
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol, CONS_FUNC_ADM_MODIFICAREXTENSION);

        //TODO: permisos
        if ($rolValido[0]["valido"] != PERMISO_MODIFICAR) {
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionCentroUnidad/listadoExtensiones/" .$centroUnidad. "';
                </script>";
        }
        
        $ext = $this->_gCenUni->getExtensionesCentroUnidad($idCentroUnidad);
        $ext = json_decode($ext[0][0], true);
        if (is_array($ext) || $ext == '') {            
            $this->_view->lstExtensiones = $ext;
            $key = array_search($strIdExt, array_column($ext, 'id'));
            $this->_view->datosExt = $ext[$key];
        } else {
            $this->redireccionar("error/sql/" . $ext);
            exit;
        }

//        $info = $this->_post->datosCarrera($intIdCarrera);
//        if (is_array($info)) {
//            $this->_view->datosCar = $info;
//        } else {
//            $this->redireccionar("error/sql/" . $info);
//            exit;
//        }
        
        if ($this->getInteger('hdEnvio')) {
            $nombreExt = $this->getTexto('txtNombre');
            $ext[$key]['nombre'] = $nombreExt;
            $info = json_encode($ext);
            $extension = $this->_gCenUni->actualizarExtensiones($idCentroUnidad, $info);
            if (!is_array($extension)) {
                $this->redireccionar("error/sql/" . $extension);
                exit;
            }
            $this->insertarBitacoraUsuario(CONS_FUNC_ADM_MODIFICAREXTENSION, "Extensión ".$nombreExt." modificada ");
            $this->redireccionar('gestionCentroUnidad/listadoExtensiones/'.$idCentroUnidad);
            exit;
        }
        
        $this->_view->titulo = 'Actualizar Extensión - ' . APP_TITULO;
        $this->_view->renderizar('actualizarExtension', 'gestionCentroUnidad');
        
    }
    
    public function eliminarExtension($estado, $strIdExt, $centroUnidad = -1){
        if($centroUnidad <= 0){
            $idCentroUnidad = $_SESSION["centrounidad"];
        }else{
            $idCentroUnidad = $centroUnidad;
            $this->_view->vieneDeUnidad = true;
        }
        $rol = $_SESSION["rol"];  
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_ADM_ELIMINAREXTENSION);
        
        if($rolValido[0]["valido"]== PERMISO_ELIMINAR){
            if ($estado == -1 || $estado == 1) {
                $ext = $this->_gCenUni->getExtensionesCentroUnidad($idCentroUnidad);
                $ext = json_decode($ext[0][0], true);
                if (is_array($ext) || $ext == '') {            
                    $this->_view->lstExtensiones = $ext;
                    $key = array_search($strIdExt, array_column($ext, 'id'));
                    $this->_view->datosExt = $ext[$key];
                } else {
                    $this->redireccionar("error/sql/" . $ext);
                    exit;
                }
                $ext[$key]['estado'] = $estado;
                $info = json_encode($ext);
                $extension = $this->_gCenUni->actualizarExtensiones($idCentroUnidad, $info);
                if (!is_array($extension)) {
                    $this->redireccionar("error/sql/" . $extension);
                    exit;
                }                
            }
            $this->insertarBitacoraUsuario(CONS_FUNC_ADM_ELIMINAREXTENSION, "Extensión ".$ext." cambiada a estado ".$estado);
            $this->redireccionar('gestionCentroUnidad/listadoExtensiones/' . $idCentroUnidad);
            }
        else
        {         
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "gestionCentroUnidad/listadoExtensiones/" . $idCentroUnidad . "';
                </script>";
        }
    }
}
if(!function_exists("array_column")){

    function array_column($array,$column_name){

        return array_map(function($element) use($column_name){return $element[$column_name];}, $array);

    }

}
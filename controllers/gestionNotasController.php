<?php

/**
 * Description of gestionNotas
 *
 * @author Rickardo
 */
class gestionNotasController extends Controller{
    private $_ajax;
    private $_notas;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('session');
        $this->_session = new session();
        if(!$this->_session->validarSesion()){
            $this->redireccionar('login/salir');
            exit;
        }
        $this->_ajax = $this->loadModel('ajax');
        $this->_notas = $this->loadModel('gestionNotas');
    }
    
    public function index($id = 0){
        $rol = $_SESSION["rol"];        
        $rolValidoGestion = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONNOTA);
        $rolValidoModificar = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_MODIFICARNOTA);
        $this->_view->permisoGestion = $rolValidoGestion[0]["valido"];
        $this->_view->permisoModificar = $rolValidoModificar[0]["valido"];
        
        if($this->_view->permisoGestion!= PERMISO_GESTIONAR){
            echo "<script>
                ".MSG_SINPERMISOS."
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

        $this->_view->id = $idCentroUnidad;

        $lsCat = $this->_notas->getDocentesActivos($idCentroUnidad);
        if(is_array($lsCat)){
            $this->_view->lstCat = $lsCat;
        }else{
            $this->redireccionar("error/sql/" . $lsCat);
            exit;
        }

        $infoCentroUnidad = $this->_ajax->spGetNombreCentroUnidad($idCentroUnidad);
        if(is_array($infoCentroUnidad)){
            $this->_view->infoCentroUnidad = $infoCentroUnidad;
        }else{
            $this->redireccionar("error/sql/" . $infoCentroUnidad);
            exit;
        }
        
        $this->_view->setJs(array('gestionNotas'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));
        $this->_view->titulo = 'Gestión de notas - ' . APP_TITULO;
        $this->_view->id = $idCentroUnidad;
        $this->_view->renderizar('gestionNotas');
       
    }
    
    public function cursosXDocente($idUsuario, $UnidadCentro, $Tipo = 0){
        $this->_view->id = $UnidadCentro;
        $this->_view->idUsuario = $idUsuario;
        $this->_view->tipo = $Tipo;
        
        $datosCat = $this->_notas->getDocenteEspecifico($idUsuario);
        if(is_array($datosCat)){
            $this->_view->datosCat = $datosCat;
        }else{
            $this->redireccionar('error/sql/' . $datosCat);
            exit;
        }
        
        $lsTipoCiclo = $this->_ajax->getTipoCiclo();
        if(is_array($lsTipoCiclo)){
            $this->_view->lsTipoCiclo = $lsTipoCiclo;
        }else{
            $this->redireccionar('error/sql/' . $lsTipoCiclo);
            exit;
        }
        
        $this->_view->titulo = 'Gestión de notas - ' . APP_TITULO;
        $this->_view->setJs(array('cursosXDocente'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setJs(array('jquery.csv'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));
        $this->_view->renderizar('cursosXDocente','gestionNotas');
    }
    
    public function actividades($idUsuario, $UnidadCentro){
        $this->_view->id = $UnidadCentro;
        $this->_view->idUsuario = $idUsuario;
        
        $datosCat = $this->_notas->getDocenteEspecifico($idUsuario);
        if(is_array($datosCat)){
            $this->_view->datosCat = $datosCat;
        }else{
            $this->redireccionar('error/sql/' . $datosCat);
            exit;
        }
        
        $lsTipoCiclo = $this->_ajax->getTipoCiclo();
        if(is_array($lsTipoCiclo)){
            $this->_view->lsTipoCiclo = $lsTipoCiclo;
        }else{
            $this->redireccionar('error/sql/' . $lsTipoCiclo);
            exit;
        }
        
        $lsTipoActividad = $this->_notas->getTipoActividad();
        if(is_array($lsTipoActividad)){
            $this->_view->lsTipoActividad = $lsTipoActividad;
        }else{
            $this->redireccionar('error/sql/' . $lsTipoActividad);
            exit;
        }
        
        $this->_view->titulo = 'Gestión de notas - ' . APP_TITULO;
        $this->_view->setJs(array('jquery.validate'),"public");
        $this->_view->setJs(array('jquery.confirm'),"public");
        $this->_view->setJs(array('actividades'));
        $this->_view->renderizar('actividades');
        
    }
    
    public function guardarNota(){
        $respuesta = new stdClass();
        $respuesta->mensaje = "";
        $zona = floatval($this->getTexto('zonaN'));
        $final = floatval($this->getTexto('finalN'));
        if($this->getInteger('idAs')){
            $this->_notas->guardarNota($zona,$final,$this->getInteger('idAs'));
            $respuesta->total = $zona + $final;
            $respuesta->mensaje = "Procesado: Las notas seran guardadas con valores enteros";
        }else{
            $respuesta->mensaje = "Ocurrio un error al ingresar una nota";
        }
        echo json_encode($respuesta);
    }
    
    public function notasCSV(){
        $respuesta = new stdClass();
        $respuesta->mensaje = "";
        $respuesta->info = array();
        $fileName=$_FILES['csvFile']['name'];
        $fileExt = explode(".",$fileName);
        if(strtolower(end($fileExt)) == "csv"){
            $fileName=$_FILES['csvFile']['tmp_name'];
            $handle = fopen($fileName, "r");
            $i = 0;
            while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
                $carnet = trim($data[0]);
                $zona = trim($data[1]);
                $final = trim($data[2]);
                $respuesta->info[$i]['carnet'] = $carnet;
                $respuesta->info[$i]['zona'] =  $zona;
                $respuesta->info[$i]['final'] = $final;
                $i=$i+1;
            }
            fclose($handle);
            $respuesta->mensaje = "Todos los registros han sido cargados, verifique que la informacion sea la correcta y guarde los cambios";
        }else{
            $respuesta->mensaje = "La información no se pudo leer debido a que solo se admiten archivos .csv";
        }
        echo json_encode($respuesta);
    }
    
    public function getEstadoCicloActividades(){
        if($this->getInteger('cicloaver')){
            echo json_encode($this->_notas->estadoCicloActividades($this->getInteger('cicloaver')));
        }
    }
    
    public function guardarActividad(){
        $respuesta = new stdClass();
        $respuesta->mensaje = "";
        
        $idPadre = $this->getInteger('idPadre');
        $idTipo = $this->getInteger('idTipo');
        $txtNombre = $this->getTexto('txtNombre');
        $valor = floatval($this->getTexto('flValor'));
        $desc = $this->getTexto('txtDesc');
        
        if($idPadre > 0 && $idTipo > 0 && $valor > 0){
            $act = $this->_notas->guardarActividad($idPadre,$idTipo,$txtNombre,$valor,$desc);
            if(is_array($act)){
                $respuesta->mensaje = "Procesado: Actividad " . $txtNombre . " guardadas exitosamente";
            }else{
                $respuesta->mensaje = "error creando: " . $txtNombre;
            }
        }else{
            $respuesta->mensaje = "Ocurrio un error al ingresar una nota";
        }
        echo json_encode($respuesta);
    }
    
}

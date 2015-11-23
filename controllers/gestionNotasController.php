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
        $rolValidoGestionActividades = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONACTIVIDADES);
        $this->_view->permisoGestion = $rolValidoGestion[0]["valido"];        
        $this->_view->permisoGestionActividades = $rolValidoGestionActividades[0]["valido"];
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
        
        $tipociclo = $_SESSION["tipociclo"];
        $lsAnios = $this->_ajax->getAniosAjax($tipociclo);
        if(is_array($lsAnios)){
            $this->_view->lstAnios = $lsAnios;
        }else{
            $this->redireccionar("error/sql/" . $lsAnios);
            exit;
        }
        
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
        
        //if(!isset($_SESSION["carrera"])){
            //$_SESSION["carrera"]=1;
        //}
        $notaAprobado = $this->_ajax->valorParametro(CONS_PARAM_UNIDAD_NOTAPROMOCION, -1, $_SESSION["centrounidad"]);
        $this->_view->notaAprobado = $notaAprobado[0]['valorparametro'];
        
        $zonaMaxima = $this->_ajax->valorParametro(CONS_PARAM_UNIDAD_NOTATOTALZONA, -1, $_SESSION["centrounidad"]);
        $this->_view->zonaTotal = $zonaMaxima[0]['valorparametro'];
        
        $notaFinalMaxima = $this->_ajax->valorParametro(CONS_PARAM_UNIDAD_NOTAEXAMENFINAL, -1, $_SESSION["centrounidad"]);
        $this->_view->finalTotal = $notaFinalMaxima[0]['valorparametro'];
        
        $this->_view->titulo = 'Gestión de notas - ' . APP_TITULO;
        $this->_view->setJs(array('cursosXDocente'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setJs(array('jquery.csv'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));
        $this->_view->renderizar('cursosXDocente','gestionNotas');
    }
    
    public function getEstadoCicloNotas(){
        $datos = new stdClass();
        $datos->estado = 0;
        if($this->getInteger('cicloaver')){
            $arr = $this->_notas->getEstadoCicloNotas($this->getInteger('cicloaver'),PERIODO_INGRESO_NOTAS,$this->getInteger('tipoAs'),$this->getInteger('centrounidad'));
            if(is_array($arr)){
                if(isset($arr[0]['periodo'])){
                    $datos->estado = 1;
                }else{
                    $datos->estado = -3;
                }
            }else{
                $datos->estado = -2;
            }
        }
        echo json_encode($datos);
    }
    
    public function actividades($idUsuario, $UnidadCentro){
        $rol = $_SESSION["rol"];        
        $rolValidoGestion = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONACTIVIDADES);
        $this->_view->permisoGestion = $rolValidoGestion[0]["valido"];
        
        if($this->_view->permisoGestion!= PERMISO_GESTIONAR){
            echo "<script>
                ".MSG_SINPERMISOS."
                window.location.href='" . BASE_URL . "login/inicio';
                </script>";
        }
        
        $this->_view->id = $UnidadCentro;
        $this->_view->idUsuario = $idUsuario;
        
        $tipociclo = $_SESSION["tipociclo"];
        $lsAnios = $this->_ajax->getAniosAjax($tipociclo);
        if(is_array($lsAnios)){
            $this->_view->lstAnios = $lsAnios;
        }else{
            $this->redireccionar("error/sql/" . $lsAnios);
            exit;
        }
        
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
        
        //if(!isset($_SESSION["carrera"])){
            //$_SESSION["carrera"]=1;
        //}
        
        $zonaMaxima = $this->_ajax->valorParametro(CONS_PARAM_UNIDAD_NOTATOTALZONA, -1, $_SESSION["centrounidad"]);
        $this->_view->zonaTotal = $zonaMaxima[0]['valorparametro'];
        
        $notaFinalMaxima = $this->_ajax->valorParametro(CONS_PARAM_UNIDAD_NOTAEXAMENFINAL, -1, $_SESSION["centrounidad"]);
        $this->_view->finalTotal = $notaFinalMaxima[0]['valorparametro'];
        
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
            $nota=$this->_notas->guardarNota($zona,$final,$this->getInteger('idAs'));
            if(is_array($nota)){
                $respuesta->total = $zona + $final;
                $respuesta->mensaje = "Procesado: Las notas seran guardadas con valores enteros";
            }else{
                $respuesta->mensaje = "Ocurrio un error inesperado, notifique a control academico";
            }
        }else{
            $respuesta->mensaje = "Ocurrio un error al ingresar una nota";
        }
        echo json_encode($respuesta);
    }
    
    public function guardarRetrasada(){
        $respuesta = new stdClass();
        $respuesta->mensaje = "";
        $zona = floatval($this->getTexto('zonaN'));
        $final = floatval($this->getTexto('finalN'));
        if($this->getInteger('idAs')){
            $nota=$this->_notas->guardarRetra($final,$this->getInteger('idAs'));
            if(is_array($nota)){
                $respuesta->total = $zona + $final;
                $respuesta->mensaje = "Procesado: Las notas seran guardadas con valores enteros";
            }else{
                $respuesta->mensaje = "Ocurrio un error inesperado, notifique a control academico";
            }
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
        $respuesta->id = 0;
        
        $idPadre = $this->getInteger('idPadre');
        $idTipo = $this->getInteger('idTipo');
        $txtNombre = $this->getTexto('txtNombre');
        $valor = floatval($this->getTexto('flValor'));
        $desc = $this->getTexto('txtDesc');
        
        if($idPadre > 0 && $idTipo > 0 && $valor > 0){
            $act = $this->_notas->guardarActividad($idPadre,$idTipo,$txtNombre,$valor,$desc);
            if(is_array($act)){
                $respuesta->mensaje = "Procesado: Actividad " . $txtNombre . " guardadas exitosamente";
                $respuesta->id = $act[0][0];
            }else{
                $respuesta->mensaje = "error creando: " . $txtNombre;
            }
        }else{
            $respuesta->mensaje = "Ocurrio un error al ingresar una nota";
        }
        echo json_encode($respuesta);
    }
    
    public function setActividadAsignado(){
        if($this->getInteger('asignado') && $this->getInteger('actividad')){
            $this->_notas->asociarActividad($this->getInteger('asignado'),$this->getInteger('actividad'));
        }
    }
    
    public function contarActividades(){
        $respuesta = new stdClass();
        $respuesta->total = 0;
        if($this->getInteger('trama')){
            $act = $this->_notas->contarActividades($this->getInteger('trama'));
            $respuesta->total = $act[0][0];
        }else{
            $respuesta->total = -2;
        }
        echo json_encode($respuesta);
    }
    
    public function aprobarNota(){
        $respuesta = new stdClass();
        $respuesta->aprobado = 0;
        if($this->getInteger('idAs')){
            $this->_notas->aprobarNota($this->getInteger('idAs'));
            $respuesta->aprobado = 1;
        }
        echo json_encode($respuesta);
    }
    
    public function reprobarNOta(){
        $respuesta = new stdClass();
        $respuesta->reprobado = 0;
        if($this->getInteger('idAs')){
            $this->_notas->reprobarNota($this->getInteger('idAs'));
            $respuesta->reprobado = 1;
        }
        echo json_encode($respuesta);
    }
    
    public function listarActividades(){
        if($this->getInteger('asig')){
            $respuesta = $this->_notas->listarActividades($this->getInteger('asig'));
            echo json_encode($respuesta);
        }
    }
    
    public function getListaAsignados(){
        if($this->getInteger('trama') && $this->getInteger('ciclo')){
            echo json_encode($this->_notas->getListaAsignados($this->getInteger('trama'),$this->getInteger('ciclo')));
        }
    }
    
    public function getListaAsignadosRetra(){
        if($this->getInteger('trama') && $this->getInteger('ciclo') && $this->getInteger('retra')){
            echo json_encode($this->_notas->getListaAsignadosRetra($this->getInteger('trama'),$this->getInteger('ciclo'),$this->getInteger('retra')));
        }
    }
}

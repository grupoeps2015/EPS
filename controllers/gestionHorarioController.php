<?php

/**
 * Description of gestionHorarioController
 *
 * @author Arias
 */
class gestionHorarioController extends Controller {
    private $_post;
    private $_ajax;
    private $_encriptar;
    
    public function __construct() {
        parent::__construct();
        $this->getLibrary('encripted');
        $this->_encriptar = new encripted();
        $this->_post = $this->loadModel('gestionHorario');
        $this->_postSeccion = $this->loadModel('gestionSeccion');
        $this->_postCatedratico = $this->loadModel('catedratico');
        $this->_ajax = $this->loadModel("ajax");
    }

    public function index($parametros = null) {
                
            if(!is_null($parametros)){
                list($idCentroUnidad, $idCiclo, $idSeccion) = split('[$.-]', (string)$parametros);
            }else{
                if($this->getInteger('hdCentroUnidad')){
                    $idCentroUnidad = $this->getInteger('hdCentroUnidad');
                }else if($_SESSION["rol"] != ROL_ADMINISTRADOR){
                    $idCentroUnidad = $_SESSION["centrounidad"];
                }else{
                    $this->redireccionar("general/seleccionarCentroUnidad/gestionHorario/seleccionarCicloCurso");
                    exit;
                }
                $idCiclo = $this->getInteger('slCiclo');
                $idSeccion = $this->getInteger('slSec');
            }

            $this->_view->idciclo = $idCiclo;
            $this->_view->idcurso = $idSeccion;
            $this->_view->id = $idCentroUnidad;

            //nombreSeccion
            $seccionNombre = $this->_postSeccion->datosSeccion($idSeccion);
            if(is_array($seccionNombre)){
                if(isset($seccionNombre[0]['nombre'])){
                   $this->_view->curso = $seccionNombre[0]['nombre']." - ".$seccionNombre[0]['tiposeccionnombre']." - ".$seccionNombre[0]['cursonombre']; 
                }
            }else{
                $this->redireccionar("error/sql/" . $seccionNombre);
                exit;
            }  

            $lsHor = $this->_post->informacionHorario($idCiclo,$idSeccion);
            if(is_array($lsHor)){
                $this->_view->lstHor = $lsHor;
            }else{
                $this->redireccionar("error/sql/" . $lsHor);
                exit;
            }
            $lstParametros = $idCentroUnidad . '$' . $idCiclo . '$' . $idSeccion;

            $this->_view->parametros = $lstParametros;
            $this->_view->titulo = 'Gestión de horarios - ' . APP_TITULO;
            $this->_view->setJs(array('gestionHorario'));
            $this->_view->setJs(array('jquery.dataTables.min'), "public");
            $this->_view->setCSS(array('jquery.dataTables.min'));

            $this->_view->renderizar('gestionHorario');
        
    }
    
    public function seleccionarCicloCurso($id = 0){
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_GESTIONHORARIO);
                    
        if($rolValido[0]["valido"]!=PERMISO_GESTIONAR){      
            echo "<script>
                alert('No tiene permisos para acceder a esta función.');
                window.location.href='" . BASE_URL . "login/inicio';
                </script>";        
        }
        
        //session_start();
        if($this->getInteger('hdCentroUnidad')){
            $idCentroUnidad = $this->getInteger('hdCentroUnidad');
        }else if ($id != 0){
            $idCentroUnidad = $id;
        }else if($_SESSION["rol"] != ROL_ADMINISTRADOR){
            $idCentroUnidad = $_SESSION["centrounidad"];
        }else{
            $this->redireccionar("general/seleccionarCentroUnidad/gestionHorario/seleccionarCicloCurso");
            exit;
        }
        $this->_view->id = $idCentroUnidad;
        
        $lsTipos = $this->_ajax->getTipoCiclo();
        if(is_array($lsTipos)){
            $this->_view->lstTipos = $lsTipos;
        }else{
            $this->redireccionar("error/sql/" . $lsTipos);
            exit;
        }
        
        $lsSec = $this->_postSeccion->informacionSeccion(CENTRO_UNIDADACADEMICA);
        if(is_array($lsSec)){
            $this->_view->lstSec = $lsSec;
        }else{
            $this->redireccionar("error/sql/" . $lsSec);
            exit;
        }
        
        $this->_view->titulo = 'Seleccionar Ciclo y Sección por Curso - ' . APP_TITULO;
        $this->_view->url = "";
        $this->_view->setJs(array('seleccionarCicloCurso'));
        $this->_view->renderizar('seleccionarCicloCurso');
    }

    public function agregarHorario() {
        session_start();
        
        
        if($this->getInteger('hdCentroUnidad')){
            $idCentroUnidad = $this->getInteger('hdCentroUnidad');
        }else if($_SESSION["rol"] != ROL_ADMINISTRADOR){
            $idCentroUnidad = $_SESSION["centrounidad"];
        }else{
            $this->redireccionar("general/seleccionarCentroUnidad/gestionHorario/seleccionarCicloCurso");
            exit;
        }
        $idSeccion = $this->getInteger('slSec');
        $idCiclo = $this->getInteger('slCiclo');
        $lstParametros = $idCentroUnidad . '$' . $idCiclo . '$' . $idSeccion;
        
        //Validación de permisos
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_CREARHORARIO);
         
        if($rolValido[0]["valido"]!= PERMISO_CREAR){
           echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionHorario/index/" . $lstParametros . "';
                </script>";
        }
        
        $this->_view->parametros = $lstParametros;
        $this->_view->id = $idCentroUnidad;
        $this->_view->idciclo = $idCiclo;
        $this->_view->idcurso = $idSeccion;
        
        $seccionNombre = $this->_postSeccion->datosSeccion($idSeccion);
        if(is_array($seccionNombre)){
            if(isset($seccionNombre[0]['nombre'])){
                $this->_view->curso = $seccionNombre[0]['nombre']." - ".$seccionNombre[0]['tiposeccionnombre']." - ".$seccionNombre[0]['cursonombre'];
            }
        }else{
            $this->redireccionar("error/sql/" . $seccionNombre);
            exit;
        } 
        
        $jornadas = $this->_post->getJornadas();
        if(is_array($jornadas)){
            $this->_view->jornadas = $jornadas;
        }else{
            $this->redireccionar("error/sql/" . $jornadas);
            exit;
        }
        
        $tiposPeriodo = $this->_post->getTiposPeriodo();
        if(is_array($tiposPeriodo)){
            $this->_view->tiposPeriodo = $tiposPeriodo;
        }else{
            $this->redireccionar("error/sql/" . $tiposPeriodo);
            exit;
        }
        
        $catedraticos = $this->_postCatedratico->getCatedraticos($idCentroUnidad);
        if(is_array($catedraticos)){
            $this->_view->catedraticos = $catedraticos;
        }else{
            $this->redireccionar("error/sql/" . $catedraticos);
            exit;
        }
        
        $dias = $this->_post->getDias();
        if(is_array($dias)){
            $this->_view->dias = $dias;
        }else{
            $this->redireccionar("error/sql/" . $dias);
            exit;
        }
        
        $edificios = $this->_post->informacionEdificio($idCentroUnidad);
        if(is_array($edificios)){
            $this->_view->edificios = $edificios;
        }else{
            $this->redireccionar("error/sql/" . $edificios);
            exit;
        }
        
        
        $this->_view->titulo = 'Agregar Horario - ' . APP_TITULO;
        $this->_view->setJs(array('agregarHorario'));
        $this->_view->setJs(array('jquery.validate'), "public");
        
        if ($this->getInteger('hdEnvio')) {
            $catedratico = $this->getInteger('slCatedraticos');
            $dia = $this->getInteger('slDias');
            $periodo = $this->getInteger('slPeriodos');
            $jornada = $this->getInteger('slJornadas');
            $inicio = $this->getTexto('txtHoraInicial').":".$this->getTexto('txtMinutoInicial');
            $fin = $this->getTexto('txtHoraFinal').":".$this->getTexto('txtMinutoFinal');
            $Sec = $this->_postSeccion->datosSeccion($idSeccion);
            if(!is_array($Sec)){
                $this->redireccionar("error/sql/" . $Sec);
                exit;
            }
            
            //Llena o cunsulta la tabla CUR_Curso_Catedratico
            $cursocatedratico =  $this->_post->agregarCursoCatedratico($catedratico, $Sec[0]['curso']);
            if(!is_array($cursocatedratico)){
                $this->redireccionar("error/sql/" . $cursocatedratico);
                exit;
            }
            
            //Llena la tabla CUR_Trama
            $arrayTra['cursocatedratico'] = $cursocatedratico[0][0];
            $arrayTra['dia'] = $dia;
            $arrayTra['periodo'] = $periodo;
            $arrayTra['inicio'] = $inicio;
            $arrayTra['fin'] = $fin;
            $arrayTra['seccion'] = $idSeccion;
            $trama =  $this->_post->agregarTrama($arrayTra);
            if(!is_array($trama)){
                $this->redireccionar("error/sql/" . $trama);
                exit;
            }
            
            //Llena la tabla CUR_Horario
            $arrayHor['jornada'] = $jornada;
            $arrayHor['trama'] = $trama[0][0];
            $arrayHor['ciclo'] = $idCiclo;
            $arrayHor['estado'] = ESTADO_ACTIVO;
            $horario =  $this->_post->agregarHorario($arrayHor);
            if(!is_array($horario)){
                $this->redireccionar("error/sql/" . $horario);
                exit;
            }
            
            //Llena la tabla CUR_Horario_Salon
            $horariosalon = $this->_post->agregarHorarioSalon($horario[0][0],$this->getInteger('slSalones'));
            if(!is_array($horariosalon)){
                $this->redireccionar("error/sql/" . $horariosalon);
                exit;
            }
            
            $this->redireccionar("gestionHorario/index/" . $lstParametros);
        }
        
        $this->_view->renderizar('agregarHorario', 'gestionHorario');    
    }
    
    public function eliminarHorario($intNuevoEstado, $intIdHorario, $parametros) {
         session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_ELIMINARHORARIO);
        
        if($rolValido[0]["valido"]== PERMISO_ELIMINAR){
       
            if ($intNuevoEstado == -1 || $intNuevoEstado == 1) {
                $info = $this->_post->eliminarHorario($intIdHorario, $intNuevoEstado);
                if(!is_array($info)){
                    $this->redireccionar("error/sql/" . $info);
                    exit;
                }
                $this->redireccionar("gestionHorario/index/{$parametros}");
            } else {
                echo "Error al desactivar horario";
            }
        }
        else
        {         
            echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionHorario/index/" . $parametros . "';
                </script>";
        }
    }
    
    public function actualizarHorario($intIdHorario, $parametros) {
        session_start();
        $rol = $_SESSION["rol"];        
        $rolValido = $this->_ajax->getPermisosRolFuncion($rol,CONS_FUNC_CUR_MODIFICARHORARIO);
         
        if($rolValido[0]["valido"]!= PERMISO_MODIFICAR){
           echo "<script>
                alert('No tiene permisos suficientes para acceder a esta función.');
                window.location.href='" . BASE_URL . "gestionHorario/index/" . $parametros . "';
                </script>";
        }
        
        if(!is_null($parametros)){
            list($idCentroUnidad, $idCiclo, $idSeccion) = split('[$.-]', (string)$parametros);
        }
        
        $hor = $this->_post->datosHorario($intIdHorario);
        if(is_array($hor)){
            $this->_view->datosHor = $hor;
        }else{
            $this->redireccionar("error/sql/" . $hor);
            exit;
        }
        
        $periodos = $this->_ajax->getPeriodosAjax((isset($hor[0]['tipoperiodo']) ? $hor[0]['tipoperiodo'] : 0));
        if(is_array($periodos)){
            $this->_view->periodos = $periodos;
        }else{
            $this->redireccionar("error/sql/" . $periodos);
            exit;
        }
        
        $salones = $this->_ajax->getSalonesAjax((isset($hor[0]['edificio']) ? $hor[0]['edificio'] : 0));
        if(is_array($salones)){
            $this->_view->salones = $salones;
        }else{
            $this->redireccionar("error/sql/" . $salones);
            exit;
        }
        
        $seccionNombre = $this->_postSeccion->datosSeccion($idSeccion);
        if(is_array($seccionNombre)){
            if(isset($seccionNombre[0]['nombre'])){
                $this->_view->curso = $seccionNombre[0]['nombre']." - ".$seccionNombre[0]['tiposeccionnombre']." - ".$seccionNombre[0]['cursonombre'];
            }
        }else{
            $this->redireccionar("error/sql/" . $seccionNombre);
            exit;
        } 
        
        $jornadas = $this->_post->getJornadas();
        if(is_array($jornadas)){
            $this->_view->jornadas = $jornadas;
        }else{
            $this->redireccionar("error/sql/" . $jornadas);
            exit;
        }
        
        $tiposPeriodo = $this->_post->getTiposPeriodo();
        if(is_array($tiposPeriodo)){
            $this->_view->tiposPeriodo = $tiposPeriodo;
        }else{
            $this->redireccionar("error/sql/" . $tiposPeriodo);
            exit;
        }
        
        $catedraticos = $this->_postCatedratico->getCatedraticos($idCentroUnidad);
        if(is_array($catedraticos)){
            $this->_view->catedraticos = $catedraticos;
        }else{
            $this->redireccionar("error/sql/" . $catedraticos);
            exit;
        }
        
        $dias = $this->_post->getDias();
        if(is_array($dias)){
            $this->_view->dias = $dias;
        }else{
            $this->redireccionar("error/sql/" . $dias);
            exit;
        }
        
        $edificios = $this->_post->informacionEdificio($idCentroUnidad);
        if(is_array($edificios)){
            $this->_view->edificios = $edificios;
        }else{
            $this->redireccionar("error/sql/" . $edificios);
            exit;
        }
        
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarHorario'));
        
        $arrayHor = array();
        $actualizar = false;
        $this->_view->id = $intIdHorario;
        $this->_view->parametros = $parametros;
        
        
        $this->_view->titulo = 'Actualizar Horario - ' . APP_TITULO;
        
        if ($this->getInteger('hdEnvio')) {
            $catedratico = $this->getInteger('slCatedraticos');
            $dia = $this->getInteger('slDias');
            $periodo = $this->getInteger('slPeriodos');
            $jornada = $this->getInteger('slJornadas');
            $inicio = $this->getTexto('txtHoraInicial').":".$this->getTexto('txtMinutoInicial');
            $fin = $this->getTexto('txtHoraFinal').":".$this->getTexto('txtMinutoFinal');
            $Sec = $this->_postSeccion->datosSeccion($idSeccion);
            if(!is_array($Sec)){
                $this->redireccionar("error/sql/" . $Sec);
                exit;
            }
            
            //Llena o cunsulta la tabla CUR_Curso_Catedratico
            $cursocatedratico =  $this->_post->agregarCursoCatedratico($catedratico, $Sec[0]['curso']);
            if(!is_array($cursocatedratico)){
                $this->redireccionar("error/sql/" . $cursocatedratico);
                exit;
            }
            
            //Llena la tabla CUR_Trama
            $arrayTra['cursocatedratico'] = $cursocatedratico[0][0];
            $arrayTra['dia'] = $dia;
            $arrayTra['periodo'] = $periodo;
            $arrayTra['inicio'] = $inicio;
            $arrayTra['fin'] = $fin;
            $arrayTra['id'] = $hor[0]['trama'];
            $trama =  $this->_post->actualizarTrama($arrayTra);
            if(!is_array($trama)){
                $this->redireccionar("error/sql/" . $trama);
                exit;
            }
            
            //Llena la tabla CUR_Horario
            $arrayHor['jornada'] = $jornada;
            $arrayHor['horario'] = $intIdHorario;
            $horario =  $this->_post->actualizarHorario($arrayHor);
            if(!is_array($horario)){
                $this->redireccionar("error/sql/" . $horario);
                exit;
            }
            
            //Llena la tabla CUR_Horario_Salon
            $horariosalon = $this->_post->agregarHorarioSalon($horario[0][0],$this->getInteger('slSalones'));
            if(!is_array($horariosalon)){
                $this->redireccionar("error/sql/" . $horariosalon);
                exit;
            }
            
            $this->redireccionar("gestionHorario/index/" . $parametros);
        }
        //print_r($hor);
        $this->_view->renderizar('actualizarHorario', 'gestionHorario');  
    }
    
    public function cargarCSV(){
//        $iden = $this->getInteger('hdFile');
//        $fileName = "";
//        $fileExt = "";
//        $rol = "";
//        
//        if($iden == 1){
//            $fileName=$_FILES['csvFile']['name'];
//            $fileExt = explode(".",$fileName);
//            if(strtolower(end($fileExt)) == "csv"){
//                $fileName=$_FILES['csvFile']['tmp_name'];
//                $handle = fopen($fileName, "r");
//                while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
//                    $arrayCur = array();
//                    $arrayCur['tipocurso'] = $data[2];
//                    $arrayCur['codigo'] = $data[0];
//                    $arrayCur['nombre'] = $data[1];
//                    $arrayCur['traslape'] = $data[3];
//                    $arrayCur['estado'] = $data[4];
//                    $this->_post->agregarCurso($arrayCur);
//    
//                }
//                fclose($handle);
//                $this->redireccionar('gestionCurso');
//            }else{
//                echo "<script>alert('El archivo cargado no cumple con el formato csv');</script>";
//            }
//        }
//        $this->redireccionar('gestionCurso/agregarCurso');
        
    }
}
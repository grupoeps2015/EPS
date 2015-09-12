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
            $idCiclo = $this->getInteger('slCiclo');
            $idSeccion = $this->getInteger('slSec');
            if($this->getInteger('hdCentroUnidad')){
                $idCentroUnidad = $this->getInteger('hdCentroUnidad');
            }else{
                session_start();
                $idCentroUnidad = $_SESSION["centrounidad"];
            }
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
        $this->_view->titulo = 'Gestión de horarios - ' . APP_TITULO;
        $this->_view->setJs(array('gestionHorario'));
        $this->_view->setJs(array('jquery.dataTables.min'), "public");
        $this->_view->setCSS(array('jquery.dataTables.min'));

        $this->_view->renderizar('gestionHorario');
    }
    
    public function seleccionarCicloCurso($id = 0){
        if($this->getInteger('hdCentroUnidad')){
            $idCentroUnidad = $this->getInteger('hdCentroUnidad');
        }else if ($id != 0){
            $idCentroUnidad = $id;
        }else{
            $idCentroUnidad = $_SESSION["centrounidad"];
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
        $idSeccion = $this->getInteger('slSec');
        $idCiclo = $this->getInteger('slCiclo');
        $idCentroUnidad = $this->getInteger('hdCentroUnidad');
        $lstParametros = $idCentroUnidad . '$' . $idCiclo . '$' . $idSeccion;
        
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
        $arrayCar = array();
        
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
    
    public function eliminarHorario($intNuevoEstado, $intIdHorario) {
        if ($intNuevoEstado == -1 || $intNuevoEstado == 1) {
            $info = $this->_post->eliminarHorario($intIdHorario, $intNuevoEstado);
            if(!is_array($info)){
                $this->redireccionar("error/sql/" . $info);
                exit;
            }
            $this->redireccionar('gestionHorario');
        } else {
            echo "Error al desactivar carrera";
        }
    }
    
    public function actualizarCarrera($intIdCarrera = 0) {
        $this->_view->setJs(array('jquery.validate'), "public");
        $this->_view->setJs(array('actualizarCarrera'));
        
        $arrayCar = array();
        $actualizar = false;
        $this->_view->id = $intIdCarrera;
        
        $carr = $this->_post->datosCarrera($intIdCarrera);
        if(is_array($carr)){
            $this->_view->datosCar = $carr;
        }else{
            $this->redireccionar("error/sql/" . $carr);
            exit;
        }
        
        $this->_view->titulo = 'Actualizar Carrera - ' . APP_TITULO;
        
        if ($this->getInteger('hdEnvio')) {
            $nombreCarrera = $this->getTexto('txtNombre');

            $arrayCar['id'] = $intIdCarrera;
            $arrayCar['nombre'] = $nombreCarrera;
            $respuesta = $this->_post->actualizarCarrera($arrayCar);
            if (is_array($respuesta)){
                $this->redireccionar('gestionPensum/listadoCarrera');
            }else{
                $this->redireccionar("error/sql/" . $respuesta);
                exit;
            }
        }
        $this->_view->renderizar('actualizarCarrera', 'gestionPensum');
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
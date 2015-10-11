<?php

/**
 * Description of gestionPensumModel
 *
 * @author Arias
 */
class gestionPensumModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function agregarCarrera($_datos) {
        $info = $this->_db->prepare("SELECT * from spAgregarCarrera(:nombre,:estado,:centrounidadacademica) as Id;");
        $info->execute($_datos);
        if ($info === false) {
            return "1101/agregarCarrera";
        } else {
            return $info->fetchall();
        }
    }
    
    public function asignarAreaCarrera($_datos){
        $info = $this->_db->prepare("SELECT * from spagregarcarreraarea(:carrera,:area,:estado) as Id;");
        $info->execute($_datos);

        if ($info === false) {
            return "1101/agregarCarreraArea";
        } else {
            return $info->fetchall();
        }        
    }

    public function informacionCarrera($centrounidadacademica) {
        $info = $this->_db->query("select * from spInformacionCarrera(" . $centrounidadacademica . ");");
        if ($info === false) {
            return "1104/informacionCarrera";
        } else {
            return $info->fetchall();
        }
    }

    public function eliminarCarrera($intIdCarrera, $intEstadoNuevo) {
        $info = $this->_db->query("SELECT * from spActivarDesactivarCarrera(" . $intIdCarrera . "," . $intEstadoNuevo . ");");
        if ($info === false) {
            return "1103/eliminarCarrera";
        } else {
            return $info->fetchall();
        }
    }
    
    public function eliminarCarreraArea($intIdCarreraArea, $intEstadoNuevo) {
        $info = $this->_db->query("SELECT * from spactivardesactivarcarreraarea(" . $intIdCarreraArea . "," . $intEstadoNuevo . ");");
        if ($info === false) {
            return "1103/eliminarCarreraArea";
        } else {
            return $info->fetchall();
        }
    }

    public function datosCarrera($idCarrera) {
        $info = $this->_db->query("select * from spDatosCarrera(" . $idCarrera . ");");
        if ($info === false) {
            return "1104/datosCarrera";
        } else {
            return $info->fetchall();
        }
    }

    public function actualizarCarrera($_datos) {
        $info = $this->_db->prepare("SELECT * from spActualizarCarrera(:nombre,:id) as Id;");
        $info->execute($_datos);
        if ($info === false) {
            return "1103/actualizarCarrera";
        } else {
            return $info->fetchall();
        }
    }

    public function agregarPensum($_datos) {
        $info = $this->_db->prepare("SELECT * from spagregarpensum(:carrera, :tipo, :inicioVigencia, :duracionAnios, :descripcion, :estado) as Id;");
        $info->execute($_datos);
        if ($info === false) {
            return "1101/agregarPensum";
        } else {
            return $info->fetchall();
        }
    }

    public function getAllPensum() {
        $info = $this->_db->query("select * from spallpensum();");
        if ($info === false) {
            return "1104/getPensum";
        } else {
            return $info->fetchall();
        }
    }

    public function getAllPensumActivos() {
        $info = $this->_db->query("select * from spallpensumactivos();");
        if ($info === false) {
            return "1104/getPensum";
        } else {
            return $info->fetchall();
        }
    }

    public function spfinalizarVigenciaPensum($intIdPensum, $estado) {
        $info = $this->_db->query("SELECT * from spfinalizarVigenciaPensum(" . $intIdPensum . ", " . $estado . ");");
        if ($info === false) {
            return "1103/finalizarVigenciaPensum/" . "SELECT * from spfinalizarVigenciaPensum(" . $intIdPensum . ", " . $estado . ");";
        } else {
            return $info->fetchall();
        }
    }

    public function activarPensum($intIdPensum) {
        $info = $this->_db->query("SELECT * from spactivarpensum(" . $intIdPensum . ");");
        if ($info === false) {
            return "1103/finalizarVigenciaPensum/" . "SELECT * from spactivarpensum(" . $intIdPensum . ");";
        } else {
            return $info->fetchall();
        }
    }

    public function listadoCursos($intIdCentroUnidad) {
        $info = $this->_db->query("SELECT * from spinformacioncurso(" . $intIdCentroUnidad . ");");
        if ($info === false) {
            return "1104/listadoCursos";
        } else {
            return $info->fetchall();
        }
    }

    public function listadoAreas($intIdCarrera) {
        $info = $this->_db->query("SELECT * from splistadoareaporcarrera(" . $intIdCarrera . ");");
        if ($info === false) {
            return "1104/listadoAreas";
        } else {
            return $info->fetchall();
        }
    }
    
    public function listadoTipoCiclo() {
        $info = $this->_db->query("SELECT * from splistadotipociclo();");
        if ($info === false) {
            return "1104/listadoTipoCiclo";
        } else {
            return $info->fetchall();
        }
    }
    
    public function listadoCursosPorPensum($intIdPensum) {
        $info = $this->_db->query("SELECT * from spinformacioncursosporpensum(" . $intIdPensum . ");");
        if ($info === false) {
            return "1104/listadoCursosPorPensum";
        } else {
            return $info->fetchall();
        }
    }
    
     public function agregarCursoPensum($_datos) {
        if( $_datos["creditos"]==""){ $_datos["creditos"]=0;}
        $sp = $_datos["curso"] . ',';
        $sp .= $_datos["pensum"] . ',' . $_datos["numerociclo"] . ',';
        $sp .= $_datos["tipociclo"] . ',' . $_datos["creditos"] . ',null,' . $_datos["estado"] . ',' . $_datos["carreraarea"];
                
        $info = $this->_db->prepare("SELECT * from spagregarcursopensum(" . $sp .")");
        $info->execute($_datos);
        if ($info === false) {
            return "1101/agregarCursoPensum";
        } else {
            return $info->fetchall();
        }
    }
    
     public function eliminarCursoPensum($intIdCursoPensum, $intEstadoNuevo){
        $info = $this->_db->query("SELECT * from spModificarCursoPensum(" . $intIdCursoPensum . ",null,null,null,null,null,null," . $intEstadoNuevo . ");");
        if($info === false){
            return "1102/eliminarCursoPensum";
        }else{
            return $info->fetchall();
        }
    }

    public function actualizarPensum($_datos) {

        $sp = $_datos["pensum"] . ',';
        $sp .= $_datos["carrera"] . ',' . $_datos["tipo"] . ',';
        $sp .= '\'' . $_datos["inicioVigencia"] . '\',\'' . $_datos["duracionAnios"] . '\',\'' . $_datos["descripcion"] . '\'';

        $info = $this->_db->query("SELECT * from spactualizarpensum(" . $sp . ");");

        if ($info === false) {
            return $sp . "1103/actualizarpensum";
        } else {
            return $info->fetchall();
      }
    }

    public function datosPensum($idPensum) {

        $post = $this->_db->query("select * from spdatosPensum(" . $idPensum . ");");

        if ($post === FALSE) {
            return "1104/consultaPensum";
        } else {
            return $post->fetchall();
        }
    }

}

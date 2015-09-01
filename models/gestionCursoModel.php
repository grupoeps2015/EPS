<?php

/**
 * Description of admCrearUsuarioModel
 *
 * @author Paola
 */

class gestionCursoModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function agregarCurso($_datos) {
        $sp = '\'' . $_datos["codigo"] . '\',\'' . $_datos["nombre"] . '\',';
        $sp .= $_datos["traslape"] . ',' . $_datos["estado"] . ',';
        $sp .= $_datos["tipocurso"];
        try {
            $post = $this->_db->query("SELECT * from spAgregarCurso(" . $sp . ") as Id;");
            return $post->fetchall();
            //return "SELECT * from spAgregarCurso(" . $sp . ") as Id;";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function getTiposCurso() {
        $post = $this->_db->query("select * from spconsultageneral('tipocurso,nombre','cur_tipo');");
        return $post->fetchall();
    }
    
    public function informacionCurso() {
        try {
            $post = $this->_db->query("select * from spInformacionCurso();");
            return $post->fetchall();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function eliminarCurso($intIdCurso, $intEstadoNuevo) {
        try {
            $this->_db->query("SELECT spActivarDesactivarCurso(" . $intIdCurso . "," . $intEstadoNuevo . ");");
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function datosCurso($idCurso) {
        try {
            $post = $this->_db->query("select * from spDatosCurso(" . $idCurso . ");");
            return $post->fetchall();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    
    public function actualizarCurso($_datos) {
        $sp = '\'' . $_datos["codigo"] . '\',\'' . $_datos["nombre"] . '\',';
        $sp .= $_datos["traslape"] . ',' . $_datos["id"] . ',';
        $sp .= $_datos["tipocurso"];
        try {
            $post = $this->_db->query("SELECT * from spActualizarCurso(" . $sp . ") as Id;");
            return $post->fetchall();
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}

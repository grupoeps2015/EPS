<?php

/**
 * Description of gestionPensumModel
 *
 * @author amoino
 */
class pensumModel extends Model {

    public function __construct() {
        parent::__construct();
    }

    public function agregarPensum($_datos) {
        $info = $this->_db->prepare("SELECT * from spagregarpensum(:carrera, :tipo, :inicioVigencia, :duracionAnios, :descripcion) as Id;");
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

    public function spfinalizarVigenciaPensum($intIdPensum) {
        $info = $this->_db->query("SELECT * from spfinalizarVigenciaPensum(" . $intIdPensum . ");");
        if ($info === false) {
            return "1103/finalizarVigenciaPensum/" . "SELECT * from spfinalizarVigenciaPensum(" . $intIdPensum . ");";
        } else {
            return $info->fetchall();
        }
    }

}

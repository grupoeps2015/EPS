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
        $info = $this->_db->prepare("SELECT * from spagregarpensum(:carrera, :tipo, :inicioVigencia, :duracionAnios, :finVigencia, :descripcion) as Id;");
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
            return "1104/getJornadas";
        } else {
            return $info->fetchall();
        }
    }

}

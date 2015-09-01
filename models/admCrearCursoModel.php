<?php

/**
 * Description of admCrearUsuarioModel
 *
 * @author Rickardo
 */
class admHistoriaCrearCursoModel extends Model {

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
            //return "SELECT spagregarusuarios(" . $sp . ");";
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function getTiposCurso() {
        $post = $this->_db->query("select * from spconsultageneral('tipocurso,nombre','cur_tipo');");
        return $post->fetchall();
    }
    

    
}

?>

<?php

class gestionNotasModel extends Model {

    public function __construct() {
        parent::__construct();
    }
 
    public function getCursos() {
        $post = $this->_db->query("select * from spconsultageneral('curso,nombre','cur_curso');");
        return $post->fetchall();
    }
    
}
<?php
//Constantes del carpetas
define('BASE_URL','http://localhost/EPS/');
//define('BASE_URL','http://localhost:82/EPS/');
//define('BASE_URL','http://sitios.usac.edu.gt/eps_controlacad/');
define('DEFAULT_CONTROLLER','index');
define('DEFAULT_LAYOUT','default');
define('ADM_FOLDER','adm');
define('ADMH_FOLDER','admHistoria');
define('USRH_FOLDER','usrHistoria');
define('ALL_FOLDER','all');

//Constantes del portal
define('APP_TITULO','Sistema de control academico - USAC');
define('DB_KEY','2015.RmGm');
define('PARAM_KEY','MrMg.2015');
define('BOLETA_KEY',2610);
define('ROL_ADMINISTRADOR','0');
define('ROL_ESTUDIANTE','1');
define('ROL_DOCENTE','2');
define('ROL_EMPLEADO','3');
define('ESTADO_ACTIVO','1');
define('ESTADO_PENDIENTE','0');
define('ESTADO_INACTIVO','-1');
define('PERMISO_GESTIONAR','1');
define('PERMISO_CONSULTAR','1');
define('PERMISO_CREAR','1');
define('PERMISO_MODIFICAR','1');
define('PERMISO_ELIMINAR','1');
define('PERIODO_ASIGNACION_CURSOS','1');
define('PERIODO_INGRESO_NOTAS','2');
define('PERIODO_INGRESO_ACTIVIDADES','3');
define('PERIODO_ASIGNACION_1RETRASADA','4');
define('PERIODO_ASIGNACION_2RETRASADA','5');
define('PERIODO_ASIGNACION_SUFICIENCIAS','6');
define('ASIGN_JUNTADIRECTIVA','1');
define('ASIGN_OTRAS','0');
define('MSG_SINPERMISOS','alert(\'No tiene permisos para acceder a esta función.\');');
define('CURSO_APROBADO','APROBADO');
define('CURSO_REPROBADO','REPROBADO');
define('UNIDAD_ESCUELAHISTORIA','14');
define('EXTENSION_ESCUELAHISTORIA','0');
define('VARIANTERUBRO_RETRASADAS','1');
define('TIPOCURSO_ESCUELAHISTORIA','CURSO');

//Constantes de base de datos
define('DB_HOST','localhost');
define('DB_USER','postgres');
define('DB_PASS','pruebas123');
//define('DB_PASS','USAC2015pg');
//define('DB_PASS','moino');
//define('DB_NAME','Prueba');
define('DB_NAME','EPS');
define('DB_CHAR','utf8');

define('CHAR_SET', 'UTF-8');

?>

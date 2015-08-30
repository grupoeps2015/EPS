-- -----------------------------------------------------
-- Function: spautenticarusuario(integer, text, text, text)
-- -----------------------------------------------------
-- DROP FUNCTION spautenticarusuario(integer, text, text, text);

CREATE OR REPLACE FUNCTION spautenticarusuario(
    IN _id integer,
    IN _clave text,
    IN _campo text,
    IN _tabla text,
    OUT usuario integer,
    OUT nombre text,
    OUT estado integer,
    OUT rol integer)
  RETURNS SETOF record AS
$BODY$
begin
 Return query EXECUTE format('SELECT adm_usuario.usuario, adm_usuario.nombre, adm_usuario.estado, adm_rol_usuario.rol FROM adm_usuario join %s on adm_usuario.usuario = %s.usuario and %s.%s = %s and adm_usuario.clave = ''%s'' join adm_rol_usuario on adm_rol_usuario.usuario = adm_usuario.usuario', _tabla, _tabla, _tabla, _campo, _id, _clave);

end;
  $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spautenticarusuario(integer, text, text, text)
  OWNER TO postgres;
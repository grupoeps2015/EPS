-- -----------------------------------------------------
-- Function: spautenticarusuario(integer, text, text, text)
-- -----------------------------------------------------
-- DROP FUNCTION spautenticarusuario(integer, text, text, text);

CREATE OR REPLACE FUNCTION spInsertarBitacoraUsuario(
    IN _tabla text,
	IN _usuario integer,
    IN _nombreusuario text,
	IN _funcion integer,
    IN _ip text,
	IN _registro integer,
    IN _tablacampo text,
	IN _descripcion text)
  RETURNS void AS
$BODY$
DECLARE fecha date;
DECLARE hora time;
begin
 SELECT current_date into fecha;
 SELECT current_time into hora;
 EXECUTE format('INSERT INTO %s (Usuario, NombreUsuario, Funcion, Fecha, Hora, IP, Registro, Tabla, Descripcion) VALUES(%s, ''%s'', %s, ''%s'', ''%s'', ''%s'', %s, ''%s'', ''%s'')', _tabla, _usuario, _nombreusuario, _funcion, fecha, hora, _ip, _registro, _tablacampo, _descripcion);

end;
  $BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
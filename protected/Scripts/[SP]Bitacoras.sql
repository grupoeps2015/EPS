-- ------------------------------------------------------
-- Function: spinsertarbitacorausuario()
-- ------------------------------------------------------
-- DROP FUNCTION spinsertarbitacorausuario(text, integer, text, integer, text, integer, text, text);
-- ------------------------------------------------------

CREATE OR REPLACE FUNCTION spinsertarbitacorausuario(
    _tabla text,
    _usuario integer,
    _nombreusuario text,
    _funcion integer,
    _ip text,
    _registro integer,
    _tablacampo text,
    _descripcion text)
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
ALTER FUNCTION spinsertarbitacorausuario(text, integer, text, integer, text, integer, text, text)
  OWNER TO postgres;

-- ------------------------------------------------------
-- Function: spInsertarBitacoraNotas()
-- ------------------------------------------------------
-- DROP FUNCTION spInsertarBitacoraNotas(integer, text, integer, text, text);
-- ------------------------------------------------------
CREATE OR REPLACE FUNCTION spInsertarBitacoraNotas(
    _usuario integer,
    _nombreusuario text,
    _funcion integer,
    _ip text,
    _registro integer)
  RETURNS void AS
$BODY$
DECLARE fecha date;
DECLARE hora time;
DECLARE tabla text;
DECLARE descripcion text;
begin
 SELECT current_date into fecha;
 SELECT current_time into hora;
 tabla = 'est_cur_nota';
 descripcion = 'Nota actualizada por catedratico/empleado';
 EXECUTE format('INSERT INTO est_cur_nota_bitacora (Usuario, NombreUsuario, Funcion, Fecha, Hora, IP, Registro, Tabla, Descripcion) 
		 VALUES(''%s'', ''%s'', ''%s'', ''%s'', ''%s'', ''%s'', ''%s'', ''%s'', ''%s'')', 
		 _usuario, _nombreusuario, _funcion, fecha, hora, _ip, _registro, tabla, descripcion);

end;
$BODY$
LANGUAGE plpgsql;

Select 'Script de Bitacoras Instalado' as "Bitacoras";
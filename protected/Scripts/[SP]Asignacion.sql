-- Function: spPeriodoActivo(integer,integer,integer,integer)

-- DROP FUNCTION spPeriodoActivo(integer,integer,integer,integer);

CREATE OR REPLACE FUNCTION spPeriodoActivo(
    _ciclo integer,
	_tipoperiodo integer,
	_tipoasignacion integer,
	_centrounidad integer)
  RETURNS INTEGER AS
$BODY$
begin
IF _tipoasignacion <> 1 THEN
 Return (select per.periodo
	      from 
	        adm_periodo per
	      where per.ciclo = _ciclo and per.tipoperiodo = _tipoperiodo and per.centro_unidadacademica = _centrounidad and current_date between per.fechainicial and per.fechafinal and per.estado = 1) ::INTEGER;
ELSE
 Return (select per.periodo
	      from 
	        adm_periodo per
	      where per.ciclo = _ciclo and per.tipoperiodo = _tipoperiodo and per.tipoasignacion = _tipoasignacion and per.centro_unidadacademica = _centrounidad and per.estado = 1) ::INTEGER;
END IF;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100;
ALTER FUNCTION spPeriodoActivo(integer,integer,integer,integer)
  OWNER TO postgres;
  
  
-- Function: spcursosdisponiblesasignacion(integer, integer)

-- DROP FUNCTION spcursosdisponiblesasignacion(integer, integer);

CREATE OR REPLACE FUNCTION spcursosdisponiblesasignacion(
    IN _ciclo integer,
    IN _carrera integer,
    OUT curso integer,
    OUT codigo text,
    OUT nombre text,
    OUT traslape boolean)
  RETURNS SETOF record AS
$BODY$
begin
 Return query
 select distinct cur.curso, cur.codigo, cur.nombre, cur.traslape
	      from 
	        cur_curso cur
	      join
	        cur_pensum_area curpen on curpen.curso = cur.curso
	      join
	        adm_pensum pen on curpen.pensum = pen.pensum
	      join
	        cur_seccion sec on curpen.curso = sec.curso
	      join
	        cur_trama tra on tra.seccion = sec.seccion
	      join
	        cur_horario hor on hor.trama = tra.trama
	      where hor.ciclo = _ciclo and hor.estado = 1 and pen.carrera = _carrera and pen.finvigencia is null;
end;
$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION spcursosdisponiblesasignacion(integer, integer)
  OWNER TO postgres;

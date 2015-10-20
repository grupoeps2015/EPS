----------------------------------------------------------------------------------------
-- Function: spInformacionSalon()
----------------------------------------------------------------------------------------
-- DROP FUNCTION spInformacionSalon(integer);
CREATE OR REPLACE FUNCTION spInformacionSalon(idEdificio integer, estadoActivo integer, OUT salon int, 
					          OUT Nombre text, OUT NombreEdificio text, 
					          OUT Nivel int, OUT Capacidad int, OUT Estado int) RETURNS setof record as 
$BODY$
BEGIN
  RETURN query
  
	SELECT s.salon,s.nombre,e.nombre AS NombreEdificio, s.nivel,s.capacidad,s.estado
	FROM CUR_Salon s
	JOIN CUR_Edificio e ON e.edificio = s.edificio
	WHERE e.edificio = idEdificio
	AND e.estado = estadoActivo
	ORDER BY s.nombre;

END;
$BODY$
LANGUAGE 'plpgsql';

----------------------------------------------------------------------------------------
-- Function: spAgregarSalon()
----------------------------------------------------------------------------------------
-- DROP FUNCTION spagregarsalon(text, integer, integer, integer); 
CREATE OR REPLACE FUNCTION spAgregarSalon(_nombre text, 
						  _edificio integer,
					      _nivel integer, 
					      _capacidad integer
					     ) RETURNS void AS 
$BODY$
BEGIN
	INSERT INTO CUR_Salon(salon,
            nombre,edificio,nivel,capacidad,estado)
	VALUES (DEFAULT,_nombre,_edificio,_nivel,_capacidad,0);

END; $BODY$
LANGUAGE 'plpgsql';

----------------------------------------------------------------------------------------
-- Function: spdatossalon()
----------------------------------------------------------------------------------------
-- DROP FUNCTION spdatossalon(int);
CREATE OR REPLACE FUNCTION spDatosSalon(Salon int, 
					    OUT Nombre text, OUT Nivel int, 
					    OUT Capacidad int) RETURNS setof record as 
$BODY$
BEGIN
  RETURN query
  SELECT s.nombre, s.nivel, s.capacidad
    FROM CUR_Salon s
	WHERE s.salon = $1;

END;
$BODY$
LANGUAGE 'plpgsql';

----------------------------------------------------------------------------------------
-- Function: spModificarSalon()
----------------------------------------------------------------------------------------
-- DROP FUNCTION spmodificarsalon(integer, text, integer, integer, integer); 
CREATE OR REPLACE FUNCTION spModificarSalon(_salon integer, 
						_nombre text, 
					        _nivel integer,
					        _capacidad integer, 
					        _estado integer
					     )RETURNS BOOLEAN LANGUAGE plpgsql SECURITY DEFINER AS $$

BEGIN
    UPDATE CUR_Salon
       SET nombre = COALESCE(spModificarSalon._nombre, CUR_Salon.nombre),
           nivel = COALESCE(spModificarSalon._nivel, CUR_Salon.nivel),
           capacidad = COALESCE(spModificarSalon._capacidad, CUR_Salon.capacidad),
           estado = COALESCE(spModificarSalon._estado, CUR_Salon.estado)
     WHERE CUR_Salon.salon = spModificarSalon._salon;       
    RETURN FOUND;
END;
$$;

Select 'Script para Gestion de salones Instalado' as "Gestion Salones";
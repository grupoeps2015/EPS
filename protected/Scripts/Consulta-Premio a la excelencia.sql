
SELECT PremioExcelencia.Estudiante, PremioExcelencia.Nombre, PremioExcelencia.Carnet, PremioExcelencia.CreditosObtenidos, PremioExcelencia.CursosReprobados, PremioExcelencia.Promedio FROM (
--Muestra el total de creditos obtenidos por un estudiante inscrito en un anio especifico
SELECT EE.Estudiante, EE.Nombre, EE.Carnet, SUM(CPA.Creditos) AS CreditosObtenidos, 
(SELECT COUNT(CPA2.CursoPensumArea) FROM CUR_Pensum_Area CPA2
JOIN CUR_Seccion CS2 ON CPA2.CursoPensumArea = CS2.CursoPensumArea
JOIN EST_CUR_Asignacion ECA2 ON CS2.Seccion = ECA2.Seccion
JOIN EST_CUR_Nota ECN2 ON ECN2.Asignacion = ECA2.Asignacion 
JOIN EST_Estudiante EE2 ON EE2.Estudiante = ECA2.Estudiante
JOIN EST_Inscripcion EI2 ON EI2.Estudiante = EE2.Estudiante
--WHERE EE2.Estudiante = EE.Estudiante --Id del estudiante
AND ECN2.Total < 61 --Nota de reprobacion
AND EI2.Anio = EI.Anio --Anio actual 
AND ECA2.OportunidadActual = ECA.OportunidadActual --Oportunidad actual
AND ECN2.EstadoNota = ECN.EstadoNota --Estado de Acta con notas reales
) AS CursosReprobados,
(SELECT AVG(ECN.Total) AS NotaPromedio
FROM CUR_Pensum_Area CPA3
JOIN CUR_Seccion CS3 ON CPA3.CursoPensumArea = CS3.CursoPensumArea
JOIN EST_CUR_Asignacion ECA3 ON CS3.Seccion = ECA3.Seccion
JOIN EST_CUR_Nota ECN3 ON ECN3.Asignacion = ECA3.Asignacion 
JOIN EST_Estudiante EE3 ON EE3.Estudiante = ECA3.Estudiante
JOIN EST_Inscripcion EI3 ON EI3.Estudiante = EE3.Estudiante
--WHERE EE3.Estudiante = EE.Estudiante --Id del estudiante
AND ECN3.Total >= 61 --Nota de aprobacion
AND EI3.Anio = EI.Anio --Anio actual
AND ECA3.OportunidadActual = ECA.OportunidadActual --Oportunidad actual
AND ECN3.EstadoNota = ECN.EstadoNota --Estado de Acta con notas reales
ORDER BY NotaPromedio DESC
Limit 1
) AS Promedio

FROM CUR_Pensum_Area CPA
JOIN CUR_Seccion CS ON CPA.CursoPensumArea = CS.CursoPensumArea
JOIN EST_CUR_Asignacion ECA ON CS.Seccion = ECA.Seccion
JOIN EST_CUR_Nota ECN ON ECN.Asignacion = ECA.Asignacion 
JOIN EST_Estudiante EE ON EE.Estudiante = ECA.Estudiante
JOIN EST_Inscripcion EI ON EI.Estudiante = EE.Estudiante
--WHERE EE.Estudiante = 1 --Id del estudiante
AND ECN.Total >= 61 --Nota de aprobacion
AND EI.Anio = 2015 --Anio actual
AND ECA.OportunidadActual = 1 --Solo ha llevado el curso una vez
AND ECN.EstadoNota = 3 --Estado de Acta con notas reales
GROUP BY EE.Estudiante, EE.Nombre, EE.Carnet, EI.Anio, ECA.OportunidadActual, ECN.EstadoNota
) AS PremioExcelencia 
WHERE PremioExcelencia.CreditosObtenidos >= 150
AND PremioExcelencia.CursosReprobados = 0
ORDER BY PremioExcelencia.Promedio DESC

/*
SELECT CreditosObtenidos.Estudiante, CreditosObtenidos.Nombre, CreditosObtenidos.Carnet, CreditosObtenidos.Creditos FROM )
--Muestra el total de creditos obtenidos por un estudiante inscrito en un anio especifico
SELECT EE.Estudiante, EE.Nombre, EE.Carnet, SUM(CPA.Creditos) AS Creditos
FROM CUR_Pensum_Area CPA
JOIN CUR_Seccion CS ON CPA.CursoPensumArea = CS.CursoPensumArea
JOIN EST_CUR_ASIGNACION ECA ON CS.Seccion = ECA.Seccion
JOIN EST_CUR_Nota ECN ON ECN.Asignacion = ECA.Asignacion 
JOIN EST_Estudiante EE ON EE.Estudiante = ECA.Estudiante
JOIN EST_Inscripcion EI ON EI.Estudiante = EE.Estudiante
WHERE EE.Estudiante = 1 --Id del estudiante
AND ECN.Total >= 61 --Nota de aprobacion
AND EI.Anio = 2015 --Anio actual
GROUP BY EE.Estudiante, EE.Nombre, EE.Carnet
) AS CreditosObtenidos
*/

/*
SELECT CursosReprobados.Estudiante, CursosReprobados.Nombre, CursosReprobados.Carnet, CursosReprobados.Reprobados FROM (
--Muestra el total de cursos reprobados de un estudiante inscrito en un anio especifico
SELECT EE.Estudiante, EE.Nombre,EE.Carnet, COUNT(CPA.CursoPensumArea) AS Reprobados
FROM CUR_Pensum_Area CPA
JOIN CUR_Seccion CS ON CPA.CursoPensumArea = CS.CursoPensumArea
JOIN EST_CUR_ASIGNACION ECA ON CS.Seccion = ECA.Seccion
JOIN EST_CUR_Nota ECN ON ECN.Asignacion = ECA.Asignacion 
JOIN EST_Estudiante EE ON EE.Estudiante = ECA.Estudiante
JOIN EST_Inscripcion EI ON EI.Estudiante = EE.Estudiante
WHERE EE.Estudiante = 1 --Id del estudiante
AND ECN.Total < 61 --Nota de reprobacion
AND EI.Anio = 2015 --Anio actual
GROUP BY EE.Estudiante, EE.Nombre, EE.Carnet
) AS CursosReprobados
*/

/*
SELECT Promedio.Estudiante, Promedio.Nombre, Promedio.Carnet, Promedio.NotaPromedio FROM (
--Muestra el estudiante con mejor promedio inscrito en un anio especifico
SELECT EE.Estudiante, EE.Nombre,EE.Carnet, AVG(ECN.Total) AS NotaPromedio
FROM CUR_Pensum_Area CPA
JOIN CUR_Seccion CS ON CPA.CursoPensumArea = CS.CursoPensumArea
JOIN EST_CUR_ASIGNACION ECA ON CS.Seccion = ECA.Seccion
JOIN EST_CUR_Nota ECN ON ECN.Asignacion = ECA.Asignacion 
JOIN EST_Estudiante EE ON EE.Estudiante = ECA.Estudiante
JOIN EST_Inscripcion EI ON EI.Estudiante = EE.Estudiante
WHERE EE.Estudiante = 1 --Id del estudiante
AND ECN.Total >= 61 --Nota de aprobacion
AND EI.Anio = 2015 --Anio actual
GROUP BY EE.Estudiante, EE.Nombre, EE.Carnet
ORDER BY NotaPromedio DESC
) AS Promedio
*/
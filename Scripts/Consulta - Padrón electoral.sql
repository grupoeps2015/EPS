SELECT EST.Nombre, EST.Carnet, PA.Nombre
FROM EST_Estudiante EST
JOIN EST_Inscripcion INS ON INS.Estudiante = EST.Estudiante
JOIN ADM_Pais PA ON PA.Pais = EST.PaisOrigen
WHERE PA.Pais = 1 --Código de Guatemala
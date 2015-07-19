select distinct cd.nombre as dia, cp.periodo, cj.nombre as jornada, ct.inicio, ct.fin
from cur_horario ch
join cur_trama ct on ch.trama = ct.trama
join cur_dia cd on cd.codigo = ct.dia
join cur_periodo cp on ct.periodo = cp.periodo
join cur_jornada cj on cj.jornada = ch.jornada
group by cd.nombre, cp.periodo, cj.nombre, ct.inicio, ct.fin
having cd.nombre = 'Lunes'
order by ct.inicio asc
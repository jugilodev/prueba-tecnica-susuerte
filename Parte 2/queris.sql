--primera consulta
--Consulta que retorne los **3 usuarios con mayor monto total apostado en tiquetes ganadores**.

select u.nombre, SUM(t.monto) as total
from usuarios u
join tiquetes t on u.id = t.usuario_id
where t.estado = 'ganador'
group by u.nombre
order by total desc
limit 3;

--segunda consulta
--Consulta que liste los usuarios sin ningún tiquete registrado.

select u.nombre from usuarios u
join tiquetes t on u.id = t.usuario_id
where t.id is null;


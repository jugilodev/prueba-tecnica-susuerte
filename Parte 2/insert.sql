INSERT INTO usuarios
(nombre, saldo)
VALUES
('Juan', 100000),
('Ana', 50000);

INSERT INTO tiquetes
(usuario_id, monto, estado)
VALUES
(1, 10000, 'ganador'),
(1, 5000, 'pendiente'),
(2, 20000, 'ganador'),
(2, 10000, 'cancelado');
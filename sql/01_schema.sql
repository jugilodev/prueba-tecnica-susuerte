CREATE TABLE usuarios (
    id SERIAL PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    saldo NUMERIC(12,2) NOT NULL DEFAULT 0,
    creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE tiquetes (
    id SERIAL PRIMARY KEY,
    usuario_id INT NOT NULL,
    monto NUMERIC(12,2) NOT NULL,
    fecha DATE NOT NULL DEFAULT CURRENT_DATE,
    estado VARCHAR(20)
        NOT NULL 
        DEFAULT 'pendiente'
        CHECK (estado IN ('pendiente', 'ganador', 'perdedor')),
    creado_en TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_tiquetes_usuario
        FOREIGN KEY (usuario_id)
        REFERENCES usuarios(id)
        ON DELETE RESTRICT
);

CREATE INDEX idx_tiquetes_usuario
ON tiquetes(usuario_id);

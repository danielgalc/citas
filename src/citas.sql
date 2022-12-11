CREATE EXTENSION IF NOT EXISTS pgcrypto;

DROP TABLE IF EXISTS usuarios CASCADE;

CREATE TABLE usuarios (
    id_usuario BIGSERIAL PRIMARY KEY, 
    codigo VARCHAR(13) NOT NULL, 
    nombre VARCHAR(255) NOT NULL, 
    password VARCHAR(255) NOT NULL
);

DROP TABLE IF EXISTS citas CASCADE;

CREATE TABLE citas (
    id_cita BIGSERIAL PRIMARY KEY, 
    fecha DATE NOT NULL, 
    hora TIME NOT NULL,
    id_usuario BIGINT NOT NULL REFERENCES usuarios (id_usuario)
);

-- carga inicial

INSERT INTO usuarios (codigo, nombre, password)
    VALUES ('0000', 'admin', crypt('admin', gen_salt('bf', 10))), 
           ('1010','dani', crypt('dani', gen_salt('bf', 10))),
           ('2121','qqq', crypt('1111', gen_salt('bf', 10)));
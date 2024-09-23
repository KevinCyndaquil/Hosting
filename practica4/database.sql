CREATE TABLE productos (
    id int primary key,
    nombre text,
    precio decimal(5, 2),
    extension int,
    CONSTRAINT chk_precio CHECK (precio > 0)
);
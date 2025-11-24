CREATE TABLE Proyectos (
    proyecto_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nombre_proyecto VARCHAR(255) NOT NULL,
    descripcion TEXT,
    fecha_inicio DATE NOT NULL,
    fecha_finalizacion DATE,
    estado VARCHAR(50) NOT NULL CHECK (estado IN ('planificado', 'en curso', 'finalizado'))
);
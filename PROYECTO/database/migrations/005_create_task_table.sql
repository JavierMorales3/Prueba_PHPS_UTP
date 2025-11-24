CREATE TABLE Tareas (
    tarea_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    titulo VARCHAR(255) NOT NULL,
    descripcion TEXT,
    fecha_vencimiento DATE,
    estado VARCHAR(50) NOT NULL CHECK (estado IN ('pendiente', 'en progreso', 'completada')),
    proyecto_id INT NOT NULL,
    encargado_id INT,
    FOREIGN KEY (proyecto_id) REFERENCES Proyecto(proyecto_id),
    FOREIGN KEY (encargado_id) REFERENCES Usuario(usuario_id)
);
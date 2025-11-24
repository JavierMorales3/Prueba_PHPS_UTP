CREATE TABLE Notificaciones (
    notificacion_id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    usuario_id INT NOT NULL,
    tipo_notificacion VARCHAR(100) NOT NULL CHECK (tipo_notificacion IN ('tarea asignada', 'vencimiento próximo', 'comentario')),
    mensaje TEXT NOT NULL,
    estado VARCHAR(50) NOT NULL DEFAULT 'no leida' CHECK (estado IN ('leida', 'no leida')),
    FOREIGN KEY (usuario_id) REFERENCES Usuario(usuario_id)
);
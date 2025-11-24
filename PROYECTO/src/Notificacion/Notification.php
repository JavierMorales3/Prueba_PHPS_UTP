<?php
class Notification {
    public $notificacion_id;
    public $usuario_id;
    public $tipo_notificacion;
    public $mensaje;
    public $estado;

    // Constructor para crear un objeto Notification a partir de un array de datos
    public function __construct($data) {
        $this->notificacion_id = $data['notificacion_id'];
        $this->usuario_id = $data['usuario_id'];
        $this->tipo_notificacion = $data['tipo_notificacion'];
        $this->mensaje = $data['mensaje'];
        $this->estado = $data['estado'];
    }

    // Aquí podrían añadirse métodos adicionales relacionados con una notificacion individual
}
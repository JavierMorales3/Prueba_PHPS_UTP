<?php
class Proyect {
    public $proyecto_id;
    public $nombre_proyecto;
    public $descripcion;
    public $fecha_inicio;
    public $fecha_finalizacion;
    public $estado;

    // Constructor para crear un objeto Proyect a partir de un array de datos
    public function __construct($data) {
        $this->proyecto_id = $data['proyecto_id'];
        $this->nombre_proyecto = $data['nombre_proyecto'];
        $this->descripcion = $data['descripcion'];
        $this->fecha_inicio = $data['fecha_inicio'];
        $this->fecha_finalizacion = $data['fecha_finalizacion'];
        $this->estado = $data['estado'];
    }

    // Aquí podrían añadirse métodos adicionales relacionados con un proyecto individual
}
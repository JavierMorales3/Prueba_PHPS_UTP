<?php
class Users {
    public $usuario_id;
    public $nombre;
    public $correo_electronico;
    public $rol;

    // Constructor para crear un objeto User a partir de un array de datos
    public function __construct($data) {
        $this->usuario_id = $data['usuario_id'];
        $this->nombre = $data['nombre'];
        $this->correo_electronico = $data['correo_electronico'];
        $this->rol = $data['rol'];

    }

    // Aquí podrían añadirse métodos adicionales relacionados con un usuario individual
}
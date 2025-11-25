<?php
class UserManager {
    private $db;

    public function __construct() {
        // Obtenemos la conexión a la base de datos
        $this->db = Database::getInstance()->getConnection();
    }

    // Método para obtener todas los usuarios
    public function getAllUsers() {
        $stmt = $this->db->query("SELECT * FROM Usuarios ORDER BY usuario_id DESC");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $map= array_map(function ($item) { return new Proyect($item);},$data);
        return $map;
    }

    // Método para crear un nuevo usuario
    public function createUser($user) {
        $stmt = $this->db->prepare("INSERT INTO Usuarios (nombre, apellido, correo_electronico, rol) VALUES (?,?,?,?)");
        $payload = [ $user->nombre, $user->apellido, $user->correo_electronico, $user->rol];
        return $stmt->execute($payload);
    }

    // Método para eliminar un usuario
    public function deleteUser($proyecto_id) {
        $stmt = $this->db->prepare("DELETE FROM Usuarios WHERE usuario_id = ?");
        return $stmt->execute([$proyecto_id]);
    }
}
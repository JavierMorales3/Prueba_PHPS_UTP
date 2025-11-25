<?php
class ProyectManager {
    private $db;

    public function __construct() {
        // Obtenemos la conexión a la base de datos
        $this->db = Database::getInstance()->getConnection();
    }

    // Método para obtener todas los proyectos
    public function getAllProyects() {
        $stmt = $this->db->query("SELECT * FROM Proyectos ORDER BY fecha_inicio DESC");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $map= array_map(function ($item) { return new Proyect($item);},$data);
        return $map;
    }

    // Método para crear un nuevo proyecto
    public function createProyects($proyect) {
        $stmt = $this->db->prepare("INSERT INTO Proyectos (nombre_proyecto, descripcion, fecha_inicio, fecha_finalizacion, estado) VALUES (?,?,?,?,?)");
        $payload = [ $proyect->nombre_proyecto, $proyect->descripcion, $proyect->fecha_inicio, $proyect->fecha_finalizacion, $proyect->estado];
        return $stmt->execute($payload);
    }

    // Método para eliminar un proyecto
    public function deleteProyects($proyecto_id) {
        $stmt = $this->db->prepare("DELETE FROM Proyectos WHERE proyecto_id = ?");
        return $stmt->execute([$proyecto_id]);
    }
}
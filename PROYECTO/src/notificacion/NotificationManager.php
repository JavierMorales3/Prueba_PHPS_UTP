<?php
class NotificationManager {
    private $db;

    public function __construct() {
        // Obtenemos la conexión a la base de datos
        $this->db = Database::getInstance()->getConnection();
    }

    // Método para obtener todas las notificaciones
    public function getAllNotifications() {
        $stmt = $this->db->query("SELECT * FROM Notificaciones ORDER BY estado DESC");
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $map= array_map(function ($item) { return new Notification($item);},$data);
        return $map;
    }

    // Método para crear una nueva Notificacion
    public function createNotifications($notification) {
        $stmt = $this->db->prepare("INSERT INTO Notificaciones (usuario_id, tipo_notificacion, mensaje) VALUES (?,?,?)");
        $payload = [ $notification->usuario_id, $notification->tipo_notificacion, $notification->mensaje];
        return $stmt->execute($payload);
    }

    // Método para eliminar una Notificacion
    public function deleteNotifications($notificacion_id) {
        $stmt = $this->db->prepare("DELETE FROM Notificaciones WHERE notificacion_id = ?");
        return $stmt->execute([$notificacion_id]);
    }
}
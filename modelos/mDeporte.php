<?php
require_once 'mConexion.php';

class MDeporte extends Conexion {
    
    /**
     * Obtiene todos los deportes disponibles
     * @return array Lista de deportes con idDeporte y nombreDep
     */
    public function obtenerTodosDeportes() {
        try {
            $sql = "SELECT idDeporte, nombreDep FROM Deportes ORDER BY nombreDep";
            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error al obtener deportes: " . $e->getMessage());
            return [];
        }
    }
}
?>

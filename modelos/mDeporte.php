<?php
require_once 'mConexion.php';

class MDeporte extends Conexion {
    
    /**
     * Obtiene todos los deportes disponibles
     * @return array Lista de deportes con idDeporte, nombreDep e imagen
     */
    public function obtenerTodosDeportes() {
        try {
            $sql = "
                SELECT idDeporte, nombreDep, imagen 
                FROM Deportes ORDER BY nombreDep";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Error al obtener deportes: " . $e->getMessage());
            return [];
        }
    }

    public function obtenerDeporte($id) {
        try {
            $sql = "
                SELECT * 
                FROM Deportes 
                WHERE idDeporte = :id";

            $stmt = $this->conexion->prepare($sql);
            $stmt->execute([':id' => $id]);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log("Error al obtener deporte: " . $e->getMessage());
            return null;
        }
    }

    public function insertarDeporte($nombre, $imagen = null) {
        try {
            $sql = "
                INSERT INTO Deportes (nombreDep, imagen) 
                VALUES (:nombre, :imagen)";

            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([':nombre' => $nombre, ':imagen' => $imagen]);
        } catch (PDOException $e) {
            error_log("Error al insertar deporte: " . $e->getMessage());
            return false;
        }
    }

    public function actualizarDeporte($id, $nombre, $imagen = null) {
        try {
            $sql = "
                UPDATE Deportes 
                SET nombreDep = :nombre, imagen = :imagen 
                WHERE idDeporte = :id";

            $params = [':nombre' => $nombre, ':imagen' => $imagen, ':id' => $id];
            
            // Si la imagen es null, no la actualizamos (mantenemos la anterior)
            // Pero como la lógica de negocio puede querer borrarla o cambiarla, 
            // aquí asumimos que el controlador maneja qué valor pasar.
            // Si queremos permitir que no se actualice si es null, tendríamos que cambiar la query dinámicamente.
            // Para simplificar: el controlador debe pasar la imagen antigua si no hay nueva.
            
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log("Error al actualizar deporte: " . $e->getMessage());
            return false;
        }
    }

    public function borrarDeporte($id) {
        try {
            $sql = "
                DELETE FROM Deportes 
                WHERE idDeporte = :id";
                
            $stmt = $this->conexion->prepare($sql);
            return $stmt->execute([':id' => $id]);
        } catch (PDOException $e) {
            error_log("Error al borrar deporte: " . $e->getMessage());
            return false;
        }
    }
}
?>

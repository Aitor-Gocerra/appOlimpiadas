<?php
require_once 'mConexion.php';

class MUsuario extends Conexion {

    /**
     * Valida las credenciales de un usuario
     * @param string $usuario Nombre de usuario
     * @param string $password Contraseña
     * @return array|false Datos del usuario (idUsuario, perfil) o false si no es válido
     */
    public function validarUsuario($usuario, $password) {
        $sql = "SELECT idUsuario, perfil FROM Usuarios 
                WHERE nombreUsuario = :usuario AND password = :password";

        $sentencia = $this->conexion->prepare($sql);
        $sentencia->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $sentencia->bindParam(':password', $password, PDO::PARAM_STR);
        $sentencia->execute();
        $resultado = $sentencia->fetch();
        
        return $resultado;
    }

    /**
     * Verifica si un nombre de usuario ya existe
     * @param string $nombreUsuario Nombre de usuario a verificar
     * @return bool true si existe, false si no existe
     */
    public function existeUsuario($nombreUsuario) {
        $sql = "SELECT COUNT(*) as total FROM Usuarios WHERE nombreUsuario = :nombreUsuario";
        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nombreUsuario', $nombreUsuario, PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetch();
        return $resultado['total'] > 0;
    }

    /**
     * Registra un nuevo usuario con perfil 'u'
     * @param array $datos Datos del usuario (nombreUsuario, apeNombre, password, correo, telefono)
     * @return int|false ID del usuario creado o false si hay error
     */
    public function registrarUsuario($datos) {
        try {
            $sql = "INSERT INTO Usuarios (nombreUsuario, apeNombre, password, correo, telefono, perfil) 
                    VALUES (:nombreUsuario, :apeNombre, :password, :correo, :telefono, 'u')";
            
            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombreUsuario', $datos['nombreUsuario'], PDO::PARAM_STR);
            $stmt->bindParam(':apeNombre', $datos['apeNombre'], PDO::PARAM_STR);
            $stmt->bindParam(':password', $datos['password'], PDO::PARAM_STR);
            $stmt->bindParam(':correo', $datos['correo'], PDO::PARAM_STR);
            
            // El teléfono puede ser NULL
            $telefono = !empty($datos['telefono']) ? $datos['telefono'] : null;
            $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);
            
            $stmt->execute();
            return $this->conexion->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error al registrar usuario: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Inscribe un usuario a uno o varios deportes
     * @param int $idUsuario ID del usuario
     * @param array $deportes Array de IDs de deportes
     * @return bool true si se inscribió correctamente, false si hay error
     */
    public function inscribirDeportes($idUsuario, $deportes) {
        try {
            $sql = "INSERT INTO Usuarios_deportes (idDeporte, idUsuario) VALUES (:idDeporte, :idUsuario)";
            $stmt = $this->conexion->prepare($sql);
            
            foreach ($deportes as $idDeporte) {
                $stmt->bindParam(':idDeporte', $idDeporte, PDO::PARAM_INT);
                $stmt->bindParam(':idUsuario', $idUsuario, PDO::PARAM_INT);
                $stmt->execute();
            }
            
            return true;
        } catch (PDOException $e) {
            error_log("Error al inscribir deportes: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Consulta todos los usuarios con sus deportes (Proceso 4)
     * @return array Lista de usuarios con sus deportes asociados
     */
    public function consultarDeportesUsuarios() {
        // Query simplificada: JOIN entre las 3 tablas
        // Usuarios LEFT JOIN Usuarios_deportes para incluir usuarios sin deportes
        // Usuarios_deportes LEFT JOIN Deportes para obtener el nombre del deporte
        // GROUP_CONCAT agrupa múltiples deportes en un solo campo separado por comas
        $sql = "SELECT 
                    Usuarios.idUsuario, 
                    Usuarios.nombreUsuario, 
                    Usuarios.apeNombre, 
                    Usuarios.correo, 
                    Usuarios.telefono, 
                    Usuarios.perfil,
                    GROUP_CONCAT(Deportes.nombreDep ORDER BY Deportes.nombreDep SEPARATOR ', ') as deportes
                FROM Usuarios
                LEFT JOIN Usuarios_deportes ON Usuarios.idUsuario = Usuarios_deportes.idUsuario
                LEFT JOIN Deportes ON Usuarios_deportes.idDeporte = Deportes.idDeporte
                GROUP BY Usuarios.idUsuario, Usuarios.nombreUsuario, Usuarios.apeNombre, 
                         Usuarios.correo, Usuarios.telefono, Usuarios.perfil
                ORDER BY Usuarios.nombreUsuario";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    /**
     * Consulta el total de deportes que tienen alumnos inscritos (Proceso 5)
     * @return int Total de deportes con inscripciones
     */
    public function consultarTotalDeportes() {
        $sql = "SELECT COUNT(DISTINCT idDeporte) as total
                FROM Usuarios_deportes";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch();
        return $resultado['total'];
    }

    /**
     * Consulta cada deporte con el total de usuarios inscritos (Proceso 6)
     * @return array Lista de deportes con su total de usuarios
     */
    public function consultarDeportesConTotal() {
        // LEFT JOIN para incluir deportes sin usuarios
        // COUNT cuenta cuántos usuarios tiene cada deporte
        // GROUP BY agrupa por deporte para hacer el conteo
        $sql = "SELECT 
                    Deportes.nombreDep, 
                    COUNT(Usuarios_deportes.idUsuario) as totalUsuarios
                FROM Deportes
                LEFT JOIN Usuarios_deportes ON Deportes.idDeporte = Usuarios_deportes.idDeporte
                GROUP BY Deportes.idDeporte, Deportes.nombreDep
                ORDER BY Deportes.nombreDep";
        
        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>

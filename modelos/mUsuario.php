<?php
require_once 'mConexion.php';

class MUsuario extends Conexion {

    public function validarUsuario($usuario, $password){
        // Consulto si existe un usuario con ese nombre y contraseña
        $sql = "
            SELECT idUsuario, perfil 
            FROM Usuarios 
            WHERE nombreUsuario = :usuario AND password = :password";

        $sentencia = $this->conexion->prepare($sql);
        // Uso bindParam para evitar inyecciones SQL (es decir, que no me cuelen código malicioso)
        $sentencia->bindParam(':usuario', $usuario, PDO::PARAM_STR);
        $sentencia->bindParam(':password', $password, PDO::PARAM_STR);
        $sentencia->execute();
        $resultado = $sentencia->fetch();

        return $resultado;
    }

    public function existeUsuario($nombreUsuario){

        $sql = "
            SELECT COUNT(*) as total 
            FROM Usuarios 
            WHERE nombreUsuario = :nombreUsuario";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bindParam(':nombreUsuario', $nombreUsuario, PDO::PARAM_STR);
        $stmt->execute();
        $resultado = $stmt->fetch();
        // Devuelvo true si el contador es mayor que 0
        return $resultado['total'] > 0;
    }

    public function registrarUsuario($datos){

        try {
            // Inserto los datos básicos del usuario. El perfil 'u' lo pongo fijo.
            $sql = "
                INSERT INTO Usuarios (nombreUsuario, apeNombre, password, correo, telefono, perfil) 
                VALUES (:nombreUsuario, :apeNombre, :password, :correo, :telefono, 'u')";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bindParam(':nombreUsuario', $datos['nombreUsuario'], PDO::PARAM_STR);
            $stmt->bindParam(':apeNombre', $datos['apeNombre'], PDO::PARAM_STR);
            $stmt->bindParam(':password', $datos['password'], PDO::PARAM_STR);
            $stmt->bindParam(':correo', $datos['correo'], PDO::PARAM_STR);

            // Compruebo si el teléfono está vacío. Si lo está, guardo NULL en la BD
            $telefono = !empty($datos['telefono']) ? $datos['telefono'] : null;
            $stmt->bindParam(':telefono', $telefono, PDO::PARAM_STR);

            $stmt->execute();
            // Devuelvo el ID del nuevo usuario creado
            return $this->conexion->lastInsertId();
        } catch (PDOException $e) {
            error_log("Error al registrar usuario: " . $e->getMessage());
            return false;
        }
    }

    public function inscribirDeportes($idUsuario, $deportes){
        try {
            $sql = "
                INSERT INTO Usuarios_deportes (idDeporte, idUsuario) 
                VALUES (:idDeporte, :idUsuario)";
            $stmt = $this->conexion->prepare($sql);

            // Recorro la lista de deportes seleccionados y voy insertando uno a uno
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
     */
    public function consultarDeportesUsuarios()
    {
        // Uso una consulta compleja con JOINs para traer toda la info de golpe:
        // 1. LEFT JOIN 'Usuarios_deportes': para traer usuarios aunque NO tengan deportes
        // 2. LEFT JOIN 'Deportes': para saber el nombre del deporte
        // 3. GROUP_CONCAT: Me junta los nombres de los deportes en un solo texto separado por comas
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
     */
    public function consultarTotalDeportes()
    {
        // Cuento los ids de deportes distintos que hay en la tabla de inscripciones
        $sql = "SELECT COUNT(DISTINCT idDeporte) as total
                FROM Usuarios_deportes";

        $stmt = $this->conexion->prepare($sql);
        $stmt->execute();
        $resultado = $stmt->fetch();
        return $resultado['total'];
    }

    /**
     * Consulta cada deporte con el total de usuarios inscritos (Proceso 6)
     */
    public function consultarDeportesConTotal()
    {
        // Saco el nombre del deporte y cuento cuántos usuarios tiene asociados
        // Uso LEFT JOIN por si hay deportes sin ningún usuario, que salgan con 0
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
<?php
require_once __DIR__ . '/../config/configDB.php';

class Conexion {
    protected $conexion;

    public function __construct()
    {
        // Intentamos conectar con la base de datos usando PDO
        // PDO es una librería segura para conectar PHP con bases de datos
        $this->conexion = new PDO(
            "mysql:host=" . servidor .
            ";dbname=" . nombreBaseDatos . ";charset=UTF8",
            usuario,
            contraseña,
            [
                // Activamos el modo de errores para que nos avise si algo falla SQL
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,

                // Configuramos para que los resultados vengan como un array asociativo (clave => valor)
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,

                // Usamos las sentencias preparadas nativas para mayor seguridad
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
    }

    // Cuando la clase se destruye (se deja de usar), cerramos la conexión
    public function __destruct()
    {
        $this->conexion = null;
    }
}
?>
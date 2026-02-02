<?php
require_once 'modelos/mUsuario.php';

class CAdmin {
    
    public $vista;
    
    public function __construct() {
        $this->vista = '';
        
        // 1. Iniciar sesión solo si no está iniciada (Corrección del error duplicado)
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        
        // 2. Verificar permisos
        // Al quitar los espacios de la línea 1, este header() ya funcionará correctamente
        if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'c') {
            header('Location: index.php');
            exit;
        }
    }
    
    public function menu() {
        $this->vista = 'menuAdmin';
        // Verificamos que exista la variable de sesión antes de enviarla para evitar errores
        $nombre = isset($_SESSION['nombreUsuario']) ? $_SESSION['nombreUsuario'] : 'Usuario';
        return ['nombreUsuario' => $nombre];
    }
    
    public function deportesUsuarios() {
        $modeloUsuario = new MUsuario();
        $usuarios = $modeloUsuario->consultarDeportesUsuarios();
        
        $this->vista = 'deportesUsuarios';
        return ['usuarios' => $usuarios];
    }
    
    public function totalDeportes() {
        $modeloUsuario = new MUsuario();
        $total = $modeloUsuario->consultarTotalDeportes();
        
        $this->vista = 'totalDeportes';
        return ['total' => $total];
    }
    
    public function deportes() {
        $modeloUsuario = new MUsuario();
        $deportes = $modeloUsuario->consultarDeportesConTotal();
        
        $this->vista = 'deportes';
        return ['deportes' => $deportes];
    }
}
?>
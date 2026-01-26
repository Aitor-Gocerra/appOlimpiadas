<?php
require_once 'modelos/mUsuario.php';

class CAdmin {
    
    public $vista;
    
    public function __construct() {
        $this->vista = '';
        
        // Verificar que el usuario esté logueado y sea administrador
        session_start();
        if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'c') {
            header('Location: index.php');
            exit;
        }
    }
    
    /**
     * Muestra el menú de administrador
     */
    public function menu() {
        $this->vista = 'menuAdmin';
        return ['nombreUsuario' => $_SESSION['nombreUsuario']];
    }
    
    /**
     * Proceso 4: Muestra todos los usuarios con sus deportes
     */
    public function deportesUsuarios() {
        $modeloUsuario = new MUsuario();
        $usuarios = $modeloUsuario->consultarDeportesUsuarios();
        
        $this->vista = 'deportesUsuarios';
        return ['usuarios' => $usuarios];
    }
    
    /**
     * Proceso 5: Muestra el total de deportes con alumnos inscritos
     */
    public function totalDeportes() {
        $modeloUsuario = new MUsuario();
        $total = $modeloUsuario->consultarTotalDeportes();
        
        $this->vista = 'totalDeportes';
        return ['total' => $total];
    }
    
    /**
     * Proceso 6: Muestra cada deporte con el total de usuarios
     */
    public function deportes() {
        $modeloUsuario = new MUsuario();
        $deportes = $modeloUsuario->consultarDeportesConTotal();
        
        $this->vista = 'deportes';
        return ['deportes' => $deportes];
    }
}
?>

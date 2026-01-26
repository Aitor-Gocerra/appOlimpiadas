<?php
require_once 'modelos/mUsuario.php';

class CLogin {
    
    public $vista;
    
    public function __construct() {
        $this->vista = '';
    }
    
    /**
     * Muestra el formulario de login
     */
    public function mostrarFormulario() {
        $this->vista = 'login';
        return [];
    }
    
    /**
     * Procesa el inicio de sesión
     */
    public function procesarLogin($datos) {
        $mensaje = '';
        
        if (empty($datos['usuario']) || empty($datos['password'])) {
            $mensaje = 'Usuario y contraseña son obligatorios';
            $this->vista = 'login';
            return ['mensaje' => $mensaje];
        }
        
        $modeloUsuario = new MUsuario();
        $usuario = $modeloUsuario->validarUsuario($datos['usuario'], $datos['password']);
        
        if ($usuario) {
            // Iniciar sesión
            session_start();
            $_SESSION['idUsuario'] = $usuario['idUsuario'];
            $_SESSION['perfil'] = $usuario['perfil'];
            $_SESSION['nombreUsuario'] = $datos['usuario'];
            
            // Redirigir según perfil
            if ($usuario['perfil'] === 'c') {
                // Es coordinador/administrador
                header('Location: index.php?c=Admin&m=menu');
                exit;
            } else {
                // Es usuario normal
                $this->vista = 'loginExito';
                return ['nombreUsuario' => $datos['usuario']];
            }
        } else {
            $mensaje = 'Usuario o contraseña incorrectos';
            $this->vista = 'login';
            return ['mensaje' => $mensaje];
        }
    }
    
    /**
     * Cierra la sesión del usuario
     */
    public function cerrarSesion() {
        session_start();
        session_destroy();
        header('Location: index.php');
        exit;
    }
}
?>
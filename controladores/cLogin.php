<?php
    require_once 'modelos/mUsuario.php';

    class CLogin {
        
        public $vista;
        
        public function __construct() {
            $this->vista = '';
        }
        
        public function mostrarFormulario() {
            $this->vista = 'login';
            return [];
        }

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

                if ($usuario['perfil'] === 'c') {
                    $this->vista = 'menuAdmin'; 
                    return []; 
                } else {
                    // Caso: Usuario normal
                    $this->vista = 'loginExito';
                    return ['nombreUsuario' => $datos['usuario']];
                }
            } else {
                $mensaje = 'Usuario o contraseña incorrectos';
                $this->vista = 'login';
                return ['mensaje' => $mensaje];
            }
        }
        
        public function cerrarSesion() {
            session_start();
            session_destroy();
            $this->vista = 'login';
            return [];
        }
    }
?>
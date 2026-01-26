<?php
require_once 'modelos/mUsuario.php';
require_once 'modelos/mDeporte.php';

class CRegistro {
    
    public $vista;
    
    public function __construct() {
        $this->vista = '';
    }
    
    /**
     * Muestra el formulario de registro con los deportes disponibles
     */
    public function mostrarFormulario() {
        $modeloDeporte = new MDeporte();
        $deportes = $modeloDeporte->obtenerTodosDeportes();
        
        $this->vista = 'formularioRegistro';
        return ['deportes' => $deportes];
    }
    
    /**
     * Procesa el registro de un nuevo usuario
     */
    public function procesarRegistro($datos) {
        $mensaje = '';
        $tipo = 'error';
        
        // Validar que se aceptan las condiciones
        if (!isset($datos['condiciones'])) {
            $mensaje = 'Debe aceptar las condiciones';
            $this->vista = 'mensajeRegistro';
            return ['mensaje' => $mensaje, 'tipo' => $tipo];
        }
        
        // Validar campos obligatorios
        if (empty($datos['nombreUsuario']) || empty($datos['apeNombre']) || 
            empty($datos['password']) || empty($datos['correo'])) {
            $mensaje = 'Los campos Nombre usuario, Apellidos y Nombre, Contraseña y Correo son obligatorios';
            $this->vista = 'mensajeRegistro';
            return ['mensaje' => $mensaje, 'tipo' => $tipo];
        }
        
        // Validar que se seleccionó al menos un deporte
        if (!isset($datos['deportes']) || empty($datos['deportes'])) {
            $mensaje = 'Debe seleccionar al menos un deporte';
            $this->vista = 'mensajeRegistro';
            return ['mensaje' => $mensaje, 'tipo' => $tipo];
        }
        
        $modeloUsuario = new MUsuario();
        
        // Verificar que el usuario no existe
        if ($modeloUsuario->existeUsuario($datos['nombreUsuario'])) {
            $mensaje = 'El nombre de usuario ya existe';
            $this->vista = 'mensajeRegistro';
            return ['mensaje' => $mensaje, 'tipo' => $tipo];
        }
        
        // Registrar usuario
        $datosUsuario = [
            'nombreUsuario' => $datos['nombreUsuario'],
            'apeNombre' => $datos['apeNombre'],
            'password' => $datos['password'],
            'correo' => $datos['correo'],
            'telefono' => $datos['telefono'] ?? ''
        ];
        
        $idUsuario = $modeloUsuario->registrarUsuario($datosUsuario);
        
        if ($idUsuario) {
            // Inscribir deportes
            $deportes = $datos['deportes'];
            if ($modeloUsuario->inscribirDeportes($idUsuario, $deportes)) {
                $mensaje = 'Usuario añadido';
                $tipo = 'exito';
            } else {
                $mensaje = 'Error al inscribir deportes';
            }
        } else {
            $mensaje = 'Error al registrar usuario';
        }
        
        $this->vista = 'mensajeRegistro';
        return ['mensaje' => $mensaje, 'tipo' => $tipo];
    }
}
?>

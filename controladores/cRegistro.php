<?php
require_once 'modelos/mUsuario.php';
require_once 'modelos/mDeporte.php';

class CRegistro
{

    public $vista;

    public function __construct()
    {
        $this->vista = '';
    }

    public function mostrarFormulario(){
        // Necesito cargar los deportes para mostrarlos en el checkboxs del formulario
        $modeloDeporte = new MDeporte();
        $deportes = $modeloDeporte->obtenerTodosDeportes();

        $this->vista = 'formularioRegistro';
        return ['deportes' => $deportes];
    }

    public function procesarRegistro($datos){
        $mensaje = '';
        $tipo = 'error'; // Por defecto asumo que habrá un error hasta que demuestre lo contrario

        // Validar que se aceptan las condiciones (el checkbox)
        if (!isset($datos['condiciones'])) {
            $mensaje = 'Debe aceptar las condiciones';
            $this->vista = 'mensajeRegistro';
            return ['mensaje' => $mensaje, 'tipo' => $tipo];
        }

        // Validar campos obligatorios vacíos
        if (
            empty($datos['nombreUsuario']) || empty($datos['apeNombre']) ||
            empty($datos['password']) || empty($datos['correo'])
        ) {
            $mensaje = 'Los campos Nombre usuario, Apellidos y Nombre, Contraseña y Correo son obligatorios';
            $this->vista = 'mensajeRegistro';
            return ['mensaje' => $mensaje, 'tipo' => $tipo];
        }

        // Validar que al menos ha elegido un deporte
        if (!isset($datos['deportes']) || empty($datos['deportes'])) {
            $mensaje = 'Debe seleccionar al menos un deporte';
            $this->vista = 'mensajeRegistro';
            return ['mensaje' => $mensaje, 'tipo' => $tipo];
        }

        $modeloUsuario = new MUsuario();

        // Verificar que el usuario no existe ya en la BD
        if ($modeloUsuario->existeUsuario($datos['nombreUsuario'])) {
            $mensaje = 'El nombre de usuario ya existe';
            $this->vista = 'mensajeRegistro';
            return ['mensaje' => $mensaje, 'tipo' => $tipo];
        }

        // Preparo los datos para guardar
        $datosUsuario = [
            'nombreUsuario' => $datos['nombreUsuario'],
            'apeNombre' => $datos['apeNombre'],
            'password' => $datos['password'],
            'correo' => $datos['correo'],
            'telefono' => $datos['telefono'] ?? '' // Si no hay teléfono, pongo cadena vacía
        ];

        // Intento guardar al usuario
        $idUsuario = $modeloUsuario->registrarUsuario($datosUsuario);

        if ($idUsuario) {
            // Si el usuario se guardó bien, ahora guardo sus deportes uno a uno
            $deportes = $datos['deportes'];
            if ($modeloUsuario->inscribirDeportes($idUsuario, $deportes)) {
                $mensaje = 'Usuario añadido';
                $tipo = 'exito'; // ¡Todo salió bien!
            } else {
                $mensaje = 'Error al inscribir deportes';
            }
        } else {
            $mensaje = 'Error al registrar usuario';
        }

        $this->vista = 'mensajeRegistro';
        // Devuelvo el mensaje y el tipo (éxito/error) para usarlo en la vista (colores rojo/verde)
        return ['mensaje' => $mensaje, 'tipo' => $tipo];
    }
}
?>
<?php
require_once 'modelos/mDeporte.php';

class CDeportes
{

    public $vista;
    public $mensaje;

    public function __construct(){
        $this->vista = '';
        $this->mensaje = '';

        // Verificar que el usuario esté logueado y sea administrador
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'c') {
            header('Location: index.php');
            exit;
        }
    }

    public function gestionDeportes(){
        $modelo = new MDeporte();
        $deportes = $modelo->obtenerTodosDeportes();

        $this->vista = 'listaDeportes';
        return ['deportes' => $deportes];
    }

    public function vistaNuevo(){

        $this->vista = 'formDeporte';
        return ['titulo' => 'Añadir Deporte', 'accion' => 'nuevo'];
    }

    public function nuevo(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $nombre = $_POST['nombreDep'] ?? '';
            $imagen = null;

            // Manejo de la subida de imagen
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                $imagen = $this->subirImagen($_FILES['imagen']);
            }

            if ($nombre) {
                $modelo = new MDeporte();
                if ($modelo->insertarDeporte($nombre, $imagen)) {
                    header('Location: index.php?c=Deportes&m=gestionDeportes');
                    exit;
                } else {
                    $this->mensaje = "Error al insertar el deporte.";
                }
            } else {
                $this->mensaje = "El nombre es obligatorio.";
            }
        }

        // Si hubo error, volvemos a mostrar el formulario
        $this->vista = 'formDeporte';
        return ['titulo' => 'Añadir Deporte', 'accion' => 'nuevo', 'mensaje' => $this->mensaje];
    }

    public function vistaEditar(){

        $id = $_GET['id'] ?? null;

        if ($id) {
            $modelo = new MDeporte();
            $deporte = $modelo->obtenerDeporte($id);

            if ($deporte) {
                $this->vista = 'formDeporte';
                return ['titulo' => 'Editar Deporte', 'accion' => 'editar', 'deporte' => $deporte];
            }
        }

        header('Location: index.php?c=Deportes&m=gestionDeportes');
        exit;
    }

    public function editar(){

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['idDeporte'] ?? null;
            $nombre = $_POST['nombreDep'] ?? '';
            $imagenActual = $_POST['imagenActual'] ?? null;
            $imagen = $imagenActual;

            if ($id && $nombre) {
                // Manejo de la subida de nueva imagen
                if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                    // Si sube una nueva, intentamos borrar la anterior si existe
                    if ($imagenActual && file_exists($imagenActual)) {
                        unlink($imagenActual);
                    }
                    $imagen = $this->subirImagen($_FILES['imagen']);
                }

                $modelo = new MDeporte();
                if ($modelo->actualizarDeporte($id, $nombre, $imagen)) {
                    header('Location: index.php?c=Deportes&m=gestionDeportes');
                    exit;
                } else {
                    $this->mensaje = "Error al actualizar el deporte.";
                }
            } else {
                $this->mensaje = "Datos incompletos.";
            }
        }

        header('Location: index.php?c=Deportes&m=gestionDeportes');
        exit;
    }

    public function borrar(){

        $id = $_GET['id'] ?? null;

        if ($id) {
            $modelo = new MDeporte();
            // Obtener info para borrar imagen
            $deporte = $modelo->obtenerDeporte($id);

            if ($modelo->borrarDeporte($id)) {
                if ($deporte && $deporte['imagen'] && file_exists($deporte['imagen'])) {
                    unlink($deporte['imagen']);
                }
            }
        }

        header('Location: index.php?c=Deportes&m=gestionDeportes');
        exit;
    }

    private function subirImagen($archivo){

        $directorio = 'imagenes/deportes/';

        // Crear directorio si no existe
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $nombreArchivo = basename($archivo['name']);
        // Evitar duplicados o nombres peligrosos (sanitizacion para la entrada de datos en la BD)
        $nombreUnico = uniqid() . "_" . preg_replace("/[^a-zA-Z0-9\.]/", "", $nombreArchivo);
        $rutaDestino = $directorio . $nombreUnico;

        if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
            return $rutaDestino;
        }

        return null;
    }
}
?>
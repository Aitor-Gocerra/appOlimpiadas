<?php
require_once 'modelos/mDeporte.php';

class CDeportes
{

    public $vista;
    public $mensaje;

    public function __construct()
    {
        $this->vista = '';
        $this->mensaje = '';

        // Compruebo si la sesión ya está iniciada antes de intentar iniciarla
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Seguridad: Si no es coordinador ('c'), lo echo fuera
        if (!isset($_SESSION['perfil']) || $_SESSION['perfil'] !== 'c') {
            header('Location: index.php');
            exit;
        }
    }

    public function gestionDeportes()
    {
        $modelo = new MDeporte();
        $deportes = $modelo->obtenerTodosDeportes();

        $this->vista = 'listaDeportes';
        return ['deportes' => $deportes];
    }

    public function vistaNuevo()
    {
        $this->vista = 'formDeporte';
        return ['titulo' => 'Añadir Deporte', 'accion' => 'nuevo'];
    }

    public function nuevo()
    {

        // Verifico que me están enviando datos por POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Uso el operador ternario '??' para decir: "si no existe, pon cadena vacía"
            $nombre = $_POST['nombreDep'] ?? '';
            $imagen = null;

            // Compruebo si me han subido una imagen sin errores
            if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {
                // Si está todo OK, proceso la imagen con mi función auxiliar
                $imagen = $this->subirImagen($_FILES['imagen']);
            }

            if ($nombre) {
                $modelo = new MDeporte();
                if ($modelo->insertarDeporte($nombre, $imagen)) {
                    // Si se inserta bien, vuelvo a la lista
                    header('Location: index.php?c=Deportes&m=gestionDeportes');
                    exit;
                } else {
                    $this->mensaje = "Error al insertar el deporte.";
                }
            } else {
                $this->mensaje = "El nombre es obligatorio.";
            }
        }

        // Si llego aquí es que hubo un error, vuelvo a mostrar el formulario
        $this->vista = 'formDeporte';
        return ['titulo' => 'Añadir Deporte', 'accion' => 'nuevo', 'mensaje' => $this->mensaje];
    }

    public function vistaEditar()
    {

        $id = $_GET['id'] ?? null;

        if ($id) {
            $modelo = new MDeporte();
            $deporte = $modelo->obtenerDeporte($id);

            if ($deporte) {
                $this->vista = 'formDeporte';
                return ['titulo' => 'Editar Deporte', 'accion' => 'editar', 'deporte' => $deporte];
            }
        }

        // Si no encuentro el deporte, redirecciono
        header('Location: index.php?c=Deportes&m=gestionDeportes');
        exit;
    }

    public function editar()
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['idDeporte'] ?? null;
            $nombre = $_POST['nombreDep'] ?? '';
            $imagenActual = $_POST['imagenActual'] ?? null;
            $imagen = $imagenActual; // Por defecto mantenemos la imagen que ya tenía

            if ($id && $nombre) {
                // Si me suben una nueva imagen
                if (isset($_FILES['imagen']) && $_FILES['imagen']['error'] === UPLOAD_ERR_OK) {

                    // Borro la imagen vieja del servidor para no acumular basura
                    if ($imagenActual && file_exists($imagenActual)) {
                        unlink($imagenActual);
                    }
                    // Y subo la nueva
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

    public function borrar()
    {

        $id = $_GET['id'] ?? null;

        if ($id) {
            $modelo = new MDeporte();
            // Primero busco el deporte para saber qué imagen tiene y borrarla
            $deporte = $modelo->obtenerDeporte($id);

            if ($modelo->borrarDeporte($id)) {
                // Si se borra de la BD, borro también el archivo de imagen
                if ($deporte && $deporte['imagen'] && file_exists($deporte['imagen'])) {
                    unlink($deporte['imagen']);
                }
            }
        }

        header('Location: index.php?c=Deportes&m=gestionDeportes');
        exit;
    }

    // Función auxiliar privada para no repetir código de subida
    private function subirImagen($archivo)
    {

        $directorio = 'imagenes/deportes/';

        // Creo la carpeta si no existe
        if (!file_exists($directorio)) {
            mkdir($directorio, 0777, true);
        }

        $nombreArchivo = basename($archivo['name']);
        // Genero un nombre único (uniqid) mezclado con el original limpio para que no se sobrescriban
        $nombreUnico = uniqid() . "_" . preg_replace("/[^a-zA-Z0-9\.]/", "", $nombreArchivo);
        $rutaDestino = $directorio . $nombreUnico;

        // Muevo el archivo temporal a mi carpeta definitiva
        if (move_uploaded_file($archivo['tmp_name'], $rutaDestino)) {
            return $rutaDestino;
        }

        return null;
    }
}
?>
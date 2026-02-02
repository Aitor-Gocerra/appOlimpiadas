<?php
require_once 'config/config.php';

if (!isset($_GET['c']))
    $_GET['c'] = DEF_CONTROLLER;
if (!isset($_GET['m']))
    $_GET['m'] = DEF_METHOD;

$nombreControlador = $_GET['c'];
$nombreMetodo = $_GET['m'];

$rutaArchivoControlador = RUTA_CONTROLADORES . $nombreControlador . '.php';

if (file_exists($rutaArchivoControlador)) {
    require_once $rutaArchivoControlador;

    $nombreClase = 'C' . $nombreControlador;

    if (class_exists($nombreClase)) {
        $objControlador = new $nombreClase();

        if (method_exists($objControlador, $nombreMetodo)) {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $datos = $objControlador->{$nombreMetodo}($_POST);
            } else {
                $datos = $objControlador->{$nombreMetodo}();
            }
        }

        if ($objControlador->vista != '') {
            $rutaVista = RUTA_VISTAS . $objControlador->vista . '.php';

            if (is_array($datos))
                extract($datos);

            if (file_exists($rutaVista)) {
                require_once $rutaVista;
            }
        }
    }
}
?>
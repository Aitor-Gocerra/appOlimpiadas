<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body>
    <div class="contenedor">
        <h1>Login (Inyección SQL habilitada)</h1>

        <form action="index.php?c=Login&m=login" method="POST">
            <label>Usuario:</label>
            <input type="text" name="usuario" required>
            <br>
            <label>Contraseña:</label>
            <input type="password" name="password" required>
            <br>
            <button type="submit">Entrar</button>
        </form>
    </div>
</body>

</html>
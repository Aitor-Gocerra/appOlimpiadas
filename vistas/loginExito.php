<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Exitoso</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="centered">
    <div class="card shadow text-center" style="max-width: 500px; width: 100%;">
        <div class="card-body p-5">
            <div class="mb-3"><i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i></div>
            <h1 class="text-success mb-3">Bienvenido</h1>
            <p class="fs-5 mb-4">Has iniciado sesión correctamente, <strong><?= htmlspecialchars($nombreUsuario) ?></strong></p>
            
            <a href="index.php" class="btn btn-primary">Volver al inicio</a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

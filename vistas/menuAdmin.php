<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Administrador</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body class="centered">
    <div class="card shadow" style="max-width: 600px; width: 100%;">
        <div class="card-header bg-primary text-white text-center">
            <h1 class="h4 mb-0"><i class="bi bi-person-badge-fill"></i> Panel de Administrador</h1>
            <p class="mb-0 mt-1">Bienvenido, <strong><?= htmlspecialchars($nombreUsuario) ?></strong></p>
        </div>
        <div class="card-body p-4">
            <div class="d-grid gap-2">
                <a href="index.php?c=Admin&m=deportesUsuarios" class="btn btn-outline-primary">
                    <i class="bi bi-bar-chart-fill"></i> Deportes_Usuarios
                </a>

                <a href="index.php?c=Admin&m=totalDeportes" class="btn btn-outline-primary">
                    <i class="bi bi-graph-up"></i> Total_Deportes
                </a>

                <a href="index.php?c=Admin&m=deportes" class="btn btn-outline-primary">
                    <i class="bi bi-trophy-fill"></i> Deportes
                </a>

                <a href="index.php?c=Deportes&m=gestionDeportes" class="btn btn-outline-success">
                    <i class="bi bi-gear-fill"></i> Gestión Deportes (CRUD)
                </a>
            </div>
        </div>
        <div class="card-footer text-center">
            <a href="index.php?c=Login&m=cerrarSesion" class="btn btn-danger">
                <i class="bi bi-door-open-fill"></i> Cerrar sesión
            </a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
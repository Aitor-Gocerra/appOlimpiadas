<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Resultado</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="centered">
    <div class="card shadow text-center" style="max-width: 500px; width: 100%;">
        <div class="card-body p-4">
            <div class="alert alert-<?= $tipo === 'exito' ? 'success' : 'danger' ?> mb-4" role="alert">
                <strong><?= htmlspecialchars($mensaje) ?></strong>
            </div>
            
            <a href="index.php" class="btn btn-primary">Volver</a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

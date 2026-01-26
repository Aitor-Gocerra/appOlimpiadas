<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Total de Deportes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="centered">
    <div class="card shadow text-center" style="max-width: 600px; width: 100%;">
        <div class="card-header bg-primary text-white">
            <h1 class="h4 mb-0"><i class="bi bi-calculator-fill"></i> Total de Deportes</h1>
        </div>
        <div class="card-body p-5">
            <div class="total-box">
                <div class="total-label">Deportes con alumnos inscritos:</div>
                <div class="total-number"><?= htmlspecialchars($total) ?></div>
            </div>
        </div>
        <div class="card-footer">
            <a href="index.php?c=Admin&m=menu" class="btn btn-primary">Volver</a>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

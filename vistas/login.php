<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="centered">
    <div class="card shadow" style="max-width: 450px; width: 100%;">
        <div class="card-body p-4">
            <h1 class="card-title text-center text-primary mb-2"><i class="bi bi-lock-fill"></i> Inicio de Sesión</h1>
            <p class="text-center text-muted mb-4">Accede con tus credenciales</p>
            
            <?php if (isset($mensaje) && !empty($mensaje)): ?>
            <div class="alert alert-danger" role="alert">
                <?= htmlspecialchars($mensaje) ?>
            </div>
            <?php endif; ?>
            
            <form action="index.php?c=Login&m=procesarLogin" method="POST">
                <div class="mb-3">
                    <label for="usuario" class="form-label">Usuario:</label>
                    <input type="text" class="form-control" id="usuario" name="usuario" required>
                </div>
                
                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña:</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                </div>
            </form>
            
            <div class="text-center mt-3">
                <a href="index.php" class="text-decoration-none">← Volver al inicio</a>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
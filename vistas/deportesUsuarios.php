<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deportes y Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>
<body class="scrollable">
    <div class="container-fluid" style="max-width: 1400px;">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h1 class="h4 mb-0"><i class="bi bi-table"></i> Deportes y Usuarios</h1>
            </div>
            <div class="card-body">
                <?php if (count($usuarios) > 0): ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Usuario</th>
                                <th>Apellidos y Nombre</th>
                                <th>Correo</th>
                                <th>Teléfono</th>
                                <th>Perfil</th>
                                <th>Deportes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?= htmlspecialchars($usuario['idUsuario']) ?></td>
                                <td><?= htmlspecialchars($usuario['nombreUsuario']) ?></td>
                                <td><?= htmlspecialchars($usuario['apeNombre']) ?></td>
                                <td><?= htmlspecialchars($usuario['correo']) ?></td>
                                <td><?= $usuario['telefono'] ? htmlspecialchars($usuario['telefono']) : '-' ?></td>
                                <td>
                                    <?php if ($usuario['perfil'] === 'c'): ?>
                                        <span class="badge bg-warning text-dark">Coordinador</span>
                                    <?php else: ?>
                                        <span class="badge bg-success">Usuario</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= $usuario['deportes'] ? htmlspecialchars($usuario['deportes']) : '-' ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php else: ?>
                <p class="text-center text-muted py-5">No hay usuarios registrados</p>
                <?php endif; ?>
            </div>
            <div class="card-footer text-center">
                <a href="index.php?c=Admin&m=menu" class="btn btn-primary">Volver</a>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

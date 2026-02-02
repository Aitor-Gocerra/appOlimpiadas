<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Deportes - Olimpiadas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body>
    <div class="container mt-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Gestión de Deportes</h1>
            <div>
                <a href="index.php?c=Deportes&m=vistaNuevo" class="btn btn-success"><i class="bi bi-plus-circle"></i>
                    Nuevo Deporte</a>
                <a href="index.php?c=Admin&m=menu" class="btn btn-secondary"><i class="bi bi-arrow-left"></i> Volver</a>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover align-middle">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Imagen</th>
                                <th>Nombre</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($deportes)): ?>
                                <tr>
                                    <td colspan="4" class="text-center">No hay deportes registrados</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($deportes as $deporte): ?>
                                    <tr>
                                        <td>
                                            <?= $deporte['idDeporte'] ?>
                                        </td>
                                        <td>
                                            <?php if (!empty($deporte['imagen'])): ?>
                                                <img src="<?= $deporte['imagen'] ?>"
                                                    alt="<?= htmlspecialchars($deporte['nombreDep']) ?>"
                                                    class="rounded sport-thumbnail">
                                            <?php else: ?>
                                                <span class="text-muted"><i class="bi bi-image"></i> Sin imagen</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?= htmlspecialchars($deporte['nombreDep']) ?>
                                        </td>
                                        <td>
                                            <a href="index.php?c=Deportes&m=vistaEditar&id=<?= $deporte['idDeporte'] ?>"
                                                class="btn btn-sm btn-primary"><i class="bi bi-pencil"></i></a>
                                            <a href="index.php?c=Deportes&m=borrar&id=<?= $deporte['idDeporte'] ?>"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('¿Estás seguro de borrar este deporte?');"><i
                                                    class="bi bi-trash"></i></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
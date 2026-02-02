<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>
        <?= $titulo ?> - Olimpiadas
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
</head>

<body>
    <div class="container mt-5" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-header bg-primary text-white">
                <h3 class="card-title mb-0">
                    <?= $titulo ?>
                </h3>
            </div>
            <div class="card-body">
                <?php if (isset($mensaje) && $mensaje): ?>
                    <div class="alert alert-danger">
                        <?= $mensaje ?>
                    </div>
                <?php endif; ?>

                <form action="index.php?c=Deportes&m=<?= $accion ?>" method="POST" enctype="multipart/form-data">
                    <?php if (isset($deporte)): ?>
                        <input type="hidden" name="idDeporte" value="<?= $deporte['idDeporte'] ?>">
                        <input type="hidden" name="imagenActual" value="<?= htmlspecialchars($deporte['imagen'] ?? '') ?>">
                    <?php endif; ?>

                    <div class="mb-3">
                        <label for="nombreDep" class="form-label">Nombre del Deporte:</label>
                        <input type="text" class="form-control" id="nombreDep" name="nombreDep"
                            value="<?= isset($deporte) ? htmlspecialchars($deporte['nombreDep']) : '' ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="imagen" class="form-label">Imagen:</label>
                        <input type="file" class="form-control" id="imagen" name="imagen" accept="image/*">
                        <?php if (isset($deporte) && !empty($deporte['imagen'])): ?>
                            <div class="mt-2">
                                <p>Imagen actual:</p>
                                <img src="<?= $deporte['imagen'] ?>" alt="Imagen actual"
                                    class="img-thumbnail sport-preview">
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="index.php?c=Deportes&m=gestionDeportes" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
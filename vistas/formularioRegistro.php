<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Olimpiadas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/estilos.css">
</head>

<body class="scrollable">
    <div class="container" style="max-width: 600px;">
        <div class="card shadow">
            <div class="card-body p-4">
                <h1 class="card-title text-center text-primary mb-2"><i class="bi bi-pencil-square"></i> Inscripción
                </h1>
                <p class="text-center text-muted mb-4">Completa el formulario para inscribirte</p>

                <form action="index.php?c=Registro&m=procesarRegistro" method="POST">
                    <div class="mb-3">
                        <label for="nombreUsuario" class="form-label">Nombre usuario: <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="nombreUsuario" name="nombreUsuario" required>
                        <div class="form-text">(no se puede repetir)</div>
                    </div>

                    <div class="mb-3">
                        <label for="apeNombre" class="form-label">Apellidos y Nombre: <span
                                class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="apeNombre" name="apeNombre" required>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña: <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo: <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="correo" name="correo" required>
                    </div>

                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono:</label>
                        <input type="tel" class="form-control" id="telefono" name="telefono" pattern="[0-9]{9}"
                            maxlength="9">
                        <div class="form-text">(si no se rellena se guarda el valor null)</div>
                    </div>

                    <div class="card bg-light mb-3">
                        <div class="card-body">
                            <label class="form-label fw-bold">Deportes: <span class="text-danger">*</span></label>
                            <div class="form-text mb-2">(un alumno puede inscribirse en más de un deporte)</div>

                            <?php foreach ($deportes as $deporte): ?>
                                <div class="form-check d-flex align-items-center mb-2">
                                    <input class="form-check-input me-2" type="checkbox"
                                        id="deporte<?= $deporte['idDeporte'] ?>" name="deportes[]"
                                        value="<?= $deporte['idDeporte'] ?>">
                                    <?php if (!empty($deporte['imagen'])): ?>
                                        <img src="<?= $deporte['imagen'] ?>"
                                            alt="<?= htmlspecialchars($deporte['nombreDep']) ?>"
                                            class="rounded me-2 sport-icon-small">
                                    <?php endif; ?>
                                    <label class="form-check-label" for="deporte<?= $deporte['idDeporte'] ?>">
                                        <?= htmlspecialchars($deporte['nombreDep']) ?>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>

                    <div class="card bg-warning bg-opacity-25 border-warning mb-3">
                        <div class="card-body">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="condiciones" name="condiciones"
                                    value="1" required>
                                <label class="form-check-label" for="condiciones">
                                    Acepto las condiciones <span class="text-danger">**</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary btn-lg">ENVIAR</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
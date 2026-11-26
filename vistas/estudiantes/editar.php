<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar estudiante</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>

<body>
    <h1>Editar estudiante</h1>
    <p><a href="estudiantes.php">Volver a estudiantes</a></p>

    <form action="estudiantes.php" method="post">
        <input type="hidden" name="accion" value="guardar">
        <input type="hidden" name="id" value="<?= (int) $estudiante['id'] ?>">
        <p>
            <label for="cedula">Cédula</label><br>
            <input id="cedula" name="cedula" maxlength="10" required
                value="<?= htmlspecialchars($estudiante['cedula']) ?>">
        </p>
        <p>
            <label for="nombres">Nombres</label><br>
            <input id="nombres" name="nombres" maxlength="100" required
                value="<?= htmlspecialchars($estudiante['nombres']) ?>">
        </p>
        <p>
            <label for="carrera">Carrera</label><br>
            <input id="carrera" name="carrera" maxlength="100" required
                value="<?= htmlspecialchars($estudiante['carrera']) ?>">
        </p>
        <button type="submit">Actualizar</button>
    </form>
</body>

</html>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Estudiantes</title>
</head>

<body>
    <h1>Estudiantes</h1>
    <p><a href="../index.php">Inicio</a></p>

    <?php if ($mensaje !== '') { ?>
        <p><?= htmlspecialchars($mensaje) ?></p>
    <?php } ?>

    <?php if ($error !== '') { ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php } ?>

    <h2>Registrar estudiante</h2>
    <form action="estudiantes.php" method="post">
        <input type="hidden" name="accion" value="guardar">
        <input type="hidden" name="id" value="0">
        <p>
            <label for="cedula">Cédula</label><br>
            <input id="cedula" name="cedula" maxlength="10" required>
        </p>
        <p>
            <label for="nombres">Nombres</label><br>
            <input id="nombres" name="nombres" maxlength="100" required>
        </p>
        <p>
            <label for="carrera">Carrera</label><br>
            <input id="carrera" name="carrera" maxlength="100" required>
        </p>
        <button type="submit">Registrar</button>
    </form>

    <h2>Lista de estudiantes</h2>
    <table border="1" >
        <thead>
            <tr>
                <th>ID</th>
                <th>Cédula</th>
                <th>Nombres</th>
                <th>Carrera</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($estudiantes as $fila): ?>
                <tr>
                    <td><?= (int) $fila['id'] ?></td>
                    <td><?= htmlspecialchars($fila['cedula']) ?></td>
                    <td><?= htmlspecialchars($fila['nombres']) ?></td>
                    <td><?= htmlspecialchars($fila['carrera']) ?></td>
                    <td><?= htmlspecialchars($fila['estado']) ?></td>
                    <td>
                        <a href="estudiantes.php?id=<?= (int) $fila['id'] ?>">Editar</a>
                        <?php if ($fila['estado'] === 'ACTIVO') { ?>
                            <form action="estudiantes.php" method="post">
                                <input type="hidden" name="accion" value="desactivar">
                                <input type="hidden" name="id" value="<?= (int) $fila['id'] ?>">
                                <button type="submit">Desactivar</button>
                            </form>
                        <?php } ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>

</html>

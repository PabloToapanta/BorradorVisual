<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar tarjeta RFID</title>
</head>

<body>
    <h1>Editar tarjeta RFID</h1>
    <p><a href="tarjetas.php">Volver a tarjetas</a></p>

    <form action="tarjetas.php" method="post">
        <input type="hidden" name="accion" value="guardar">
        <input type="hidden" name="id" value="<?= (int) $tarjeta['id'] ?>">
        <p>
            <label for="codigo_rfid">Código RFID</label><br>
            <input id="codigo_rfid" name="codigo_rfid" maxlength="32" required
                value="<?= htmlspecialchars($tarjeta['codigo_rfid']) ?>">
        </p>
        <p>
            <label for="id_estudiante">Estudiante</label><br>
            <select id="id_estudiante" name="id_estudiante" required>
                <?php foreach ($estudiantes as $estudiante): ?>
                    <option value="<?= (int) $estudiante['id'] ?>"
                        <?php if ((int) $estudiante['id'] === (int) $tarjeta['id_estudiante']) { ?>selected<?php } ?>>
                        <?= htmlspecialchars($estudiante['cedula'] . ' - ' . $estudiante['nombres']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="estado">Estado</label><br>
            <select id="estado" name="estado">
                <option value="ACTIVO" <?php if ($tarjeta['estado'] === 'ACTIVO') { ?>selected<?php } ?>>ACTIVO</option>
                <option value="INACTIVO" <?php if ($tarjeta['estado'] === 'INACTIVO') { ?>selected<?php } ?>>INACTIVO</option>
            </select>
        </p>
        <button type="submit">Actualizar</button>
    </form>
</body>

</html>

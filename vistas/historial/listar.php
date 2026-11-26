<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Historial de accesos</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>

<body>
    <h1>Historial de accesos</h1>
    <p><a href="administradores.php">Volver al panel de administrador</a></p>

    <form action="historial.php" method="get">
        <p>
            <label for="fecha_inicio">Fecha inicial</label><br>
            <input type="date" id="fecha_inicio" name="fecha_inicio" value="<?= htmlspecialchars($fechaInicio) ?>">
        </p>
        <p>
            <label for="fecha_fin">Fecha final</label><br>
            <input type="date" id="fecha_fin" name="fecha_fin" value="<?= htmlspecialchars($fechaFin) ?>">
        </p>
        <p>
            <label for="id_estudiante">Estudiante</label><br>
            <select id="id_estudiante" name="id_estudiante">
                <option value="0">Todos</option>
                <?php foreach ($estudiantes as $fila): ?>
                    <option value="<?= (int) $fila['id'] ?>" <?php if ((int) $fila['id'] === $idEstudiante) { ?>selected<?php } ?>>
                        <?= htmlspecialchars($fila['nombres']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <button type="submit">Filtrar</button>
        <a href="historial.php">Limpiar</a>
    </form>

    <p>
        <a href="reportes.php?fecha_inicio=<?= urlencode($fechaInicio) ?>&amp;fecha_fin=<?= urlencode($fechaFin) ?>&amp;id_estudiante=<?= $idEstudiante ?>">Generar PDF con estos filtros</a>
    </p>

    <p>
        <label for="buscarAcceso">Buscar en los accesos mostrados</label><br>
        <input type="text" id="buscarAcceso" placeholder="Fecha, código, estudiante o resultado">
    </p>

    <table border="1" id="tablaAccesos">
        <thead>
            <tr>
                <th>Fecha y hora</th>
                <th>Código leído</th>
                <th>Estudiante</th>
                <th>Resultado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($accesos as $fila): ?>
                <tr>
                    <td><?= htmlspecialchars($fila['fecha_hora']) ?></td>
                    <td><?= htmlspecialchars($fila['codigo_leido']) ?></td>
                    <td><?= htmlspecialchars($fila['estudiante'] ?? 'No registrado') ?></td>
                    <td><?= htmlspecialchars($fila['resultado']) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script src="../assets/js/jquery.min.js"></script>
    <script src="../assets/js/accesos.js"></script>
</body>

</html>

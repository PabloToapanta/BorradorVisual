<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Tarjetas RFID</title>
</head>

<body>
    <h1>Tarjetas RFID</h1>
    <p><a href="../index.php">Inicio</a></p>

    <?php if ($mensaje !== '') { ?>
        <p><?= htmlspecialchars($mensaje) ?></p>
    <?php } ?>

    <?php if ($error !== '') { ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php } ?>

    <h2>Asignar tarjeta</h2>
    <form action="tarjetas.php" method="post">
        <input type="hidden" name="accion" value="guardar">
        <input type="hidden" name="id" value="0">
        <p>
            <label for="codigo_rfid">Código RFID</label><br>
            <input id="codigo_rfid" name="codigo_rfid" maxlength="32" required>
        </p>
        <p>
            <label for="id_estudiante">Estudiante</label><br>
            <select id="id_estudiante" name="id_estudiante" required>
                <option value="">Seleccione un estudiante</option>
                <?php foreach ($estudiantes as $estudiante): ?>
                    <option value="<?= (int) $estudiante['id'] ?>">
                        <?= htmlspecialchars($estudiante['cedula'] . ' - ' . $estudiante['nombres']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </p>
        <p>
            <label for="estado">Estado</label><br>
            <select id="estado" name="estado">
                <option value="ACTIVO">ACTIVO</option>
                <option value="INACTIVO">INACTIVO</option>
            </select>
        </p>
        <button type="submit">Asignar</button>
    </form>

    <h2>Lista de tarjetas</h2>

    <p>
        <input type="text" id="buscador" placeholder="Buscar por código o estudiante...">
        <select id="filtroEstado">
            <option value="">Todos</option>
            <option value="ACTIVO">ACTIVO</option>
            <option value="INACTIVO">INACTIVO</option>
        </select>
    </p>

    <table border="1" id="tablaTarjetas">
    <thead>
        <tr>
            <th>ID</th>
            <th>Código RFID</th>
            <th>Estudiante</th>
            <th>Estado</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
            <?php foreach ($tarjetas as $fila): ?>
                <tr>
                    <td><?= (int) $fila['id'] ?></td>
                    <td><?= htmlspecialchars($fila['codigo_rfid']) ?></td>
                    <td><?= htmlspecialchars($fila['estudiante']) ?></td>
                    <td><?= htmlspecialchars($fila['estado']) ?></td>
                    <td>
                        <a href="tarjetas.php?id=<?= (int) $fila['id'] ?>">Editar</a>
                        <?php if ($fila['estado'] === 'ACTIVO') { ?>
                            <form action="tarjetas.php" method="post">
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
    
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        $(document).ready(function () {

            // Filtra por texto y por estado al mismo tiempo
            function filtrarTabla() {
                var texto = $("#buscador").val().toLowerCase();
                var estado = $("#filtroEstado").val();

                $("#tablaTarjetas tbody tr").each(function () {
                    var fila = $(this);
                    var datos = fila.find("td:eq(1), td:eq(2)").text().toLowerCase();
                    var estadoFila = fila.find("td:eq(3)").text().trim();

                    var coincideTexto = datos.indexOf(texto) > -1;
                    var coincideEstado = estado === "" || estadoFila === estado;

                    fila.toggle(coincideTexto && coincideEstado);
                });
            }

            $("#buscador").on("keyup", filtrarTabla);
            $("#filtroEstado").on("change", filtrarTabla);

            // Resalta la fila al hacer clic
            $("#tablaTarjetas tbody").on("click", "tr", function () {
                $(this).css("background-color", "#dbeafe")
                       .siblings().css("background-color", "");
            });
        });
    </script>
</body>

</html>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Lectura RFID</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>

<body>
<img src="../images/banner-uta.png" alt="Banner de la Universidad Técnica de Ambato" width="100%">    <h1>Lectura RFID</h1>
    <p><a href="../index.php">Inicio</a></p>

    <form action="accesos.php" method="post">
        <input type="hidden" name="accion" value="leer">
        <p>
            <label for="codigo_rfid">Código RFID</label><br>
            <input id="codigo_rfid" name="codigo_rfid" maxlength="32" required autofocus>
        </p>
        <button type="submit">Leer</button>
    </form>

    <?php if ($resultado !== '') { ?>
        <h2>Acceso <?= htmlspecialchars($resultado) ?></h2>
    <?php } ?>

    <?php if ($estudiante !== null) { ?>
        <p>Estudiante: <?= htmlspecialchars($estudiante['nombres']) ?></p>
        <p>Carrera: <?= htmlspecialchars($estudiante['carrera']) ?></p>
    <?php } ?>
</body>

</html>

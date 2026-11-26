<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Iniciar sesión</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>

<body>
    <img src="../images/banner-uta.png" alt="Banner de la Universidad Técnica de Ambato">
    <h1>Iniciar sesión de administrador</h1>
    <p><a href="../index.php">Inicio</a></p>

    <?php if ($error !== '') { ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php } ?>

    <form action="administradores.php" method="post">
        <input type="hidden" name="accion" value="entrar">
        <p>
            <label for="usuario">Usuario</label><br>
            <input id="usuario" name="usuario" maxlength="50" required>
        </p>
        <p>
            <label for="clave">Clave</label><br>
            <input id="clave" name="clave" type="password" required>
        </p>
        <button type="submit">Ingresar</button>
    </form>
</body>

</html>

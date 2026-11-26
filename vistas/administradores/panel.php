<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Panel de administrador</title>
    <link rel="stylesheet" href="../assets/css/estilos.css">
</head>

<body>
    <h1>Panel de administrador</h1>
    <p><a href="estudiantes.php">Estudiantes</a></p>
    <p><a href="tarjetas.php">Tarjetas RFID</a></p>
    <p><a href="historial.php">Historial de accesos</a></p>
    <form action="administradores.php" method="post">
        <input type="hidden" name="accion" value="salir">
        <button type="submit">Cerrar sesión</button>
    </form>
</body>

</html>

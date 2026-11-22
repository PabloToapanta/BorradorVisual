<?php

require_once __DIR__ . '/../modelos/TarjetaModelo.php';
require_once __DIR__ . '/../modelos/EstudianteModelo.php';

$modelo = new TarjetaModelo();
$accion = $_POST['accion'] ?? '';

if ($accion === 'guardar') {
    $id = (int) ($_POST['id'] ?? 0);
    $codigoRfid = trim($_POST['codigo_rfid'] ?? '');
    $idEstudiante = (int) ($_POST['id_estudiante'] ?? 0);
    $estado = $_POST['estado'] ?? 'ACTIVO';

    if ($id === 0) {
        $modelo->registrar($codigoRfid, $idEstudiante, $estado);
        header('Location: tarjetas.php?mensaje=registrada');
    } else {
        $modelo->actualizar($id, $codigoRfid, $idEstudiante, $estado);
        header('Location: tarjetas.php?mensaje=actualizada');
    }
    exit;
}

if ($accion === 'desactivar') {
    $id = (int) ($_POST['id'] ?? 0);
    $modelo->desactivar($id);
    header('Location: tarjetas.php?mensaje=desactivada');
    exit;
}

$mensajes = [
    'registrada' => 'Tarjeta asignada.',
    'actualizada' => 'Tarjeta actualizada.',
    'desactivada' => 'Tarjeta desactivada.',
];
$mensaje = $mensajes[$_GET['mensaje'] ?? ''] ?? '';
$error = '';

$modeloEstudiante = new EstudianteModelo();
$resultadoEstudiantes = $modeloEstudiante->listar(0);
$estudiantes = [];
while ($fila = $resultadoEstudiantes->fetch_assoc()) {
    $estudiantes[] = $fila;
}

$id = (int) ($_GET['id'] ?? 0);
if ($id > 0) {
    $resultado = $modelo->listar($id);
    $tarjeta = $resultado->fetch_assoc();
    if ($tarjeta !== null) {
        require __DIR__ . '/../vistas/tarjetas/editar.php';
        exit;
    }
    $error = 'No se encontró la tarjeta.';
}

$resultado = $modelo->listar(0);
$tarjetas = [];
while ($fila = $resultado->fetch_assoc()) {
    $tarjetas[] = $fila;
}

require __DIR__ . '/../vistas/tarjetas/listar.php';

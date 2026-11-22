<?php

// Solo un administrador con sesión iniciada puede usar este módulo.
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: administradores.php');
    exit;
}

require_once __DIR__ . '/../modelos/TarjetaModelo.php';
require_once __DIR__ . '/../modelos/EstudianteModelo.php';

// El modelo realiza las consultas a la tabla tarjeta.
$modelo = new TarjetaModelo();
$accion = $_POST['accion'] ?? '';

// El formulario usa la misma acción para asignar (ID 0) o actualizar.
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

// Desactivar cambia el estado de la tarjeta sin borrarla.
if ($accion === 'desactivar') {
    $id = (int) ($_POST['id'] ?? 0);
    $modelo->desactivar($id);
    header('Location: tarjetas.php?mensaje=desactivada');
    exit;
}

// Después de guardar, el mensaje llega por GET para mostrarlo en la vista.
$mensajes = [
    'registrada' => 'Tarjeta asignada.',
    'actualizada' => 'Tarjeta actualizada.',
    'desactivada' => 'Tarjeta desactivada.',
];
$mensaje = $mensajes[$_GET['mensaje'] ?? ''] ?? '';
$error = '';

// Los estudiantes llenan el selector de los formularios de tarjetas.
$modeloEstudiante = new EstudianteModelo();
$resultadoEstudiantes = $modeloEstudiante->listar(0);
$estudiantes = [];
while ($fila = $resultadoEstudiantes->fetch_assoc()) {
    $estudiantes[] = $fila;
}

$id = (int) ($_GET['id'] ?? 0);
// Un ID en la URL abre el formulario de edición de esa tarjeta.
if ($id > 0) {
    $resultado = $modelo->listar($id);
    $tarjeta = $resultado->fetch_assoc();
    if ($tarjeta !== null) {
        require __DIR__ . '/../vistas/tarjetas/editar.php';
        exit;
    }
    $error = 'No se encontró la tarjeta.';
}

// Sin ID, se cargan todas las tarjetas para el listado.
$resultado = $modelo->listar(0);
$tarjetas = [];
while ($fila = $resultado->fetch_assoc()) {
    $tarjetas[] = $fila;
}

require __DIR__ . '/../vistas/tarjetas/listar.php';

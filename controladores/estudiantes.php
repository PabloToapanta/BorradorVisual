<?php

require_once __DIR__ . '/../modelos/EstudianteModelo.php';

$modelo = new EstudianteModelo();
$accion = $_POST['accion'] ?? '';

if ($accion === 'guardar') {
    $id = (int) ($_POST['id'] ?? 0);
    $cedula = trim($_POST['cedula'] ?? '');
    $nombres = trim($_POST['nombres'] ?? '');
    $carrera = trim($_POST['carrera'] ?? '');

    if ($id === 0) {
        $modelo->registrar($cedula, $nombres, $carrera);
        header('Location: estudiantes.php?mensaje=registrado');
    } else {
        $modelo->actualizar($id, $cedula, $nombres, $carrera);
        header('Location: estudiantes.php?mensaje=actualizado');
    }
    exit;
}

if ($accion === 'desactivar') {
    $id = (int) ($_POST['id'] ?? 0);
    $modelo->desactivar($id);
    header('Location: estudiantes.php?mensaje=desactivado');
    exit;
}

$mensajes = [
    'registrado' => 'Estudiante registrado.',
    'actualizado' => 'Estudiante actualizado.',
    'desactivado' => 'Estudiante desactivado.',
];
$mensaje = $mensajes[$_GET['mensaje'] ?? ''] ?? '';
$error = '';
$id = (int) ($_GET['id'] ?? 0);

if ($id > 0) {
    $resultado = $modelo->listar($id);
    $estudiante = $resultado->fetch_assoc();
    if ($estudiante !== null) {
        require __DIR__ . '/../vistas/estudiantes/editar.php';
        exit;
    }
    $error = 'No se encontró el estudiante.';
}

$resultado = $modelo->listar(0);
$estudiantes = [];
while ($fila = $resultado->fetch_assoc()) {
    $estudiantes[] = $fila;
}

require __DIR__ . '/../vistas/estudiantes/listar.php';

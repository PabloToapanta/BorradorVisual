<?php

// Solo un administrador con sesión iniciada puede usar este módulo.
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: administradores.php');
    exit;
}

require_once __DIR__ . '/../modelos/EstudianteModelo.php';

// El modelo realiza las consultas a la tabla estudiante.
$modelo = new EstudianteModelo();
$accion = $_POST['accion'] ?? '';

// El formulario usa la misma acción para registrar (ID 0) o actualizar.
if ($accion === 'guardar') {
    $id = (int) ($_POST['id'] ?? 0);
    $cedula = trim($_POST['cedula'] ?? '');
    $nombres = trim($_POST['nombres'] ?? '');
    $carrera = trim($_POST['carrera'] ?? '');

    // La cédula debe tener exactamente diez dígitos antes de guardar.
    if (preg_match('/^[0-9]{10}$/', $cedula) !== 1) {
        $url = $id > 0
            ? 'estudiantes.php?id=' . $id . '&error=cedula'
            : 'estudiantes.php?error=cedula';
        header('Location: ' . $url);
        exit;
    }

    if ($id === 0) {
        $modelo->registrar($cedula, $nombres, $carrera);
        header('Location: estudiantes.php?mensaje=registrado');
    } else {
        $modelo->actualizar($id, $cedula, $nombres, $carrera);
        header('Location: estudiantes.php?mensaje=actualizado');
    }
    exit;
}

// Desactivar cambia el estado; no borra al estudiante de la base.
if ($accion === 'desactivar') {
    $id = (int) ($_POST['id'] ?? 0);
    $modelo->desactivar($id);
    header('Location: estudiantes.php?mensaje=desactivado');
    exit;
}

// Después de guardar, el mensaje llega por GET para mostrarlo en la vista.
$mensajes = [
    'registrado' => 'Estudiante registrado.',
    'actualizado' => 'Estudiante actualizado.',
    'desactivado' => 'Estudiante desactivado.',
];
$mensaje = $mensajes[$_GET['mensaje'] ?? ''] ?? '';
$error = ($_GET['error'] ?? '') === 'cedula'
    ? 'La cédula debe tener exactamente 10 dígitos numéricos.'
    : '';
$id = (int) ($_GET['id'] ?? 0);

// Un ID en la URL abre el formulario de edición con los datos actuales.
if ($id > 0) {
    $resultado = $modelo->listar($id);
    $estudiante = $resultado->fetch_assoc();
    if ($estudiante !== null) {
        require __DIR__ . '/../vistas/estudiantes/editar.php';
        exit;
    }
    $error = 'No se encontró el estudiante.';
}

// Sin ID, se cargan todos los estudiantes para el listado.
$resultado = $modelo->listar(0);
$estudiantes = [];
while ($fila = $resultado->fetch_assoc()) {
    $estudiantes[] = $fila;
}

require __DIR__ . '/../vistas/estudiantes/listar.php';

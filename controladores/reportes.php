<?php

// Solo un administrador con sesión iniciada puede descargar el reporte.
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: administradores.php');
    exit;
}

require_once __DIR__ . '/../modelos/AccesoModelo.php';
require_once __DIR__ . '/../modelos/EstudianteModelo.php';

// Se usan los mismos filtros del historial; vacíos, el reporte incluye todo.
$fechaInicio = $_GET['fecha_inicio'] ?? '';
$fechaFin = $_GET['fecha_fin'] ?? '';
$idEstudiante = (int) ($_GET['id_estudiante'] ?? 0);

// Si se eligió un estudiante, se busca su nombre para el título.
$nombreEstudiante = 'Todos';
if ($idEstudiante !== 0) {
    $modeloEstudiante = new EstudianteModelo();
    $estudiante = $modeloEstudiante->listar($idEstudiante)->fetch_assoc();
    if ($estudiante !== null) {
        $nombreEstudiante = $estudiante['nombres'];
    }
}

// Se consultan los accesos que irán en el PDF.
$modelo = new AccesoModelo();
$resultado = $modelo->historial($fechaInicio, $fechaFin, $idEstudiante);
$accesos = [];
while ($fila = $resultado->fetch_assoc()) {
    $accesos[] = $fila;
}

require __DIR__ . '/../vistas/reportes/accesos.php';

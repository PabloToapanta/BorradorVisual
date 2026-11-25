<?php

// Solo un administrador con sesión iniciada puede ver el historial.
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: administradores.php');
    exit;
}

require_once __DIR__ . '/../modelos/AccesoModelo.php';
require_once __DIR__ . '/../modelos/EstudianteModelo.php';

// Los filtros son opcionales y llegan por GET.
$fechaInicio = $_GET['fecha_inicio'] ?? '';
$fechaFin = $_GET['fecha_fin'] ?? '';
$idEstudiante = (int) ($_GET['id_estudiante'] ?? 0);

// Los estudiantes llenan el selector del filtro.
$modeloEstudiante = new EstudianteModelo();
$resultadoEstudiantes = $modeloEstudiante->listar(0);
$estudiantes = [];
while ($fila = $resultadoEstudiantes->fetch_assoc()) {
    $estudiantes[] = $fila;
}

// Se consultan los accesos de más reciente a más antiguo.
$modelo = new AccesoModelo();
$resultado = $modelo->historial($fechaInicio, $fechaFin, $idEstudiante);
$accesos = [];
while ($fila = $resultado->fetch_assoc()) {
    $accesos[] = $fila;
}

require __DIR__ . '/../vistas/historial/listar.php';

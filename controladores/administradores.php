<?php

session_start();
require_once __DIR__ . '/../modelos/AdministradorModelo.php';

$error = '';
$accion = $_POST['accion'] ?? '';

// Comprueba el usuario y la clave enviados desde el formulario de ingreso.
if ($accion === 'entrar') {
    $usuario = trim($_POST['usuario'] ?? '');
    $clave = $_POST['clave'] ?? '';
    $modelo = new AdministradorModelo();
    $resultado = $modelo->autenticar($usuario, $clave);
    $administrador = $resultado->fetch_assoc();

    if ($administrador !== null) {
        // Guarda el ID para reconocer al administrador en las siguientes páginas.
        session_regenerate_id();
        $_SESSION['admin_id'] = (int) $administrador['id'];
        header('Location: administradores.php');
        exit;
    }

    $error = 'Usuario o clave incorrectos.';
}

// Quita el ID de la sesión para cerrar el acceso al panel y a los módulos.
if ($accion === 'salir') {
    unset($_SESSION['admin_id']);
    header('Location: administradores.php');
    exit;
}

// Muestra el panel si hay una sesión iniciada; en otro caso muestra el login.
if (isset($_SESSION['admin_id'])) {
    require __DIR__ . '/../vistas/administradores/panel.php';
} else {
    require __DIR__ . '/../vistas/administradores/login.php';
}

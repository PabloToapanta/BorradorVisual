<?php

require_once __DIR__ . '/../modelos/AccesoModelo.php';

// El modelo busca la tarjeta leída y guarda cada intento en la tabla acceso.
$modelo = new AccesoModelo();
$accion = $_POST['accion'] ?? '';
$resultado = '';
$estudiante = null;

// Cada lectura no vacía se registra, aunque la tarjeta no exista.
if ($accion === 'leer') {
    $codigoRfid = trim($_POST['codigo_rfid'] ?? '');

    if ($codigoRfid !== '') {
        $tarjeta = $modelo->buscarTarjeta($codigoRfid)->fetch_assoc();
        $idTarjeta = null;
        $idEstudiante = null;
        $resultado = 'DENEGADO';

        if ($tarjeta !== null) {
            $idTarjeta = (int) $tarjeta['id'];
            $idEstudiante = (int) $tarjeta['id_estudiante'];
            // Solo se autentica si la tarjeta y el estudiante están activos.
            if ($tarjeta['estado'] === 'ACTIVO' && $tarjeta['estado_estudiante'] === 'ACTIVO') {
                $resultado = 'AUTENTICADO';
                $estudiante = $tarjeta;
            }
        }

        $modelo->registrar($idTarjeta, $idEstudiante, $codigoRfid, $resultado);
    }
}

require __DIR__ . '/../vistas/accesos/lectura.php';

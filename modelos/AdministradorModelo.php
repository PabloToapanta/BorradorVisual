<?php

require_once __DIR__ . '/../conexion.php';

class AdministradorModelo
{
    private mysqli $conexion;

    public function __construct()
    {
        $this->conexion = Conexion::conectar();
    }

    public function autenticar(string $usuario, string $clave): mysqli_result
    {
        $sentencia = $this->conexion->prepare(
            'SELECT id, usuario FROM administrador WHERE usuario = ? AND clave = ?'
        );
        $sentencia->bind_param('ss', $usuario, $clave);
        $sentencia->execute();
        return $sentencia->get_result();
    }
}

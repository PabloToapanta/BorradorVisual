<?php

require_once __DIR__ . '/../conexion.php';

class AccesoModelo
{
    private mysqli $conexion;

    public function __construct()
    {
        $this->conexion = Conexion::conectar();
    }

    public function buscarTarjeta(string $codigoRfid): mysqli_result
    {
        $sentencia = $this->conexion->prepare(
            'SELECT t.id, t.id_estudiante, t.estado, e.nombres, e.carrera, e.estado AS estado_estudiante '
            . 'FROM tarjeta t, estudiante e WHERE e.id = t.id_estudiante AND t.codigo_rfid = ?'
        );
        $sentencia->bind_param('s', $codigoRfid);
        $sentencia->execute();
        return $sentencia->get_result();
    }

    public function registrar(?int $idTarjeta, ?int $idEstudiante, string $codigoLeido, string $resultado): void
    {
        $sentencia = $this->conexion->prepare(
            'INSERT INTO acceso (id_tarjeta, id_estudiante, codigo_leido, resultado) VALUES (?, ?, ?, ?)'
        );
        $sentencia->bind_param('iiss', $idTarjeta, $idEstudiante, $codigoLeido, $resultado);
        $sentencia->execute();
    }
}

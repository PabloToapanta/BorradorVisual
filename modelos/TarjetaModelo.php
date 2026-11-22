<?php

require_once __DIR__ . '/../conexion.php';

class TarjetaModelo
{
    private mysqli $conexion;

    public function __construct()
    {
        $this->conexion = Conexion::conectar();
    }

    public function listar(int $id): mysqli_result
    {
        $sql = 'SELECT t.id, t.codigo_rfid, t.id_estudiante, t.estado, e.nombres AS estudiante '
            . 'FROM tarjeta t, estudiante e WHERE e.id = t.id_estudiante';
        if ($id === 0) {
            $sql .= ' ORDER BY t.codigo_rfid';
        } else {
            $sql .= ' AND t.id = ?';
        }

        $sentencia = $this->conexion->prepare($sql);
        if ($id !== 0) {
            $sentencia->bind_param('i', $id);
        }
        $sentencia->execute();
        return $sentencia->get_result();
    }

    public function registrar(string $codigoRfid, int $idEstudiante, string $estado): void
    {
        $sentencia = $this->conexion->prepare(
            'INSERT INTO tarjeta (codigo_rfid, id_estudiante, estado) VALUES (?, ?, ?)'
        );
        $sentencia->bind_param('sis', $codigoRfid, $idEstudiante, $estado);
        $sentencia->execute();
    }

    public function actualizar(int $id, string $codigoRfid, int $idEstudiante, string $estado): void
    {
        $sentencia = $this->conexion->prepare(
            'UPDATE tarjeta SET codigo_rfid = ?, id_estudiante = ?, estado = ? WHERE id = ?'
        );
        $sentencia->bind_param('sisi', $codigoRfid, $idEstudiante, $estado, $id);
        $sentencia->execute();
    }

    public function desactivar(int $id): void
    {
        $sentencia = $this->conexion->prepare(
            "UPDATE tarjeta SET estado = 'INACTIVO' WHERE id = ?"
        );
        $sentencia->bind_param('i', $id);
        $sentencia->execute();
    }
}

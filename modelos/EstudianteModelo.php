<?php

require_once __DIR__ . '/../conexion.php';

class EstudianteModelo
{
    private mysqli $conexion;

    public function __construct()
    {
        $this->conexion = Conexion::conectar();
    }

    public function listar(int $id): mysqli_result
    {
        $sql = 'SELECT id, cedula, nombres, carrera, estado FROM estudiante';
        if ($id === 0) {
            $sql = $sql.' ORDER BY nombres';
        } else {
            $sql = $sql.' WHERE id = ?';
        }

        $sentencia = $this->conexion->prepare($sql);
        if ($id !== 0) {
            $sentencia->bind_param('i', $id);
        }
        $sentencia->execute();
        return $sentencia->get_result();
    }

    public function registrar(string $cedula, string $nombres, string $carrera): void
    {
        $sentencia = $this->conexion->prepare(
            "INSERT INTO estudiante (cedula, nombres, carrera, estado) VALUES (?, ?, ?, 'ACTIVO')"
        );
        $sentencia->bind_param('sss', $cedula, $nombres, $carrera);
        $sentencia->execute();
    }

    public function actualizar(int $id, string $cedula, string $nombres, string $carrera): void
    {
        $sentencia = $this->conexion->prepare(
            'UPDATE estudiante SET cedula = ?, nombres = ?, carrera = ? WHERE id = ?'
        );
        $sentencia->bind_param('sssi', $cedula, $nombres, $carrera, $id);
        $sentencia->execute();
    }

    public function desactivar(int $id): void
    {
        $sentencia = $this->conexion->prepare(
            "UPDATE estudiante SET estado = 'INACTIVO' WHERE id = ?"
        );
        $sentencia->bind_param('i', $id);
        $sentencia->execute();
    }
}

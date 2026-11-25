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

    public function historial(string $fechaInicio, string $fechaFin, int $idEstudiante): mysqli_result
    {
        // La subconsulta deja el nombre vacío en las lecturas de tarjetas no registradas.
        $sql = 'SELECT a.fecha_hora, a.codigo_leido, a.resultado, '
            . '(SELECT e.nombres FROM estudiante e WHERE e.id = a.id_estudiante) AS estudiante '
            . 'FROM acceso a WHERE 1 = 1';
        $tipos = '';
        $valores = [];

        if ($fechaInicio !== '') {
            $sql .= ' AND a.fecha_hora >= ?';
            $tipos .= 's';
            $valores[] = $fechaInicio;
        }
        if ($fechaFin !== '') {
            // Se suma un día para incluir todo el día de la fecha final.
            $sql .= ' AND a.fecha_hora < DATE_ADD(?, INTERVAL 1 DAY)';
            $tipos .= 's';
            $valores[] = $fechaFin;
        }
        if ($idEstudiante !== 0) {
            $sql .= ' AND a.id_estudiante = ?';
            $tipos .= 'i';
            $valores[] = $idEstudiante;
        }
        $sql .= ' ORDER BY a.fecha_hora DESC, a.id DESC';

        $sentencia = $this->conexion->prepare($sql);
        if ($tipos !== '') {
            $sentencia->bind_param($tipos, ...$valores);
        }
        $sentencia->execute();
        return $sentencia->get_result();
    }
}

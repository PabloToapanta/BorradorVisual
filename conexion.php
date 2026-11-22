<?php

/** Abre una conexión nueva con la base de datos del proyecto. */
class Conexion
{
    public static function conectar(): mysqli
    {
        $conexion = new mysqli('localhost', 'root', '', 'SistemaEstudiantil', 3306);
        $conexion->set_charset('utf8mb4');
        return $conexion;
    }
}

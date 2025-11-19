<?php
require_once __DIR__ . '/conexion.php';

abstract class Modelo
{
    protected PDO $conexion;

    public function __construct()
    {
        $db = new Database();
        $this->conexion = $db->Conexion();
    }
}

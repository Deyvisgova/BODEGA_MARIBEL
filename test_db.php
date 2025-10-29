<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . "/modelo/conexion.php";
$db = new Database();
$pdo = $db->Conexion();
echo "✅ Conexión PDO OK<br>";

require_once __DIR__ . "/modelo/config.php";
echo "✅ Conexión MySQLi OK<br>";

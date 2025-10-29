<?php
class Database {
  function Conexion() {
    $server = "localhost";
    $user = "root";
    $password = ""; // en XAMPP normalmente vacío
    try {
      $conn = new PDO("mysql:host=$server;dbname=bodega_maribel;charset=utf8mb4", $user, $password);
      $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $conn;
    } catch (PDOException $e) {
      die('❌ Error BD (PDO): ' . $e->getMessage());
    }
  }
}

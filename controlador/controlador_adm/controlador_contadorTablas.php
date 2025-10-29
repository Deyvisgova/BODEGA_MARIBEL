<?php

    @include '../../modelo/conexion.php';
    error_reporting(0);
    $db = new Database();
    $con = $db->Conexion();
    
    $administrador  = current($con->query("SELECT COUNT(id_adm) FROM administrador")->fetch());
    $provedor       = current($con->query("SELECT COUNT(id_provedor) FROM provedor")->fetch());
    $categoria    = current($con->query("SELECT COUNT(id_categoria) FROM categoria")->fetch());
    $colaborador    = current($con->query("SELECT COUNT(id_colab) FROM colaborador")->fetch());
    $producto       = current($con->query("SELECT COUNT(id_producto) FROM producto")->fetch());

?>
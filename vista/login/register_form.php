<?php
session_start();

if(!isset($_SESSION['admin_name'])){
    header('location: login_form.php');
    exit;
}

header('Location: ../adm/dashboard/registrar_usuarios.php');
exit;

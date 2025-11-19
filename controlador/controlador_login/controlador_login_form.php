<?php

require_once __DIR__ . '/../../modelo/config.php';
error_reporting(0);
session_start();

$loginErrors = $loginErrors ?? [];

/**
 * Verifica la contraseña almacenada sin importar el algoritmo utilizado.
 */
function passwordMatchesCompat(?string $storedPassword, string $plainPassword): bool
{
    $stored = (string)($storedPassword ?? '');
    $plain = trim($plainPassword);

    if ($stored === '' || $plain === '') {
        return false;
    }

    $md5Hash = md5($plain);
    if (hash_equals($stored, $md5Hash)) {
        return true;
    }

    $passwordInfo = password_get_info($stored);
    if (($passwordInfo['algo'] ?? 0) !== 0 && password_verify($plain, $stored)) {
        return true;
    }

    if (hash_equals($stored, $plain)) {
        return true;
    }

    return false;
}

/**
 * Busca al usuario en ambas tablas y devuelve sus datos si las credenciales coinciden.
 */
function authenticateUser(mysqli $conn, string $email, string $password): ?array
{
    $safeEmail = mysqli_real_escape_string($conn, $email);

    $adminQuery = "SELECT nombre_adm AS nombre, password, user_type FROM administrador WHERE email = '$safeEmail' LIMIT 1";
    $adminResult = mysqli_query($conn, $adminQuery);

    if ($adminResult) {
        if (mysqli_num_rows($adminResult) > 0) {
            $admin = mysqli_fetch_assoc($adminResult);

            if (passwordMatchesCompat($admin['password'] ?? '', $password)) {
                mysqli_free_result($adminResult);
                $admin['scope'] = 'admin';
                return $admin;
            }
        }

        mysqli_free_result($adminResult);
    }

    $colabQuery = "SELECT nombre_colab AS nombre, password, user_type FROM colaborador WHERE email = '$safeEmail' LIMIT 1";
    $colabResult = mysqli_query($conn, $colabQuery);

    if ($colabResult) {
        if (mysqli_num_rows($colabResult) > 0) {
            $colab = mysqli_fetch_assoc($colabResult);

            if (passwordMatchesCompat($colab['password'] ?? '', $password)) {
                mysqli_free_result($colabResult);
                $colab['scope'] = strtolower(trim($colab['user_type'] ?? '')) === 'admin' ? 'admin' : 'colab';
                return $colab;
            }
        }

        mysqli_free_result($colabResult);
    }

    return null;
}

if(isset($_POST['submit'])){

   $email = trim($_POST['email'] ?? '');
   $passwordRaw = trim($_POST['password'] ?? '');

   if(trim($email) === ''){
      $loginErrors[] = 'El correo es obligatorio.';
   }else if (!preg_match("/^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\\.[a-zA-Z0-9-.]+$/", $email)){
      $loginErrors[] = 'Ha introducido un email no valido!';
   }else if(trim($passwordRaw) === ''){
      $loginErrors[] = 'La contraseña no puede estar vacía!';
   }else{
      $user = authenticateUser($conn, $email, $passwordRaw);

      if($user !== null){
         $userName = $user['nombre'] ?? 'Usuario';
         $scope = $user['scope'] ?? 'colab';

         if($scope === 'admin'){
            $_SESSION['admin_name'] = $userName;
            echo "<script> alert('Login exitoso')</script>";
            header('location:../adm/dashboard/dashboard.php');
            exit;
         }

         $_SESSION['colab_name'] = $userName;
         echo "<script> alert('Login exitoso')</script>";
         header('location:../adm/dashboard/dashboardColaborador.php');
         exit;
      }

      $loginErrors[] = 'Correo o contraseña equivocada!';
   }
}
?>

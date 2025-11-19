<?php
// cambiar_estado_guia_salida.php

// Incluir archivo de configuración de la base de datos
include '../../modelo/config.php';
require_once __DIR__ . '/../kardex_helper.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID de la guía de salida desde el formulario
    $id_guia = mysqli_real_escape_string($conn, $_POST['id_guia']);

    // Consulta para verificar el estado de la guía de salida
    $consulta_estado = "SELECT * FROM guia_de_salida WHERE id_guia_salida = '$id_guia'";
    $resultado_estado = mysqli_query($conn, $consulta_estado);

    if ($resultado_estado && mysqli_num_rows($resultado_estado) > 0) {
        $guia = mysqli_fetch_assoc($resultado_estado);

        // Verificar si la guía ya ha sido procesada
        if ($guia['activo'] === 'Entregado') {
            echo '<script>alert("La guía ya ha sido procesada anteriormente"); 
            window.location.href="../../vista/adm/dashboard/tabla_guia_salida_colab.php";</script>';
        } else {
            // Obtener la cantidad y el producto
            $cantidad_salida = $guia['cantidad_salida'];
            $producto = $guia['producto'];

            // Consulta para actualizar el estado de la guía de salida
            $query_actualizar_guia = "UPDATE `guia_de_salida` SET `activo`='Entregado' WHERE id_guia_salida='$id_guia'";
            $result_actualizar_guia = mysqli_query($conn, $query_actualizar_guia);

            // Verificar si la consulta de actualizar guía fue exitosa
            if ($result_actualizar_guia) {
                registrarKardex(
                    $conn,
                    $guia['fecha_salida'],
                    $producto,
                    'salida',
                    (int)$cantidad_salida,
                    $guia['descripcion'],
                    'GS-' . $id_guia
                );

                // Redirigir de vuelta a la página de la guía de salida
                echo '<script>alert("La guía ha sido procesada y se ha actualizado el inventario.");
                    window.location.href="../../vista/adm/dashboard/tabla_guia_salida_colab.php";</script>';
            } else {
                echo "Error al actualizar el estado de la guía de salida: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Error al obtener la información de la guía de salida.";
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
}
?>

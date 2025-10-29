<?php
// cambiar_estado_guia.php

// Incluir archivo de configuración de la base de datos
include '../../modelo/config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID de la guía de entrada desde el formulario
    $id_guia = mysqli_real_escape_string($conn, $_POST['id_guia']);

    // Consulta para verificar el estado de la guía de entrada
    $consulta_estado = "SELECT * FROM guia_de_entrada WHERE id_guia_entrada = '$id_guia'";
    $resultado_estado = mysqli_query($conn, $consulta_estado);

    if ($resultado_estado && mysqli_num_rows($resultado_estado) > 0) {
        $guia = mysqli_fetch_assoc($resultado_estado);

        // Verificar si la guía ya ha sido recibida
        if ($guia['activo'] === 'recibido') {
            echo '<script>alert("La guía ya ha sido recibida anteriormente"); 
            window.location.href="../../vista/adm/dashboard/tabla_cantidad_colab.php";</script>';
        } else {
            // Obtener la cantidad y el producto
            $cantidad_entrada = $guia['cantidad_entrada'];
            $producto = $guia['producto'];

            // Consulta para actualizar el estado de la guía de entrada
            $query_actualizar_guia = "UPDATE `guia_de_entrada` SET `activo`='recibido' WHERE id_guia_entrada='$id_guia'";
            $result_actualizar_guia = mysqli_query($conn, $query_actualizar_guia);

            // Verificar si la consulta de actualizar guía fue exitosa
            if ($result_actualizar_guia) {
                // Consulta para actualizar la tabla de productos
                $query_actualizar_producto = "UPDATE `producto` SET `cantidad`=`cantidad`+$cantidad_entrada WHERE nombre_producto='$producto'";
                $result_actualizar_producto = mysqli_query($conn, $query_actualizar_producto);

                // Verificar si la consulta de actualizar productos fue exitosa
                if ($result_actualizar_producto) {
                    // Redirigir de vuelta a la página de la guía de entrada
                    echo '<script>alert("La guía ha sido marcada como recibida y se ha actualizado el inventario."); 
                    window.location.href="../../vista/adm/dashboard/tabla_cantidad_colab.php";</script>';
                } else {
                    echo "Error al actualizar el inventario del producto: " . mysqli_error($conn);
                }
            } else {
                echo "Error al actualizar el estado de la guía de entrada: " . mysqli_error($conn);
            }
        }
    } else {
        echo "Error al obtener la información de la guía de entrada.";
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
}
?>

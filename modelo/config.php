<?php
$conn = mysqli_connect('localhost', 'root', '', 'bodega_maribel');
if (!$conn) {
  die('❌ Error BD (MySQLi): ' . mysqli_connect_error());
}
mysqli_set_charset($conn, 'utf8mb4');

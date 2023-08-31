<?php
include("conexion-datos.php");
//Conexion con el servidor
$conexion = mysqli_connect($servidorConexion, $usuarioConexion, $claveConexion);
//Selecionamos la base de datos
mysqli_select_db($conexion, $baseDatosServicios);

if (!$conexion) {
  die("La conexión a la base de datos falló: " . mysqli_connect_error());
}

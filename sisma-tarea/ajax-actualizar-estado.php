<?php
include("../conexion-bd/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $taskId = $_POST['taskId'];
  $newStatus = $_POST['newStatus'];

  $query = "UPDATE tasks SET completada = $newStatus WHERE id = $taskId";

  if (mysqli_query($conexion, $query)) {
    echo "Actualización exitosa";
  } else {
    echo "Error en la actualización: " . mysqli_error($conexion);
  }
} else {
  echo "Acceso no válido";
}
?>

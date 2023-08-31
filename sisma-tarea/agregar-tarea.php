<?php
include("../conexion-bd/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $nuevaTarea = $_POST['tarea'];
  $completada = isset($_POST['completada']) ? 1 : 0; // 1 si está marcada, 0 si no está marcada
  
  $sql = "INSERT INTO tasks (tarea, completada) VALUES ('$nuevaTarea', $completada)";
  mysqli_query($conexion, $sql);
  
  header("Location: index.php");
}
?>

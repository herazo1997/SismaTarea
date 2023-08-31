<?php
include("../conexion-bd/conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $taskId = $_POST['taskId'];

  $query = "DELETE FROM tasks WHERE id = $taskId";
  if (mysqli_query($conexion, $query)) {
    $response = array("success" => true);
    echo json_encode($response);
  } else {
    $response = array("success" => false, "message" => "Error en la eliminación: " . mysqli_error($conexion));
    echo json_encode($response);
  }
} else {
  $response = array("success" => false, "message" => "Acceso no válido");
  echo json_encode($response);
}
?>

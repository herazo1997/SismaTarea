<?php
include("../conexion-bd/conexion.php");
$contar = 1;
$listar = "SELECT * FROM tasks";
$resultado = mysqli_query($conexion, $listar);

while ($fila = mysqli_fetch_assoc($resultado)) {

  echo "<tr>";
  echo "<td>{$contar}</td>";
  echo "<td>{$fila['tarea']}</td>";
  echo "<td class='calificacion-cell'>";
  echo "<span data-task-id='{$fila['id']}' data-current-status='{$fila['completada']}' class='status-span'>";
  echo ($fila['completada'] == 1) ? 'Completada' : 'Pendiente';
  echo "</span></td>";
  echo "<td><input type='checkbox' class='status-checkbox' data-task-id='{$fila['id']}' ";
  echo ($fila['completada'] == 1) ? 'checked' : '';
  echo ">";
  echo "<button class='btn btn-icon delete-button' data-task-id='{$fila['id']}'>";
  echo "<i class='fas fa-trash-alt'></i>"; 
  echo "</button>";
  echo "<button class='btn btn-icon edit-button'  data-toggle='modal' data-target='#editModal' data-task-id='{$fila['id']}' data-task='{$fila['tarea']}'>";
  echo "<i class='fas fa-edit'></i>";
  echo "</button>";
  echo "</td>";
  echo "</tr>";
  $contar++;
}
?>

<script>
  $(document).ready(function() {
    $(".status-checkbox").on("change", function() {
      const taskId = $(this).data("task-id");
      const isChecked = $(this).prop("checked");
      const statusSpan = $(this).closest("tr").find(".status-span");

      const newStatusText = isChecked ? "Completada" : "Pendiente";
      statusSpan.text(newStatusText);

      const newStatus = isChecked ? 1 : 0;

      $.ajax({
        type: "POST",
        url: "ajax-actualizar-estado.php",
        data: {
          taskId: taskId,
          newStatus: newStatus
        },
        success: function(response) {
          if (!response.success) {
            console.error(response.message);
          }
        },
        error: function(error) {
          console.error("Error en la actualización: " + error);
        }
      });
    });
  });
</script>
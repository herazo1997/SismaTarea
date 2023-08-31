<?php
include("../conexion-bd/conexion.php");

$listar = "SELECT * FROM tasks";
$resultado = mysqli_query($conexion, $listar);
$contar = 1;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tabla de Tareas</title>
  <link rel="stylesheet" href="./css/styles.css">
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="../bootstrap/js/bootstrap.min.js">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

</head>

<body>
  <div class="container mt-2">

    <table class="table table-bordered table-striped table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>Nombre Tarea</th>
          <th>Calificación</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        <?php
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
      </tbody>
    </table>

  </div>

  <!-- Agrega los enlaces a los archivos de Bootstrap JS y el script de cambio de estado -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>

  <script>
    // Obtiene la ID del checkbox que se ha pulsado para actualizar su valor (estado completado o pendiente).
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

    // Funcion para eliminar una Tarea
    $(document).ready(function() {
      $(".delete-button").on("click", function() {
        const taskId = $(this).data("task-id");
        const row = $(this).closest("tr");


        if (confirm("¿Desea eliminar el registro?")) {
          $.ajax({
            type: "POST",
            url: "eliminar-tarea.php",
            data: {
              taskId: taskId
            },
            dataType: 'json',
            success: function(response) {
              if (response.success) {
                row.remove();

                $.ajax({
                  type: "GET",
                  url: "ajax-actualizar-tareas.php",
                  success: function(html) {
                    $(".table tbody").html(html);
                  },
                  error: function(error) {
                    console.error("Error al recargar la tabla de tareas: " + error);
                  }
                });
              } else {
                console.error(response.message);
              }
            },
            error: function(error) {
              console.error("Error en la eliminación: " + error);
            }
          });
        }
      });
    });

    //Funcion para editar una tarea
    $(document).ready(function() {
      $(".edit-button").on("click", function() {
        const taskId = $(this).data("task-id");
        const tarea = $(this).data("task");

        $("#editedTaskId").val(taskId);
        $("#editedTaskContent").val(tarea);

        $("#editModal").modal("show");
      });

      $("#saveEditedTask").on("click", function() {
        const newTarea = $("#editedTaskContent").val();
        const taskId = $("#editedTaskId").val();

        $.ajax({
          type: "POST",
          url: "editar-tarea.php",
          data: {
            "taskId": taskId,
            "newTarea": newTarea
          },
          dataType: 'json',
          success: function(response) {
            if (response.success) {
              $("#editModal").modal("hide");
              $.ajax({
                type: "GET",
                url: "ajax-actualizar-tareas.php",
                success: function(html) {
                  $(".table tbody").html(html);
                },
                error: function(error) {
                  console.error("Error al recargar la tabla de tareas: " + error);
                }
              });
            } else {
              console.error(response.message);
            }
          },
          error: function(error) {
            console.error("Error en la edición: " + error);
          }
        });
      });
    });
  </script>


  <!-- ... -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" data-backdrop="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Editar Tarea</h5>
          <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editForm">
            <div class="mb-3">
              <label for="editedTask" class="form-label">Contenido de la Tarea</label>
              <input type="hidden" id="editedTaskId">
              <textarea class="form-control" id="editedTaskContent" rows="3" required></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
          <button type="button" class="btn btn-primary" id="saveEditedTask">Guardar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- ... -->




</body>

</html>
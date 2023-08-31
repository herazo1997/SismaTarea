<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<div class="container mt-5">
  <h2 class="text-center mb-4">Agregar Nueva Tarea</h2>
  <form action="agregar-tarea.php" method="POST" class="d-flex justify-content-center">
    <div class="input-group">
      <input type="text" name="tarea" id="tarea" class="form-control" placeholder="Ingrese una nueva tarea..." required>
      <button type="submit" class="btn btn-primary">Agregar Tarea</button>
    </div>
  </form>
</div>






  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
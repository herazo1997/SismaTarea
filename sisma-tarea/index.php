<!DOCTYPE html>
<html>

<head>
    <title>Lista de Tareas</title>
    <link rel="stylesheet" type="text/css" href="./css/styles.css">

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Tareas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-body">
            <?php include("agregar-tarea-formulario.php"); ?>
            <h1 class="text-center mb-4">Lista de Tareas</h1>
            <div class="container">
                <?php include("listar-tareas.php"); ?>
            </div>
        </div>
    </div>
</div>




    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
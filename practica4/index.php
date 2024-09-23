<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,opsz,wght@0,6..12,200..1000;1,6..12,200..1000&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="styles/home.css">
    <link rel="stylesheet" href="styles/table.css">
    
    <title>Registros</title>
</head>

<body>
    <form action="crud/insert.php" method="post" class="insert_form">
        <label for="id">ID</label> <br>
        <input type="number" id="id" name="id" step="1" placeholder="0" required> <br> <br>

        <label for="nombre">NOMBRE</label> <br>
        <input type="text" id="nombre" name="nombre" required> <br> <br>

        <label for="precio">PRECIO</label> <br>
        <input type="number" id="precio" name="precio" step="any" placeholder="0.00" required> <br> <br>

        <label for="extension">EXTENSION</label> <br>
        <input type="number" id="ext" name="ext" value="0" step="1" placeholder="0"> <br> <br>

        <button type="submit">INSERTAR</button>
    </form>

    <?php
    echo "<section class=\"res_section\">";
    if (isset($_GET['msg'])) {
        echo $_GET['msg'];

        if (isset($_GET['error']))
            echo ' cause: ' . $_GET['error'] . '';
    }
    echo "</section>";
    ?>

    <table class="tabla_productos">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Precio</th>
                <th>Extension</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            include "crud/select.php";
            ?>
        </tbody>
    </table> <br>
</body>

</html>
<?php
    require_once "includes/sqlclient.php";

    $result = $conn->query("SELECT * FROM productos");
    if ($result->num_rows == 0) {
        echo "<tr><td colspan='5'> No hay productos disponibles </td></tr>";
        exit();
    }

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td data-label='ID'>". htmlspecialchars($row["id"]). "</td>";
        echo "<td data-label='Nombre'>". htmlspecialchars($row["nombre"]). "</td>";
        echo "<td data-label='Precio'>". htmlspecialchars($row["precio"]). "</td>";
        echo "<td data-label='Extension'>". htmlspecialchars($row["extension"]). "</td>";
        echo "<td data-label='Acción'> <a href=\"crud/delete.php?id=". htmlspecialchars($row["id"]). "\">eliminar</a> </td>"; 
        echo "</tr>";
    }
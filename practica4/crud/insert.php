<?php
    require_once "../includes/sqlclient.php";
    require_once "../includes/producto.php";

    try {
        $producto = new Producto(
            $_POST["id"],
            $_POST["nombre"],
            $_POST["precio"],
            $_POST["ext"],
        );

        $stmt = $conn->prepare("INSERT INTO productos VALUES (?, ?, ?, ?)");
        if (!$stmt)
            throw new Exception("Error al preparar el stmt: $conn->error");

        $stmt->bind_param("isdi", 
            $producto->id, 
            $producto->nombre, 
            $producto->precio, 
            $producto->extension);

        if (!$stmt->execute())
            throw new Exception("Error al ejecutar consulta sql: $stmt->error", $stmt->errno);
        
        header("location:../index.php?msg=ok");

    } catch (Exception $e) {

        switch ($e->getCode()) {
            case 3819:
                if (strpos($e->getMessage(), 'chk_precio') !== false){
                    $error_msg = "El precio debe ser mayor que 0";
                    break;
                }
                $error_msg = "Error con el formato de un atributo";
                break;
            case 1062:
                $error_msg = "Identificador duplicado";
                break;
            default:
                $error_msg = "unexpected error occurred";
        }
        header("location:../index.php?msg=bad&error=". urldecode($error_msg));

    } finally {
        if (isset($stmt) && $stmt)
            $stmt->close();
        $conn->close();
    }

    
    
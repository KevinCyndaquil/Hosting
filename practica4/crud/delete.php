<?php
    require_once "../includes/sqlclient.php";

    try {
        $id = $_GET['id'];
    
        $stmt = $conn->prepare(query: "DELETE FROM productos WHERE id = ?");
        if (!$stmt)
            die("Statement Error $conn->error"); 
        
        $stmt->bind_param("i", $id);
        
        if (!$stmt->execute())
            throw new Exception("Error al ejecutar consulta sql: $stmt->error", $stmt->errno);
    
        header("location:../index.php?msg=ok");

    } catch (Exception $e) {
        $error_msg = "Error inesperado al intentar eliminar entrada";

        header("location:../index.php?msg=bad&error=". urldecode($error_msg));

    } finally {
        if (isset($stmt) && $stmt)
            $stmt->close();
        $conn->close();
    }
    
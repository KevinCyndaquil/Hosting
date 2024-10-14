<?php
include "../conexion.php";

header('Content-Type: application/json');

if (!isset($_POST['id']) && !isset($_POST['nombre']) && !isset($_POST['precio'])) {
    echo json_encode([
        'success' => false,
        'error' => 'Proporciona un objeto producto completo',
    ]);

    exit();
}

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$precio = $_POST['precio'];

try {
    $conn = get_sql_client();
    $stmt = $conn->prepare('UPDATE tb_productos SET Nombre = ?, Precio = ? WHERE idPro = ?');

    if (!$stmt)
        throw new Exception("Fatal Error: While we trying to create the statement: $conn->error");
    $stmt->bind_param("sdi", $nombre, $precio, $id);
    if (!$stmt->execute())
        throw new Exception("Fatal Error: While we execute sql consult: $stmt->error", $stmt->errno);

    echo json_encode([
        'success' => true,
    ]);
} catch (Exception $e) {
    switch ($e->getCode()) {
		case 3819:
			$error_msg = "Error con el formato de un atributo";
			break;
		case 1062:
			$error_msg = "Identificador duplicado";
			break;
		default:
			$error_msg = "unexpected error occurred";
	}

	echo json_encode([
		'success' => false,
		'error' => $error_msg,
	]);
} finally {
    if (isset($stmt) && $stmt)
		$stmt->close();
	if (isset($conn))
		$conn->close();
}

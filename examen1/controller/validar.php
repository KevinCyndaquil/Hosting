<?php

include "../conexion.php";

header('Content-Type: application/json');

if (!isset($_POST['usr']) && !isset($_POST['passwd'])) {
	echo json_encode([
		'success' => false,
		'error' => 'Proporciona un usuario y contraseña por favor',
	]);

	exit();
}

$username = $_POST['usr'];
$passwd = $_POST['passwd'];

try {
	$conn = get_sql_client();
	$stmt = $conn->prepare('SELECT * FROM tb_usuarios WHERE NomUser = ? AND Passwd = ?');

	if (!$stmt)
		throw new Exception("Fatal Error: While we trying to create the statement: $conn->error");
	$stmt->bind_param("ss", $username, $passwd);
	if (!$stmt->execute())
		throw new Exception("Fatal Error: While we execute sql consult: $stmt->error", $stmt->errno);
	$result = $stmt->get_result();
	if ($result->num_rows == 0) {
		echo json_encode([
			'success' => false,
			'error' => 'Usuario o contraseña incorrectas',
		]);
		exit();
	}
	$user = $result->fetch_assoc();

	

	session_start();
	$_SESSION['username'] = $user['NomUser'];
	$_SESSION['name'] = $user['nombre_completo'];
	$_SESSION['logged'] = true;

	echo json_encode([
		'success'=> true,
		'user' => $user,
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

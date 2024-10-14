<?php
session_start();
if (!isset($_SESSION['logged']))
	header("location: index.php");
?>

<html>

<head>
	<title>Sistema de Pruebas UNACH</title>
	<!-- Bootstrap core CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootswatch@4.5.2/dist/cerulean/bootstrap.min.css">
	<link href="css/cmce-styles.css" rel="stylesheet">
	<!-- Bootstrap core JavaScript -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<script src="js/script.js"></script>

	<nav class="navbar navbar-dark bg-dark">
		<div class="container-fluid">
			<a class="navbar-brand"><b>Nombre de usuario:</b> <?php echo "{$_SESSION['username']} [{$_SESSION['name']}]"; ?></a>
			<a href="cerrar.php"><button class="btn btn-warning">Cerrar Sesión</button></a>
		</div>
	</nav>
	<center>
		<br><br><br><br>


		<form action="dashboard.php" method="GET">
			<div class="formpanel" id="f1">
				<b>Buscar producto por precio mayor a:</b> <input type="text" name="pre" size="4">
				<button class="btn btn-primary" type="submit">Buscar</button>
			</div>
		</form>

		<br><br>
		<hr>
		<br><br>

		<button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#exampleModal">
			Nuevo Producto
		</button>

		<br><br>
		<?php
		include 'conexion.php';

		try {
			$precio = $_GET['pre'] ?? -1;
			$conn = get_sql_client();
			$stmt = $conn->prepare('SELECT * FROM tb_productos WHERE precio > ?');
			if (!$stmt)
				throw new Exception("Fatal Error: While we trying to create the statement: $conn->error");

			$stmt->bind_param("d", $precio);
			if (!$stmt->execute())
				throw new Exception("Fatal Error: While we execute sql consult: $stmt->error", $stmt->errno);

			echo "<table class='table' style='width:570;'>";
			echo "<thead class='table-dark'>";
			echo "<th>Nombre</th>";
			echo "<th>Precio</th>";
			echo "<th></th>";
			echo "<th></th>";
			echo "</thead>";
			echo "<tbody>";

			$result = $stmt->get_result();
			while ($row = $result->fetch_assoc()) {
				echo "<tr>";
				echo "<td> {$row['Nombre']} </td>";
				echo "<td> {$row['Precio']} </td>";
				echo "<td><a href='#' onclick='deleteProduct({$row['idPro']})'><img src='iconoeliminar.png' width='20' heigth='20'></a></td>";
				echo "<td><a href='#' onclick='openEditProduct({$row['idPro']}, \"{$row['Nombre']}\", {$row['Precio']})'> <img src='edit_icon.webp' width='20' heigth='20'> </a> </td>'";
				echo "</tr>";
			}

			echo "</tbody> </table>";
		} catch (Exception $e) {
		} finally {
			if (isset($stmt) && $stmt)
				$stmt->close();
			if (isset($conn))
				$conn->close();
		}

		?>
		<br><br>

		<!-- Modal Ventada de Nuevo Producto -->
		<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLabel">Registrar nuevo producto</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form id="saveProductForm">
							<div class="mb-3">
								<label for="productId" class="form-label">ID del producto</label>
								<input type="number" class="form-control" id="s_productId" name="id">
							</div>
							<div class="mb-3">
								<label for="productName" class="form-label">Nombre del producto</label>
								<input type="text" class="form-control" id="s_productName" name="nombre">
							</div>
							<div class="mb-3">
								<label for="productPrice" class="form-label">Precio</label>
								<input type="number" class="form-control" id="s_productPrice" name="precio" step="0.01">
							</div>
							<div class="mb-3">
								<label for="productExt" class="form-label">Existencias del producto</label>
								<input type="number" class="form-control" id="s_productExt" name="existencia">
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-success" onclick="saveProduct()">Guardar </button>
					</div>
				</div>
			</div>
		</div>

		<!-- Modal Ventana de Editar Producto -->
		<div class="modal fade" id="editProductModal" tabindex="-1" aria-labelledby="editProductModalLabel" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="editProductModalLabel">Editar producto</h5>
						<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
					</div>
					<div class="modal-body">
						<form id="editProductForm">
							<input type="hidden" id="productId" name="idPro">
							<div class="mb-3">
								<label for="productName" class="form-label">Nombre del producto</label>
								<input type="text" class="form-control" id="productName" name="Nombre">
							</div>
							<div class="mb-3">
								<label for="productPrice" class="form-label">Precio</label>
								<input type="number" class="form-control" id="productPrice" name="Precio" step="0.01">
							</div>
						</form>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
						<button type="button" class="btn btn-success" onclick="updateProduct()">Guardar</button>
					</div>
				</div>
			</div>
		</div>

	</center>

	<!-- Footer -->
	<footer class="footer bg-dark">
		<div class="container">
			<p class="m-0 text-center text-white"><b> UC: Desarrollo de aplicaciones web y móviles [ Dr. Christian Mauricio Castillo Estrada ] </b></p>
		</div>
	</footer>

</body>

</html>
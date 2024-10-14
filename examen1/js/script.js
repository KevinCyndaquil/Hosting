function openEditProduct(idPro, nombre, precio) {
    console.log(idPro + " " + nombre + " " + precio);   

    document.getElementById('productId').value = idPro;
    document.getElementById('productName').value = nombre;
    document.getElementById('productPrice').value = precio;

    var edit_modal = new bootstrap.Modal(document.getElementById('editProductModal'));
    edit_modal.show();
}

function saveProduct() {
    const data = {
        id: document.getElementById('s_productId').value,
        nombre: document.getElementById('s_productName').value,
        precio: document.getElementById('s_productPrice').value,
        existencia: document.getElementById('s_productExt').value,
    };

    fetch('controller/insertar.php', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded' 
		},
		body: new URLSearchParams(data)
	})
	.then(response => response.json())
	.then(result => {
		console.log(result);
		if (!result.success) {
			console.log("Error ", result.error);
			return;
		}
		console.log("Producto insertado correctamente");

        var edit_model = document.getElementById('exampleModal');
        var modal = bootstrap.Modal.getInstance(edit_model);
        modal.hide(); // Cierra el modal

		window.location.reload();
	})
	.catch(error => {
		console.error('Error en la solicitud:', error); 
	});
}

function updateProduct() {
    const data = {
        id: document.getElementById('productId').value,
        nombre: document.getElementById('productName').value,
        precio: document.getElementById('productPrice').value,
    };

    fetch('controller/actualizar.php', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded' 
		},
		body: new URLSearchParams(data)
	})
	.then(response => response.json())
	.then(result => {
		console.log(result);
		if (!result.success) {
			console.log("Error ", result.error);
			return;
		}
		console.log("Producto actualizado correctamente");

        var edit_model = document.getElementById('editProductModal');
        var modal = bootstrap.Modal.getInstance(edit_model);
        modal.hide(); // Cierra el modal

		window.location.reload();
	})
	.catch(error => {
		console.error('Error en la solicitud:', error); 
	});
}

function deleteProduct(id) {
	const data = {
        id: id
    };

    fetch('controller/eliminar.php', {
		method: 'POST',
		headers: {
			'Content-Type': 'application/x-www-form-urlencoded' 
		},
		body: new URLSearchParams(data)
	})
	.then(response => response.json())
	.then(result => {
		console.log(result);
		if (!result.success) {
			console.log("Error ", result.error);
			return;
		}
		console.log("Producto eliminado correctamente");

		window.location.reload();
	})
	.catch(error => {
		console.error('Error en la solicitud:', error); 
	});
}
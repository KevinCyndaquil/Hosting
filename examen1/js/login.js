document.addEventListener('DOMContentLoaded', function() {
	document.getElementById('login').addEventListener('click', login);
});

// Function to login a user
function login(){
	const data = {
		usr: document.getElementById('loginUsername').value,
		passwd: document.getElementById('loginPassword').value,
	};

	fetch('controller/validar.php', {
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
		console.log("Usuario ", result.user.NomUser , " autenticado correctamente");
		window.location = "dashboard.php?username=" + result.user.NomUser;
	})
	.catch(error => {
		console.error('Error en la solicitud:', error); 
	});
}

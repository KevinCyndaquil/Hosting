function makeRFC() {
    const nombre = document.getElementById("nombre").value.toUpperCase()
        .match(/^[A-Z]{2,}( [A-Z]{2,})?$/);
    const apellido_p = document.getElementById("apellido_p").value.toUpperCase()
        .match(/[A-Z]{2,}/);
    const apellido_m = document.getElementById("apellido_m").value.toUpperCase()
        .match(/[A-Z]{2,}/);
    const nacimiento = new Date(document.getElementById("nacimiento").value);

    if (!nombre || !apellido_p || !apellido_m){
        alert("Nombre Introducido invalido");
        return;
    }

    const vocal = apellido_p[0].match(/[AEIOU]/);

    let RFC = apellido_p[0].slice(0, 1) + (vocal ? vocal[0] : apellido_p[0].slice(1, 2));
    RFC += apellido_m[0].slice(0, 1);
    RFC += nombre[0].slice(0, 1);
    RFC += nacimiento.getFullYear().toString().slice(-2);
    RFC += ("0" + (nacimiento.getMonth() + 1)).slice(-2);
    RFC += ("0" + (nacimiento.getDate() + 1)).slice(-2);

    document.getElementById('rfc_place').textContent = RFC;
    console.log(RFC);
}

var n_user = 1;

function nextUsr() {
    if (n_user == 10){
        n_user = 1;
        return;
    }
    ++n_user;
}

function getUsr() {
    fetch('https://jsonplaceholder.typicode.com/users/' + n_user)
        .then(response => {
            if (response.ok)
                return response.json();
            throw new Error('API response was not OK');
        })
        .then(data => {
            document.getElementById('api_name').textContent = data.name;
            document.getElementById('api_email').textContent = data.email;
            console.log(n_user);
            nextUsr();
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}
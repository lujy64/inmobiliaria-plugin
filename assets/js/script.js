/*
Plugin Name: Inmobiliaria Plugin
Plugin URI:  
Description: Plugin para gestionar inmuebles y mostrar listados en WordPress.
Version: 1.0
Author: the Panther Soft (Maria Lujan Vaira)
Author URI: https://thepanthersoft.com/
*/

document.addEventListener("DOMContentLoaded", function () {
    const buscadorForm = document.getElementById("buscador-inmuebles");
    const resultadoBusqueda = document.getElementById("resultado-busqueda");

    buscadorForm.addEventListener("submit", function (e) {
        e.preventDefault(); // Evita recargar la página

        let formData = new FormData(buscadorForm);
        formData.append("action", "listado_inmuebles");

        fetch(ajaxurl.url, {
            method: "POST",
            body: new URLSearchParams(formData),
            headers: { "Content-Type": "application/x-www-form-urlencoded" }
        })
        .then(response => response.json())
        .then(data => {
            resultadoBusqueda.innerHTML = data.html;
        })
        .catch(error => console.error("Error en la búsqueda:", error));
    });
});

/*
Plugin Name: Inmobiliaria Plugin
Plugin URI:  
Description: Plugin para gestionar inmuebles y mostrar listados en WordPress.
Version: 1.0
Author: the Panther Soft (Maria Lujan Vaira)
Author URI: https://thepanthersoft.com/
*/

jQuery(document).ready(function ($) {
    let frame;
    const button = $('#abrir-galeria');
    const input = $('#inmueble_gallery');
    const preview = $('#vista-previa-galeria');

    button.on('click', function (e) {
        e.preventDefault();

        // Abrir la biblioteca de medios
        if (!frame) {
            frame = wp.media({
                title: 'Seleccionar Imágenes',
                button: {
                    text: 'Agregar a la galería'
                },
                multiple: true // Permitir selección múltiple
            });

            // Selección de imágenes
            frame.on('select', function () {
                const attachments = frame.state().get('selection').toJSON();
                const ids = [];
                preview.empty(); // Limpiar la vista previa

                attachments.forEach(function (attachment) {
                    ids.push(attachment.id); // Obtener el ID de la imagen
                    const url = attachment.sizes.thumbnail.url; // URL de la miniatura
                    preview.append('<img src="' + url + '" style="width: 100px; height: auto; border: 1px solid #ddd; margin-right: 5px;">');
                });

                input.val(ids.join(',')); // Guardar los IDs en el input oculto
            });
        }

        frame.open();
    });
    document.getElementById("buscador-inmuebles").addEventListener("submit", function (e) {
        e.preventDefault(); // Evitar el envío tradicional del formulario

        let formData = new FormData(this);

        fetch(ajaxurl, {
            method: "POST",
            body: new URLSearchParams(formData),
            headers: {
                "Content-Type": "application/x-www-form-urlencoded",
            },
        })
        .then(response => response.json())
        .then(data => {
            let resultadosHTML = "";
            data.forEach(inmueble => {
                resultadosHTML += `
                    <div class="inmueble-card">
                        <a href="${inmueble.url}">
                            <img src="${inmueble.imagen}" alt="${inmueble.titulo}" />
                            <h3>${inmueble.titulo}</h3>
                            <p>Precio: US$ ${inmueble.precio}</p>
                        </a>
                    </div>
                `;
            });
            document.getElementById("resultado-busqueda").innerHTML = resultadosHTML;
        })
        .catch(error => console.error("Error:", error));
    });
    
});

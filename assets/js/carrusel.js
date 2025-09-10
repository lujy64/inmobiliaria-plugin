/*
Plugin Name: Inmobiliaria Plugin
Plugin URI:  
Description: Plugin para gestionar inmuebles y mostrar listados en WordPress.
Version: 1.0
Author: the Panther Soft (Maria Lujan Vaira)
Author URI: https://thepanthersoft.com/
*/

document.addEventListener('DOMContentLoaded', function () {
    const carousels = document.querySelectorAll('.inmueble-carousel');

    carousels.forEach(function (carousel) {
        const imagesContainer = carousel.querySelector('.carousel-images');
        const images = carousel.querySelectorAll('.carousel-images img');
        const prevButton = carousel.querySelector('.carousel-prev');
        const nextButton = carousel.querySelector('.carousel-next');
        let currentIndex = 0;

        function updateCarousel() {
            if (images.length > 0) {
                const imageWidth = images[0].clientWidth;
                const offset = -currentIndex * imageWidth;
                imagesContainer.style.transform = `translateX(${offset}px)`;
            }
        }

        prevButton.addEventListener('click', function () {
            currentIndex = (currentIndex - 1 + images.length) % images.length;
            updateCarousel();
        });

        nextButton.addEventListener('click', function () {
            currentIndex = (currentIndex + 1) % images.length;
            updateCarousel();
        });
    });
    document.getElementById("buscador-inmuebles").addEventListener("submit", function (e) {
        e.preventDefault(); // Evitar recargar la página

        let formData = new FormData(this);

        fetch(ajaxurl.url, {
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

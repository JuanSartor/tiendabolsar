
setTimeout(() => {
    let alertBox = document.querySelector('.alert');
    if (alertBox) {
        alertBox.style.transition = "opacity 1s ease-out"; // Transición suave
        alertBox.style.opacity = "0"; // Se desvanece
        setTimeout(() => {
            alertBox.remove(); // Elimina después de la animación
        }, 1000); // Espera que termine la animación (1s)
    }
}, 3000); // Inicia después de 3 segundos




function toggleFields() {
    var envioDomicilio = document.querySelector('input[name="tipo_envio"][value="envioDomicilio"]');
    //  var envioSucursal = document.querySelector('input[name="tipo_envio"][value="envioSucursal"]');
    var coordinarEnvio = document.querySelector('input[name="tipo_envio"][value="coordinarEnvio"]');

    if (envioDomicilio.checked) {
        document.getElementById('dir_env').style.display = 'block';
        document.getElementById("provincia").setAttribute("required", "true");
        document.getElementById("localidad").setAttribute("required", "true");
        document.getElementById("direccion").setAttribute("required", "true");

    }/* else if (envioSucursal.checked) {
     document.getElementById('dir_env').style.display = 'block';
     document.getElementById("provincia").setAttribute("required", "true");
     document.getElementById("localidad").setAttribute("required", "true");
     document.getElementById("direccion").setAttribute("required", "true");
     } */ else if (coordinarEnvio.checked) {
        document.getElementById('dir_env').style.display = 'none';

        document.getElementById("direccion").removeAttribute("required");
        document.getElementById("localidad").removeAttribute("required");
        document.getElementById("provincia").removeAttribute("required");
    }

}
;


// para el carrousel
let currentIndex = 0;
let autoplayInterval;

function slideCarousel(direction) {
    const carousel = document.getElementById('carousel');
    const items = carousel.children.length;
    const itemsPerPage = 3;
    const slideWidth = carousel.clientWidth / itemsPerPage;

    currentIndex += direction;

    // 🔁 Loop infinito
    if (currentIndex < 0) {
        currentIndex = items - itemsPerPage;
    }
    if (currentIndex > items - itemsPerPage) {
        currentIndex = 0;
    }

    carousel.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
}

function startAutoplay() {
    autoplayInterval = setInterval(() => {
        slideCarousel(1);
    }, 3000);
}

function stopAutoplay() {
    clearInterval(autoplayInterval);
}

document.addEventListener('DOMContentLoaded', () => {
    startAutoplay();

    const carousel = document.getElementById('carousel');
    carousel.addEventListener('mouseenter', stopAutoplay);
    carousel.addEventListener('mouseleave', startAutoplay);
    carousel.addEventListener('touchstart', stopAutoplay);
    carousel.addEventListener('touchend', startAutoplay);
});

// navbar-navigation.js

document.addEventListener('DOMContentLoaded', function () {
    const backButton = document.getElementById('nav-back');
    const forwardButton = document.getElementById('nav-forward');

    if (backButton) {
        backButton.addEventListener('click', function (e) {
            e.preventDefault();
            window.history.back(); // o tu lógica personalizada aquí
        });
    }

    if (forwardButton) {
        forwardButton.addEventListener('click', function (e) {
            e.preventDefault();
            window.history.forward(); // o tu lógica personalizada aquí
        });
    }
});

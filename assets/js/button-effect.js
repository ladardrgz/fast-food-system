document.querySelectorAll('.button').forEach(button => {
    let div = document.createElement('div'),
        letters = button.textContent.trim() || button.classList.contains('btn-login') ? 'Ingresar' :
            button.classList.contains('btn-registrarse') ? 'Registrarse' :
                'Olvidé mi contraseña';

    letters = letters.split('');
    div.style.display = "inline-block";
    div.style.width = "100%";

    letters.forEach((letter, index, array) => {
        let span = document.createElement('span'),
            part = (index >= array.length / 2) ? -1 : 1,
            position = (index >= array.length / 2) ? array.length / 2 - index + (array.length / 2 - 1) : index,
            move = position / (array.length / 2),
            rotate = 1 - move;

        span.innerHTML = !letter.trim() ? '&nbsp;' : letter;
        span.style.setProperty('--move', move);
        span.style.setProperty('--rotate', rotate);
        span.style.setProperty('--part', part);
        div.appendChild(span);
    });

    button.innerHTML = '';
    button.appendChild(div);
});
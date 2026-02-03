import { mostrarExito, mostrarError } from './alertas.js';

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('loginForm');

  form.addEventListener('submit', e => {
    e.preventDefault();

    const usuario = document.getElementById('usuario').value.trim();
    const contrasena = document.getElementById('contrasena').value.trim();

    if (!usuario || !contrasena) {
      mostrarError('Campos incompletos', 'Por favor completá todos los campos.');
      return;
    }

    fetch('/FastFoodSystem/index.php?controller=Login&action=loginApi', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ usuario, contrasena })
    })
      .then(res => {
        console.log('Respuesta fetch:', res);
        return res.json();
      })
      .then(data => {
        console.log('JSON parseado:', data);

        if (data.success) {
          mostrarExito('¡Bienvenido!', data.message).then(() => {
            window.location.href = '/FastFoodSystem/index.php?controller=Panel&action=dashboard';
          });
        } else {
          mostrarError('Error de autenticación', data.message || 'Usuario o contraseña incorrectos.');
        }
      })
      .catch(err => {
        console.error('Error al conectar o parsear JSON:', err);
        mostrarError('Oops...', 'No se pudo conectar con el servidor.');
      });
  });
});

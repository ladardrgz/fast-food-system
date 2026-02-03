import {
  mostrarExito,
  mostrarError,
  mostrarConfirmacion
} from '/FastFoodSystem/assets/js/alertas.js';

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('formEditarContrasena');
  if (!form) return;

  const actual = document.getElementById('actual');
  const nueva = document.getElementById('nueva');
  const confirmar = document.getElementById('confirmar');

  const mostrarErrorCampo = (campo, mensaje) => {
    campo.classList.add('is-invalid');
    campo.classList.remove('is-valid');
    campo.nextElementSibling.textContent = mensaje;
  };

  const limpiarErrorCampo = (campo) => {
    campo.classList.remove('is-invalid');
    campo.classList.add('is-valid');
    campo.nextElementSibling.textContent = '';
  };

  const validarPassword = (input, nombreCampo) => {
    const valor = input.value.trim();
    if (!valor) {
      mostrarErrorCampo(input, `La ${nombreCampo} es obligatoria`);
      return false;
    }
    if (valor.length < 8 || valor.length > 32) {
      mostrarErrorCampo(input, `${nombreCampo.charAt(0).toUpperCase() + nombreCampo.slice(1)} debe tener entre 8 y 32 caracteres`);
      return false;
    }
    limpiarErrorCampo(input);
    return true;
  };

  const validarConfirmacion = () => {
    const valorNueva = nueva.value.trim();
    const valorConfirma = confirmar.value.trim();

    if (!valorConfirma) {
      mostrarErrorCampo(confirmar, 'Debe confirmar la contraseña');
      return false;
    }

    if (valorNueva !== valorConfirma) {
      mostrarErrorCampo(confirmar, 'Las contraseñas no coinciden');
      return false;
    }

    limpiarErrorCampo(confirmar);
    return true;
  };

  const validarFormulario = () => {
    let valido = true;
    if (!validarPassword(actual, 'contraseña actual')) valido = false;
    if (!validarPassword(nueva, 'nueva contraseña')) valido = false;
    if (!validarConfirmacion()) valido = false;
    return valido;
  };

  actual.addEventListener('input', () => validarPassword(actual, 'contraseña actual'));
  nueva.addEventListener('input', () => validarPassword(nueva, 'nueva contraseña'));
  confirmar.addEventListener('input', validarConfirmacion);

  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    if (!validarFormulario()) {
      const primero = form.querySelector('.is-invalid');
      if (primero) primero.focus();
      return;
    }

    const datos = {
      actual: actual.value.trim(),
      nueva: nueva.value.trim(),
      confirmar: confirmar.value.trim()
    };

    Swal.fire({
      title: '¿Deseás actualizar tu contraseña?',
      text: 'Esta acción modificará tu acceso al sistema.',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonText: 'Sí, actualizar',
      cancelButtonText: 'Cancelar'
    }).then(async (result) => {
      if (!result.isConfirmed) return;

      try {
        const respuesta = await fetch('index.php?controller=usuario&action=guardarCambioContrasena', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify(datos)
        });

        const contenido = await respuesta.text();

        let resultado;
        try {
          resultado = JSON.parse(contenido);
        } catch (error) {
          console.error('Respuesta no válida del servidor:', contenido);
          Swal.fire('Error', 'Respuesta inesperada del servidor.', 'error');
          return;
        }

        if (resultado.exito) {
          Swal.fire({
            icon: 'success',
            title: '¡Contraseña actualizada!',
            text: resultado.mensaje
          }).then(() => {
            window.location.href = 'index.php?controller=usuario&action=administrarCuenta';
          });
        } else if (resultado.errores) {
          Object.entries(resultado.errores).forEach(([campo, mensaje]) => {
            const input = document.getElementById(campo);
            if (input) mostrarErrorCampo(input, mensaje);
          });
        } else {
          Swal.fire('Error', 'No se pudo actualizar la contraseña.', 'error');
        }
      } catch (error) {
        console.error('Error al cambiar contraseña:', error);
        Swal.fire('Error', 'Ocurrió un error inesperado al intentar guardar.', 'error');
      }
    });
  });
});

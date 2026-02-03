import {
  mostrarExito,
  mostrarError as mostrarErrorSwal,
  mostrarConfirmacion
} from '/FastFoodSystem/assets/js/alertas.js';

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('formEditarPerfil');
  if (!form) return;

  const nombre = document.getElementById('nombre');
  const apellido = document.getElementById('apellido');
  const fechaNacimiento = document.getElementById('fechaNacimiento');
  const genero = document.getElementById('genero');
  const usuario = document.getElementById('usuario');

  const fechaMin = new Date('1925-01-01');
  const fechaMax = new Date('2007-12-31');

  // Marca el campo con error y muestra el mensaje
  const mostrarErrorCampo = (campo, mensaje) => {
    campo.classList.add('is-invalid');
    campo.classList.remove('is-valid');
    campo.nextElementSibling.textContent = mensaje;
  };

  // Limpia errores de validación del campo
  const limpiarError = (campo) => {
    campo.classList.remove('is-invalid');
    campo.classList.add('is-valid');
    campo.nextElementSibling.textContent = '';
  };

  const soloLetras = /^[A-Za-zÁÉÍÓÚáéíóúñÑ\s]+$/;

  const validarTexto = (input, campoNombre) => {
    const valor = input.value.trim();
    if (!valor) {
      mostrarErrorCampo(input, `El campo ${campoNombre} es obligatorio`);
      return false;
    }
    if (!soloLetras.test(valor)) {
      mostrarErrorCampo(input, `El campo ${campoNombre} solo debe contener letras`);
      return false;
    }
    limpiarError(input);
    return true;
  };

  const validarFecha = () => {
    const valor = fechaNacimiento.value;
    const fecha = new Date(valor);
    if (!valor || isNaN(fecha)) {
      mostrarErrorCampo(fechaNacimiento, 'Fecha inválida');
      return false;
    }
    if (fecha < fechaMin || fecha > fechaMax) {
      mostrarErrorCampo(fechaNacimiento, 'Debes ingresar una fecha entre 1925 y 2007');
      return false;
    }
    limpiarError(fechaNacimiento);
    return true;
  };

  const validarGenero = () => {
    if (!genero.value) {
      mostrarErrorCampo(genero, 'Debe seleccionar un género');
      return false;
    }
    limpiarError(genero);
    return true;
  };

  const validarUsuario = () => {
    const valor = usuario.value.trim();
    if (!valor) {
      mostrarErrorCampo(usuario, 'El nombre de usuario es obligatorio');
      return false;
    }
    if (valor.length < 4 || valor.length > 20) {
      mostrarErrorCampo(usuario, 'Debe tener entre 4 y 20 caracteres');
      return false;
    }
    limpiarError(usuario);
    return true;
  };

  const validarFormulario = () => {
    let valido = true;
    if (!validarTexto(nombre, 'nombre')) valido = false;
    if (!validarTexto(apellido, 'apellido')) valido = false;
    if (!validarFecha()) valido = false;
    if (!validarGenero()) valido = false;
    if (!validarUsuario()) valido = false;
    return valido;
  };

  // Validaciones en tiempo real
  nombre.addEventListener('input', () => validarTexto(nombre, 'nombre'));
  apellido.addEventListener('input', () => validarTexto(apellido, 'apellido'));
  fechaNacimiento.addEventListener('input', validarFecha);
  genero.addEventListener('change', validarGenero);
  usuario.addEventListener('input', validarUsuario);

  // Envío con fetch
  form.addEventListener('submit', async (e) => {
    e.preventDefault();

    if (!validarFormulario()) {
      const primero = form.querySelector('.is-invalid');
      if (primero) primero.focus();
      return;
    }

    const datos = {
      nombre: nombre.value.trim(),
      apellido: apellido.value.trim(),
      fechaNacimiento: fechaNacimiento.value,
      genero: genero.value,
      usuario: usuario.value.trim()
    };

    try {
      const respuesta = await fetch('index.php?controller=usuario&action=guardarEdicionPerfil', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(datos)
      });

      const resultado = await respuesta.json();

      if (resultado.success) {
        Swal.fire({
          icon: 'success',
          title: '¡Perfil actualizado!',
          text: resultado.message,
          confirmButtonText: 'Aceptar'
        }).then(() => {
          window.location.href = 'index.php?controller=usuario&action=administrarCuenta';
        });
      } else if (resultado.errores) {
        Object.entries(resultado.errores).forEach(([campo, mensaje]) => {
          const input = document.getElementById(campo);
          if (input) mostrarErrorCampo(input, mensaje);
        });

        Swal.fire({
          icon: 'error',
          title: 'Revisá los campos',
          text: 'Algunos datos ingresados no son válidos.'
        });
      } else {
        Swal.fire('Error', 'No se pudo guardar el perfil.', 'error');
      }
    } catch (error) {
      console.error('Error al guardar:', error);
      Swal.fire('Error', 'Ocurrió un error al guardar los cambios.', 'error');
    }
  });
});

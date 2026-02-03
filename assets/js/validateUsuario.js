import { mostrarExito, mostrarError } from './alertas.js';

document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('registroForm');
  if (!form) return;

  form.setAttribute('novalidate', true);

  const inputs = form.querySelectorAll('input:not([type="hidden"]):not([type="submit"]):not([type="checkbox"])');
  const selects = form.querySelectorAll('select');

  const fechaInput = document.getElementById('fechaNacimiento');
  const tipoDoc = document.getElementById('tipoDoc');
  const valorDoc = document.getElementById('valorDoc');
  const tipoCont = document.getElementById('tipoCont');
  const valorCont = document.getElementById('valorCont');
  const pass = document.getElementById('contrasena');
  const confirm = document.getElementById('confirmContrasena');
  const genero = document.getElementById('genero');

  const fechaMin = new Date('1925-01-01');
  const fechaMax = new Date('2007-12-31');

  const mostrarErrorCampo = (input, mensaje) => {
    input.classList.add('is-invalid');
    input.classList.remove('is-valid');
    let feedback = input.parentElement.querySelector('.invalid-feedback');
    if (!feedback) {
      feedback = document.createElement('div');
      feedback.className = 'invalid-feedback';
      input.parentElement.appendChild(feedback);
    }
    feedback.textContent = mensaje;
  };

  const limpiarError = (input) => {
    input.classList.remove('is-invalid');
    input.classList.add('is-valid');
    const feedback = input.parentElement.querySelector('.invalid-feedback');
    if (feedback) feedback.textContent = '';
  };

  const validarCampo = (input) => {
    if (input.value.trim() === '') {
      mostrarErrorCampo(input, 'Este campo es obligatorio');
      return false;
    }
    limpiarError(input);
    return true;
  };

  const validarSelect = (select) => {
    if (!select.value || select.value === '') {
      mostrarErrorCampo(select, 'Debe seleccionar una opción');
      return false;
    }
    limpiarError(select);
    return true;
  };

  const validarFecha = () => {
    const valor = fechaInput.value;
    const fecha = new Date(valor);
    if (!valor || isNaN(fecha)) {
      mostrarErrorCampo(fechaInput, 'Fecha inválida');
      return false;
    }
    if (fecha < fechaMin || fecha > fechaMax) {
      mostrarErrorCampo(fechaInput, 'Debes ser mayor de edad');
      return false;
    }
    limpiarError(fechaInput);
    return true;
  };

  const validarDocumento = () => {
    const valor = valorDoc.value.trim();
    const tipo = parseInt(tipoDoc.value, 10);

    if (!valor) {
      mostrarErrorCampo(valorDoc, 'Este campo es obligatorio');
      return false;
    }

    switch (tipo) {
      case 1:
        if (!/^\d{8}$/.test(valor)) {
          mostrarErrorCampo(valorDoc, 'DNI inválido. Ej: 12345678');
          return false;
        }
        break;
      case 2:
        if (!/^9\d{10}$/.test(valor)) {
          mostrarErrorCampo(valorDoc, 'CDI inválido. Debe comenzar con 9 y tener 11 dígitos');
          return false;
        }
        break;
      case 3:
        if (!/^(20|23|24|27|30|33|34)\d{8}$/.test(valor)) {
          mostrarErrorCampo(valorDoc, 'CUIT inválido. Ej: 20304567891');
          return false;
        }
        break;
      case 4:
        if (!/^\d{11}$/.test(valor)) {
          mostrarErrorCampo(valorDoc, 'CUIL inválido. Ej: 20123456789');
          return false;
        }
        break;
      case 5:
        if (!/^\d{8}[A-Za-z]?$/.test(valor)) {
          mostrarErrorCampo(valorDoc, 'DNIe inválido. Ej: 12345678 o 12345678A');
          return false;
        }
        break;
      case 6:
        if (!/^\d{7,8}$/.test(valor)) {
          mostrarErrorCampo(valorDoc, 'LC inválido. Debe tener 7 u 8 dígitos');
          return false;
        }
        break;
      default:
        mostrarErrorCampo(valorDoc, 'Tipo de documento no reconocido');
        return false;
    }

    limpiarError(valorDoc);
    return true;
  };

  const validarContacto = () => {
    const valor = valorCont.value.trim();
    const tipo = parseInt(tipoCont.value, 10);

    if (!valor) {
      mostrarErrorCampo(valorCont, 'Este campo es obligatorio');
      return false;
    }

    if (tipo === 1) {
      const emailRegex = /^[\w.%+-]+@(gmail\.com|hotmail\.com|outlook\.com|protonmail\.com|yahoo\.com)$/;
      if (!emailRegex.test(valor)) {
        mostrarErrorCampo(valorCont, 'Correo inválido. Solo dominios permitidos');
        return false;
      }
    } else if ([2, 3, 4].includes(tipo)) {
      const telRegex = /^\d{4}-\d{6}$/;
      if (!telRegex.test(valor)) {
        mostrarErrorCampo(valorCont, 'Número inválido. Ej: 3704-123456');
        return false;
      }
    }

    limpiarError(valorCont);
    return true;
  };

  const validarPasswords = () => {
    if (pass.value.length < 8) {
      mostrarErrorCampo(pass, 'La contraseña debe tener al menos 8 caracteres');
      return false;
    }

    if (pass.value !== confirm.value) {
      mostrarErrorCampo(confirm, 'Las contraseñas no coinciden');
      return false;
    }

    limpiarError(pass);
    limpiarError(confirm);
    return true;
  };

  const validarFormulario = () => {
    let valido = true;

    inputs.forEach(input => {
      if (!validarCampo(input)) valido = false;
    });

    selects.forEach(select => {
      if (!validarSelect(select)) valido = false;
    });

    if (!validarSelect(genero)) valido = false;
    if (!validarFecha()) valido = false;
    if (!validarDocumento()) valido = false;
    if (!validarContacto()) valido = false;
    if (!validarPasswords()) valido = false;

    return valido;
  };

  // Validación en tiempo real
  inputs.forEach(input => input.addEventListener('input', () => validarCampo(input)));
  selects.forEach(select => select.addEventListener('change', () => validarSelect(select)));
  genero.addEventListener('change', () => validarSelect(genero));
  valorDoc.addEventListener('input', validarDocumento);
  valorCont.addEventListener('input', validarContacto);
  fechaInput.addEventListener('input', validarFecha);
  pass.addEventListener('input', validarPasswords);
  confirm.addEventListener('input', validarPasswords);

  form.addEventListener('submit', async e => {
    e.preventDefault();
    const esValido = validarFormulario();

    if (!esValido) {
      const primerInvalido = form.querySelector('.is-invalid');
      if (primerInvalido) primerInvalido.focus();
      return;
    }

    const payload = {
      nombre: document.getElementById('nombre').value.trim(),
      apellido: document.getElementById('apellido').value.trim(),
      fechaNacimiento: fechaInput.value,
      genero: genero.value,
      calle: document.getElementById('calle').value.trim(),
      numero: document.getElementById('numero').value.trim(),
      piso: document.getElementById('piso').value.trim(),
      dpto: document.getElementById('dpto').value.trim(),
      barrio: document.getElementById('barrio').value,
      tipoDoc: tipoDoc.value,
      valorDoc: valorDoc.value.trim(),
      tipoCont: tipoCont.value,
      valorCont: valorCont.value.trim(),
      usuario: document.getElementById('usuario').value.trim(),
      contrasena: pass.value,
      perfil: document.getElementById('perfil').value
    };

    try {
      const response = await fetch('index.php?controller=usuario&action=crear', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify(payload)
      });

      const data = await response.json();

      if (data.success) {
        Swal.fire({
          icon: 'success',
          title: 'Registro exitoso',
          text: data.message || 'Tu cuenta ha sido creada correctamente.',
          confirmButtonText: 'Aceptar'
        });

        form.reset();
        [...inputs, ...selects].forEach(el => el.classList.remove('is-valid', 'is-invalid'));

      } else {
        Swal.fire({
          icon: 'error',
          title: 'Error en el registro',
          text: data.message || 'Hubo un problema al registrar tu cuenta.',
          confirmButtonText: 'Reintentar'
        });
      }

    } catch (error) {
      console.error('Error al enviar datos:', error);
      Swal.fire({
        icon: 'error',
        title: 'Error de conexión',
        text: 'No se pudo conectar con el servidor o la respuesta no fue válida.',
        confirmButtonText: 'Cerrar'
      });
    }
  });
});

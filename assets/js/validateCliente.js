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
    const genero = document.getElementById('genero');
    const pass = document.getElementById('contrasena');
    const confirm = document.getElementById('confirmContrasena');

    const fechaMin = new Date('1925-01-01');
    const fechaMax = new Date('2007-12-31');

    const mostrarCampoError = (input, mensaje) => {
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

    const limpiarCampoError = (input) => {
        input.classList.remove('is-invalid');
        input.classList.add('is-valid');
        const feedback = input.parentElement.querySelector('.invalid-feedback');
        if (feedback) feedback.textContent = '';
    };

    const validarCampo = (input) => {
        const valor = input.value.trim();
        if (!valor) {
            mostrarCampoError(input, 'Este campo es obligatorio');
            return false;
        }
        limpiarCampoError(input);
        return true;
    };

    const validarSelect = (select) => {
        if (!select.value || select.value === '') {
            mostrarCampoError(select, 'Debe seleccionar una opción');
            return false;
        }
        limpiarCampoError(select);
        return true;
    };

    const validarFecha = () => {
        const valor = fechaInput.value;
        const fecha = new Date(valor);
        if (!valor || isNaN(fecha)) {
            mostrarCampoError(fechaInput, 'Fecha inválida');
            return false;
        }
        if (fecha < fechaMin || fecha > fechaMax) {
            mostrarCampoError(fechaInput, 'Debes ser mayor de edad');
            return false;
        }
        limpiarCampoError(fechaInput);
        return true;
    };

    const validarDocumento = () => {
        const valor = valorDoc.value.trim();
        const tipo = parseInt(tipoDoc.value);

        if (!valor) {
            mostrarCampoError(valorDoc, 'Este campo es obligatorio');
            return false;
        }

        switch (tipo) {
            case 1:
                if (!/^\d{8}$/.test(valor)) {
                    mostrarCampoError(valorDoc, 'DNI inválido. Ej: 12345678');
                    return false;
                }
                break;
            case 2:
                if (!/^9\d{10}$/.test(valor)) {
                    mostrarCampoError(valorDoc, 'CDI inválido. Debe comenzar con 9 y tener 11 dígitos');
                    return false;
                }
                break;
            case 3:
                if (!/^(20|23|24|27|30|33|34)\d{8}$/.test(valor)) {
                    mostrarCampoError(valorDoc, 'CUIT inválido. Ej: 20304567891');
                    return false;
                }
                break;
            case 4:
                if (!/^\d{11}$/.test(valor)) {
                    mostrarCampoError(valorDoc, 'CUIL inválido. Ej: 20123456789');
                    return false;
                }
                break;
            case 5:
                if (!/^\d{8}[A-Za-z]?$/.test(valor)) {
                    mostrarCampoError(valorDoc, 'DNIe inválido. Ej: 12345678 o 12345678A');
                    return false;
                }
                break;
            case 6:
                if (!/^\d{7,8}$/.test(valor)) {
                    mostrarCampoError(valorDoc, 'LC inválido. Debe tener 7 u 8 dígitos');
                    return false;
                }
                break;
            default:
                mostrarCampoError(valorDoc, 'Tipo de documento no reconocido');
                return false;
        }

        limpiarCampoError(valorDoc);
        return true;
    };

    const validarContacto = () => {
        const valor = valorCont.value.trim();
        const tipo = parseInt(tipoCont.value);

        if (!valor) {
            mostrarCampoError(valorCont, 'Este campo es obligatorio');
            return false;
        }

        if (tipo === 1) {
            const emailRegex = /^[\w.%+-]+@(gmail\.com|hotmail\.com|outlook\.com|protonmail\.com|yahoo\.com)$/;
            if (!emailRegex.test(valor)) {
                mostrarCampoError(valorCont, 'Correo inválido. Solo dominios permitidos');
                return false;
            }
        } else if ([2, 3, 4].includes(tipo)) {
            const telRegex = /^\d{4}-\d{6}$/;
            if (!telRegex.test(valor)) {
                mostrarCampoError(valorCont, 'Número inválido. Ej: 3704-123456');
                return false;
            }
        }

        limpiarCampoError(valorCont);
        return true;
    };

    const validarPasswords = () => {
        if (pass.value.length < 8) {
            mostrarCampoError(pass, 'Debe tener al menos 8 caracteres');
            return false;
        }
        if (pass.value !== confirm.value) {
            mostrarCampoError(confirm, 'Las contraseñas no coinciden');
            return false;
        }
        limpiarCampoError(pass);
        limpiarCampoError(confirm);
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

        if (!validarFecha()) valido = false;
        if (!validarDocumento()) valido = false;
        if (!validarContacto()) valido = false;
        if (!validarPasswords()) valido = false;

        return valido;
    };

    // Validación en tiempo real
    inputs.forEach(input => input.addEventListener('input', () => validarCampo(input)));
    selects.forEach(select => select.addEventListener('change', () => validarSelect(select)));
    fechaInput.addEventListener('input', validarFecha);
    valorDoc.addEventListener('input', validarDocumento);
    valorCont.addEventListener('input', validarContacto);
    confirm.addEventListener('input', validarPasswords);

    form.addEventListener('submit', async (e) => {
        e.preventDefault();

        const esValido = validarFormulario();
        if (!esValido) {
            const primero = form.querySelector('.is-invalid');
            if (primero) primero.focus();
            return;
        }

        const payload = {
            nombre: document.getElementById('nombre').value.trim(),
            apellido: document.getElementById('apellido').value.trim(),
            fechaNacimiento: fechaInput.value,
            calle: document.getElementById('calle').value.trim(),
            numero: document.getElementById('numero').value.trim(),
            piso: document.getElementById('piso').value.trim(),
            dpto: document.getElementById('dpto').value.trim(),
            barrio: document.getElementById('barrio').value,
            tipoDoc: tipoDoc.value,
            valorDoc: valorDoc.value.trim(),
            tipoCont: tipoCont.value,
            valorCont: valorCont.value.trim(),
            genero: genero.value, // ✅ Corregido
            contrasena: pass.value,
            perfil: 5
        };

        try {
            const res = await fetch('/FastFoodSystem/index.php?controller=Cliente&action=guardar', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify(payload)
            });

            const data = await res.json();

            if (data.success) {
                mostrarExito('Registro exitoso', data.message || 'Tu cuenta ha sido creada.');
                form.reset();
                [...inputs, ...selects].forEach(el => el.classList.remove('is-valid', 'is-invalid'));
            } else {
                mostrarError('Error', data.message || 'No se pudo registrar.');
            }
        } catch (err) {
            console.error('Error:', err);
            mostrarError('Error de conexión', 'Intentalo nuevamente más tarde.');
        }
    });
});

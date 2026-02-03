import {
    mostrarExito,
    mostrarError,
    mostrarConfirmacion
} from '/FastFoodSystem/assets/js/alertas.js';

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formBarrio');
    const lista = document.getElementById('listaBarrios');
    const input = document.getElementById('nombreBarrio');
    const selectPais = document.getElementById('selectPais');
    const selectProvincia = document.getElementById('selectProvincia');
    const selectLocalidad = document.getElementById('selectLocalidad');

    async function cargarPaises() {
        const res = await fetch('index.php?controller=pais&action=obtener');
        const data = await res.json();
        selectPais.innerHTML = '<option value="">Seleccione país</option>';
        data.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p.id_pais;
            opt.textContent = p.nombre_pais;
            selectPais.appendChild(opt);
        });
    }

    async function cargarProvincias(idPais) {
        const res = await fetch(`index.php?controller=provincia&action=obtener&id_pais=${idPais}`);
        const data = await res.json();
        selectProvincia.innerHTML = '<option value="">Seleccione provincia</option>';
        data.forEach(p => {
            const opt = document.createElement('option');
            opt.value = p.id_provincia;
            opt.textContent = p.nombre_provincia;
            selectProvincia.appendChild(opt);
        });
    }

    async function cargarLocalidades(idProvincia) {
        const res = await fetch(`index.php?controller=localidad&action=obtener&id_provincia=${idProvincia}`);
        const data = await res.json();
        selectLocalidad.innerHTML = '<option value="">Seleccione localidad</option>';
        data.forEach(l => {
            const opt = document.createElement('option');
            opt.value = l.id_localidad;
            opt.textContent = l.nombre_localidad;
            selectLocalidad.appendChild(opt);
        });
    }

    async function cargarBarrios() {
        const res = await fetch('index.php?controller=barrio&action=obtener');
        const data = await res.json();
        lista.innerHTML = '';
        data.forEach(b => {
            const li = document.createElement('li');
            li.className = 'list-group-item d-flex justify-content-between align-items-center';
            li.textContent = `${b.nombre_barrio} (${b.nombre_localidad} - ${b.nombre_provincia} - ${b.nombre_pais})`;

            const btn = document.createElement('button');
            btn.innerHTML = '<i class="bi bi-trash"></i>';
            btn.className = 'btn btn-sm btn-danger';
            btn.onclick = () => confirmarEliminacion(b.id_barrio);

            li.appendChild(btn);
            lista.appendChild(li);
        });
    }

    async function confirmarEliminacion(id) {
        const confirm = await mostrarConfirmacion('¿Eliminar barrio?', 'Esta acción no se puede deshacer.');
        if (confirm.isConfirmed) eliminarBarrio(id);
    }

    async function eliminarBarrio(id) {
        const res = await fetch('index.php?controller=barrio&action=eliminar', {
            method: 'DELETE',
            body: new URLSearchParams({ id })
        });
        const data = await res.json();
        if (data.success) {
            mostrarExito('Eliminado', data.message);
            cargarBarrios();
        } else {
            mostrarError('Error', data.message || 'No se pudo eliminar el barrio');
        }
    }

    form.addEventListener('submit', async e => {
        e.preventDefault();
        const nombre = input.value.trim();
        const idLocalidad = selectLocalidad.value;

        if (!nombre || !idLocalidad) {
            mostrarError('Campos requeridos', 'Debe completar todos los campos.');
            return;
        }

        const res = await fetch('index.php?controller=barrio&action=crear', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nombre, id_localidad: idLocalidad })
        });

        const data = await res.json();
        if (data.success) {
            mostrarExito('Agregado', data.message || 'Barrio agregado correctamente');
            form.reset();
            cargarBarrios();
        } else {
            mostrarError('Error', data.message || 'No se pudo agregar el barrio');
        }
    });

    // Eventos en cascada
    selectPais.addEventListener('change', () => {
        const idPais = selectPais.value;
        if (idPais) {
            cargarProvincias(idPais);
            selectLocalidad.innerHTML = '<option value="">Seleccione localidad</option>';
        } else {
            selectProvincia.innerHTML = '<option value="">Seleccione provincia</option>';
            selectLocalidad.innerHTML = '<option value="">Seleccione localidad</option>';
        }
    });

    selectProvincia.addEventListener('change', () => {
        const idProvincia = selectProvincia.value;
        if (idProvincia) {
            cargarLocalidades(idProvincia);
        } else {
            selectLocalidad.innerHTML = '<option value="">Seleccione localidad</option>';
        }
    });

    // Inicialización
    cargarPaises();
    cargarBarrios();
});

import {
    mostrarExito,
    mostrarError,
    mostrarConfirmacion
} from '/FastFoodSystem/assets/js/alertas.js';

const selectPais = document.getElementById('selectPais');
const selectProvincia = document.getElementById('selectProvincia');
const lista = document.getElementById('listaLocalidades');

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

async function cargarProvinciasPorPais(idPais) {
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

async function cargarLocalidades() {
    const res = await fetch('index.php?controller=localidad&action=obtener');
    const data = await res.json();
    lista.innerHTML = '';
    data.forEach(l => {
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.textContent = `${l.nombre_localidad} (${l.nombre_provincia} - ${l.nombre_pais})`;

        const btn = document.createElement('button');
        btn.innerHTML = '<i class="bi bi-trash"></i>';
        btn.className = 'btn btn-sm btn-danger';
        btn.onclick = () => confirmarEliminacion(l.id_localidad);

        li.appendChild(btn);
        lista.appendChild(li);
    });
}

async function confirmarEliminacion(id) {
    const confirm = await mostrarConfirmacion('¿Eliminar?', 'Esta acción no se puede deshacer.');
    if (confirm.isConfirmed) eliminarLocalidad(id);
}

async function eliminarLocalidad(id) {
    const res = await fetch('index.php?controller=localidad&action=eliminar', {
        method: 'DELETE',
        body: new URLSearchParams({ id })
    });
    const data = await res.json();
    if (data.success) {
        mostrarExito('Eliminado', 'Localidad eliminada correctamente');
        cargarLocalidades();
    } else {
        mostrarError('Error', data.message || 'No se pudo eliminar.');
    }
}

document.getElementById('formLocalidad').addEventListener('submit', async e => {
    e.preventDefault();
    const nombre = document.getElementById('nombreLocalidad').value.trim();
    const provincia = selectProvincia.value;

    if (!nombre || !provincia) {
        mostrarError('Campos requeridos', 'Debe completar todos los campos.');
        return;
    }

    const res = await fetch('index.php?controller=localidad&action=crear', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            nombre,
            id_provincia: provincia
        })
    });

    const data = await res.json();
    if (data.success) {
        mostrarExito('Agregado', 'Localidad registrada correctamente');
        e.target.reset();
        cargarLocalidades();
    } else {
        mostrarError('Error', data.message || 'Ya existe esa localidad.');
    }
});

selectPais.addEventListener('change', () => {
    const idPais = selectPais.value;
    if (idPais) cargarProvinciasPorPais(idPais);
    else selectProvincia.innerHTML = '<option value="">Seleccione provincia</option>';
});

cargarPaises();
cargarLocalidades();
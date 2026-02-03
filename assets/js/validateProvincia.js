import {
    mostrarExito,
    mostrarError,
    mostrarConfirmacion
} from '/FastFoodSystem/assets/js/alertas.js';

const lista = document.getElementById('listaProvincias');
const selectPais = document.getElementById('selectPais');

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

async function cargarProvincias() {
    const res = await fetch('index.php?controller=provincia&action=obtener');
    const data = await res.json();
    lista.innerHTML = '';
    data.forEach(p => {
        const li = document.createElement('li');
        li.className = 'list-group-item d-flex justify-content-between align-items-center';
        li.textContent = `${p.nombre_provincia} (${p.nombre_pais})`;

        const btn = document.createElement('button');
        btn.innerHTML = '<i class="bi bi-trash"></i>';
        btn.className = 'btn btn-sm btn-danger';
        btn.onclick = () => confirmarEliminacion(p.id_provincia);
        li.appendChild(btn);

        lista.appendChild(li);
    });
}

async function confirmarEliminacion(id) {
    const confirm = await mostrarConfirmacion('¿Eliminar provincia?', 'Esta acción no se puede deshacer.');
    if (confirm.isConfirmed) {
        eliminarProvincia(id);
    }
}

async function eliminarProvincia(id) {
    const res = await fetch('index.php?controller=provincia&action=eliminar', {
        method: 'DELETE',
        body: new URLSearchParams({
            id
        })
    });
    const data = await res.json();
    if (data.success) {
        mostrarExito('Eliminado', 'Provincia eliminada correctamente');
        cargarProvincias();
    } else {
        mostrarError('Error', data.message || 'No se pudo eliminar. Verifica que no esté en uso.');
    }
}

document.getElementById('formProvincia').addEventListener('submit', async e => {
    e.preventDefault();
    const nombre = document.getElementById('nombreProvincia').value.trim();
    const pais = selectPais.value;

    if (!nombre || !pais) {
        mostrarError('Campos requeridos', 'Debe completar todos los campos.');
        return;
    }

    const res = await fetch('index.php?controller=provincia&action=crear', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            nombre,
            id_pais: pais
        })
    });
    const data = await res.json();

    if (data.success) {
        mostrarExito('Agregado', 'Provincia registrada correctamente');
        e.target.reset();
        cargarProvincias();
    } else {
        mostrarError('Error', data.message || 'Ya existe esa provincia.');
    }
});

cargarPaises();
cargarProvincias();

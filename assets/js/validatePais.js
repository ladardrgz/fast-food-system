import {
    mostrarExito,
    mostrarError,
    mostrarConfirmacion
} from '/FastFoodSystem/assets/js/alertas.js';

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formPais');
    const lista = document.getElementById('listaPaises');
    const input = document.getElementById('nombrePais');

    function cargarPaises() {
        fetch('index.php?controller=pais&action=obtener')
            .then(res => res.json())
            .then(data => {
                lista.innerHTML = '';
                data.forEach(pais => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item d-flex justify-content-between align-items-center';
                    li.innerHTML = `<span>${pais.nombre_pais}</span>`;

                    const btn = document.createElement('button');
                    btn.innerHTML = '<i class="bi bi-trash"></i>';
                    btn.className = 'btn btn-sm btn-danger';
                    btn.onclick = () => confirmarEliminacion(pais.id_pais);
                    li.appendChild(btn);

                    lista.appendChild(li);
                });
            });
    }

    async function confirmarEliminacion(id) {
        const confirm = await mostrarConfirmacion('¿Eliminar país?', 'Esta acción no se puede deshacer.');
        if (confirm.isConfirmed) eliminarPais(id);
    }

    function eliminarPais(id) {
        fetch('index.php?controller=pais&action=eliminar', {
            method: 'DELETE',
            body: new URLSearchParams({
                id
            })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mostrarExito('Eliminado', data.message);
                    cargarPaises();
                } else {
                    mostrarError('Error', data.message || 'No se pudo eliminar el país');
                }
            });
    }

    form.addEventListener('submit', e => {
        e.preventDefault();
        const nombre = input.value.trim();
        if (!nombre) {
            mostrarError('Campo requerido', 'Debe ingresar un nombre de país.');
            return;
        }

        fetch('index.php?controller=pais&action=crear', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                nombre
            })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mostrarExito('Agregado', data.message || 'País agregado correctamente');
                    form.reset();
                    cargarPaises();
                } else {
                    mostrarError('Error', data.message || 'No se pudo agregar el país');
                }
            });
    });

    cargarPaises();
});
import {
    mostrarExito,
    mostrarError,
    mostrarConfirmacion
} from '/FastFoodSystem/assets/js/alertas.js';

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formModulo');
    const input = document.getElementById('nombreModulo');
    const lista = document.getElementById('listaModulos');

    function cargarModulos() {
        fetch('index.php?controller=modulo&action=listar')
            .then(res => res.json())
            .then(data => {
                lista.innerHTML = '';
                data.forEach(modulo => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item d-flex justify-content-between align-items-center';
                    li.textContent = modulo.descripcion_modulo;

                    const btn = document.createElement('button');
                    btn.innerHTML = '<i class="bi bi-trash"></i>';
                    btn.className = 'btn btn-sm btn-danger';
                    btn.onclick = () => confirmarEliminacion(modulo.id_modulo);

                    li.appendChild(btn);
                    lista.appendChild(li);
                });
            })
            .catch(() => {
                mostrarError('Error', 'No se pudieron cargar los módulos.');
            });
    }

    async function confirmarEliminacion(id) {
        const confirm = await mostrarConfirmacion('¿Eliminar módulo?', 'Esta acción lo desactivará del sistema.');
        if (confirm.isConfirmed) eliminarModulo(id);
    }

    function eliminarModulo(id) {
        fetch('index.php?controller=modulo&action=eliminar', {
            method: 'DELETE',
            body: new URLSearchParams({ id })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mostrarExito('Eliminado', data.message);
                    cargarModulos();
                } else {
                    mostrarError('Error', data.message || 'No se pudo eliminar el módulo');
                }
            });
    }

    form.addEventListener('submit', e => {
        e.preventDefault();
        const nombre = input.value.trim();

        if (!nombre) {
            mostrarError('Campo requerido', 'Debe ingresar un nombre de módulo.');
            return;
        }

        fetch('index.php?controller=modulo&action=crear', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nombre })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mostrarExito('Agregado', data.message || 'Módulo creado correctamente');
                    form.reset();
                    cargarModulos();
                } else {
                    mostrarError('Error', data.message || 'No se pudo crear el módulo');
                }
            });
    });

    cargarModulos();
});

import {
    mostrarExito,
    mostrarError,
    mostrarConfirmacion
} from '/FastFoodSystem/assets/js/alertas.js';

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formUnidad');
    const inputNombre = document.getElementById('nombreUnidad');
    const inputAbreviatura = document.getElementById('abreviaturaUnidad');
    const lista = document.getElementById('listaUnidades');

    function cargarUnidades() {
        fetch('index.php?controller=unidadmedida&action=listar')
            .then(res => res.json())
            .then(data => {
                lista.innerHTML = '';
                data.forEach(u => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item d-flex justify-content-between align-items-center';
                    li.textContent = `${u.nombre_unidad_medida} (${u.abreviatura_unidad_medida})`;

                    const btn = document.createElement('button');
                    btn.innerHTML = '<i class="bi bi-trash"></i>';
                    btn.className = 'btn btn-sm btn-danger';
                    btn.onclick = () => confirmarEliminacion(u.id_unidad);

                    li.appendChild(btn);
                    lista.appendChild(li);
                });
            })
            .catch(() => {
                mostrarError('Error', 'No se pudieron cargar las unidades.');
            });
    }

    async function confirmarEliminacion(id) {
        const confirm = await mostrarConfirmacion(
            '¿Eliminar unidad?',
            'Esta acción no se puede deshacer.'
        );
        if (confirm.isConfirmed) eliminarUnidad(id);
    }

    function eliminarUnidad(id) {
        fetch('index.php?controller=unidadmedida&action=eliminar', {
            method: 'DELETE',
            body: new URLSearchParams({ id })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mostrarExito('Eliminado', data.message);
                    cargarUnidades();
                } else {
                    mostrarError('Error', data.message || 'No se pudo eliminar la unidad.');
                }
            });
    }

    form.addEventListener('submit', e => {
        e.preventDefault();
        const nombre = inputNombre.value.trim();
        const abreviatura = inputAbreviatura.value.trim();

        if (!nombre || !abreviatura) {
            mostrarError('Campos requeridos', 'Debe completar ambos campos.');
            return;
        }

        fetch('index.php?controller=unidadmedida&action=crear', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nombre, abreviatura })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mostrarExito('Agregado', data.message);
                    form.reset();
                    cargarUnidades();
                } else {
                    mostrarError('Error', data.message || 'No se pudo crear la unidad.');
                }
            });
    });

    cargarUnidades();
});

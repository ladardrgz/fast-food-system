import {
    mostrarExito,
    mostrarError,
    mostrarConfirmacion
} from '/FastFoodSystem/assets/js/alertas.js';

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formIngrediente');
    const inputNombre = document.getElementById('nombreIngrediente');
    const selectUnidad = document.getElementById('unidadMedida');
    const lista = document.getElementById('listaIngredientes');

    function cargarIngredientes() {
        fetch('index.php?controller=ingrediente&action=listar')
            .then(res => res.json())
            .then(data => {
                lista.innerHTML = '';
                data.forEach(ing => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item d-flex justify-content-between align-items-center';
                    li.textContent = `${ing.nombre_ingrediente} (${ing.unidad_nombre} - ${ing.abreviatura})`;

                    const btn = document.createElement('button');
                    btn.innerHTML = '<i class="bi bi-trash"></i>';
                    btn.className = 'btn btn-sm btn-danger';
                    btn.onclick = () => confirmarEliminacion(ing.id_ingrediente);

                    li.appendChild(btn);
                    lista.appendChild(li);
                });
            })
            .catch(() => {
                mostrarError('Error', 'No se pudieron cargar los ingredientes.');
            });
    }

    function cargarUnidades() {
        fetch('index.php?controller=unidadmedida&action=listar')
            .then(res => res.json())
            .then(data => {
                selectUnidad.innerHTML = '<option value="">Seleccione unidad</option>';
                data.forEach(unidad => {
                    const opt = document.createElement('option');
                    opt.value = unidad.id_unidad;
                    opt.textContent = `${unidad.nombre} (${unidad.abreviatura})`;
                    selectUnidad.appendChild(opt);
                });
            })
            .catch(() => {
                mostrarError('Error', 'No se pudieron cargar las unidades.');
            });
    }

    async function confirmarEliminacion(id) {
        const confirm = await mostrarConfirmacion(
            '¿Eliminar ingrediente?',
            'Esta acción no se puede deshacer.'
        );
        if (confirm.isConfirmed) eliminarIngrediente(id);
    }

    function eliminarIngrediente(id) {
        fetch('index.php?controller=ingrediente&action=eliminar', {
            method: 'DELETE',
            body: new URLSearchParams({ id })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mostrarExito('Eliminado', data.message);
                    cargarIngredientes();
                } else {
                    mostrarError('Error', data.message || 'No se pudo eliminar');
                }
            });
    }

    form.addEventListener('submit', e => {
        e.preventDefault();
        const nombre = inputNombre.value.trim();
        const idUnidad = parseInt(selectUnidad.value);

        if (!nombre || !idUnidad) {
            mostrarError('Campos requeridos', 'Debe completar todos los campos.');
            return;
        }

        fetch('index.php?controller=ingrediente&action=crear', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nombre, id_unidad: idUnidad })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mostrarExito('Agregado', data.message || 'Ingrediente agregado correctamente');
                    form.reset();
                    cargarIngredientes();
                } else {
                    mostrarError('Error', data.message || 'No se pudo crear');
                }
            });
    });

    cargarUnidades();
    cargarIngredientes();
});

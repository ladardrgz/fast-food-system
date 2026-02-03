import {
    mostrarExito,
    mostrarError,
    mostrarConfirmacion
} from '/FastFoodSystem/assets/js/alertas.js';

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formCategoria');
    const input = document.getElementById('nombreCategoria');
    const lista = document.getElementById('listaCategorias');

    function cargarCategorias() {
        fetch('index.php?controller=categoriaproducto&action=listar')
            .then(res => res.json())
            .then(data => {
                lista.innerHTML = '';
                data.forEach(cat => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item d-flex justify-content-between align-items-center';
                    li.textContent = cat.nombre_categoria;

                    const btn = document.createElement('button');
                    btn.innerHTML = '<i class="bi bi-trash"></i>';
                    btn.className = 'btn btn-sm btn-danger';
                    btn.onclick = () => confirmarEliminacion(cat.id_categoria);

                    li.appendChild(btn);
                    lista.appendChild(li);
                });
            })
            .catch(() => {
                mostrarError('Error', 'No se pudieron cargar las categorías.');
            });
    }

    async function confirmarEliminacion(id) {
        const confirm = await mostrarConfirmacion('¿Eliminar categoría?', 'Esta acción no se puede deshacer.');
        if (confirm.isConfirmed) eliminarCategoria(id);
    }

    function eliminarCategoria(id) {
        fetch('index.php?controller=categoriaproducto&action=eliminar', {
            method: 'DELETE',
            body: new URLSearchParams({ id })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mostrarExito('Eliminado', data.message);
                    cargarCategorias();
                } else {
                    mostrarError('Error', data.message || 'No se pudo eliminar la categoría');
                }
            });
    }

    form.addEventListener('submit', e => {
        e.preventDefault();
        const nombre = input.value.trim();

        if (!nombre) {
            mostrarError('Campo requerido', 'Debe ingresar un nombre de categoría.');
            return;
        }

        fetch('index.php?controller=categoriaproducto&action=crear', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nombre })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mostrarExito('Agregado', data.message || 'Categoría creada correctamente');
                    form.reset();
                    cargarCategorias();
                } else {
                    mostrarError('Error', data.message || 'No se pudo crear la categoría');
                }
            });
    });

    cargarCategorias();
});

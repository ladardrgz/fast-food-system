import {
    mostrarExito,
    mostrarError,
    mostrarConfirmacion
} from '/FastFoodSystem/assets/js/alertas.js';

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formTipoContacto');
    const input = document.getElementById('nombreTipoContacto');
    const lista = document.getElementById('listaTipoContacto');

    function cargarTipos() {
        fetch('index.php?controller=tipocontacto&action=listar')
            .then(res => res.json())
            .then(data => {
                console.log('Tipos recibidos:', data); // 👈 DEBUG

                lista.innerHTML = '';

                data.forEach(item => {
                    console.log('Item:', item); // 👈 DEBUG

                    const li = document.createElement('li');
                    li.className = 'list-group-item d-flex justify-content-between align-items-center';

                    // Agrega un span con el nombre
                    const nombreSpan = document.createElement('span');
                    nombreSpan.textContent = item.nombre_contacto ?? 'Sin nombre'; // 👈 Usa la clave correcta

                    const btn = document.createElement('button');
                    btn.innerHTML = '<i class="bi bi-trash"></i>';
                    btn.className = 'btn btn-sm btn-danger';
                    btn.onclick = () => confirmarEliminacion(item.id_tipo_contacto);

                    li.appendChild(nombreSpan);
                    li.appendChild(btn);
                    lista.appendChild(li);
                });
            })
            .catch(() => {
                mostrarError('Error', 'No se pudieron cargar los tipos de contacto.');
            });
    }

    async function confirmarEliminacion(id) {
        const confirm = await mostrarConfirmacion(
            '¿Eliminar tipo de contacto?',
            'Esta acción no se puede deshacer.'
        );
        if (confirm.isConfirmed) eliminarTipo(id);
    }

    function eliminarTipo(id) {
        fetch('index.php?controller=tipocontacto&action=eliminar', {
            method: 'DELETE',
            body: new URLSearchParams({ id })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mostrarExito('Eliminado', data.message);
                    cargarTipos();
                } else {
                    mostrarError('Error', data.message || 'No se pudo eliminar');
                }
            });
    }

    form.addEventListener('submit', e => {
        e.preventDefault();
        const nombre = input.value.trim();

        if (!nombre) {
            mostrarError('Campo requerido', 'Debe ingresar un tipo de contacto.');
            return;
        }

        fetch('index.php?controller=tipocontacto&action=crear', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nombre })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mostrarExito('Agregado', data.message || 'Tipo de contacto agregado');
                    form.reset();
                    cargarTipos();
                } else {
                    mostrarError('Error', data.message || 'No se pudo crear');
                }
            });
    });

    cargarTipos();
});

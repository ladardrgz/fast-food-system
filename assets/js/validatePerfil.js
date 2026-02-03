import {
    mostrarExito,
    mostrarError,
    mostrarConfirmacion
} from '/FastFoodSystem/assets/js/alertas.js';

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formPerfil');
    const input = document.getElementById('nombrePerfil');
    const lista = document.getElementById('listaPerfiles');

    /**
     * Carga los perfiles activos desde el servidor
     */
    function cargarPerfiles() {
        fetch('index.php?controller=perfil&action=listar')
            .then(res => res.json())
            .then(data => {
                lista.innerHTML = '';
                data.forEach(perfil => {
                    const li = document.createElement('li');
                    li.className = 'list-group-item d-flex justify-content-between align-items-center';
                    li.textContent = perfil.descripcion_perfil;

                    const btn = document.createElement('button');
                    btn.innerHTML = '<i class="bi bi-trash"></i>';
                    btn.className = 'btn btn-sm btn-danger';
                    btn.onclick = () => confirmarEliminacion(perfil.id_perfil);

                    li.appendChild(btn);
                    lista.appendChild(li);
                });
            })
            .catch(() => {
                mostrarError('Error', 'No se pudieron cargar los perfiles.');
            });
    }

    /**
     * Elimina un perfil si se confirma
     */
    async function confirmarEliminacion(id) {
        const confirm = await mostrarConfirmacion(
            '¿Eliminar perfil?',
            'Esta acción desactivará el perfil.'
        );
        if (confirm.isConfirmed) eliminarPerfil(id);
    }

    function eliminarPerfil(id) {
        fetch('index.php?controller=perfil&action=eliminar', {
            method: 'DELETE',
            body: new URLSearchParams({ id })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mostrarExito('Eliminado', data.message);
                    cargarPerfiles();
                } else {
                    mostrarError('Error', data.message || 'No se pudo eliminar.');
                }
            });
    }

    /**
     * Evento submit para crear perfil
     */
    form.addEventListener('submit', e => {
        e.preventDefault();
        const nombre = input.value.trim();

        if (!nombre) {
            mostrarError('Campo requerido', 'Debe ingresar un nombre de perfil.');
            return;
        }

        fetch('index.php?controller=perfil&action=crear', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nombre })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mostrarExito('Agregado', data.message || 'Perfil creado correctamente');
                    form.reset();
                    cargarPerfiles();
                } else {
                    mostrarError('Error', data.message || 'No se pudo crear el perfil');
                }
            });
    });

    // Inicializar al cargar la vista
    cargarPerfiles();
});

import {
    mostrarExito,
    mostrarError,
    mostrarConfirmacion
} from '/FastFoodSystem/assets/js/alertas.js';

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('formDocumento');
    const input = document.getElementById('nombreDocumento');
    const lista = document.getElementById('listaDocumentos');

    if (!form || !input || !lista) {
        console.error("Formulario o elementos no encontrados en el DOM.");
        return;
    }

    function cargarDocumentos() {
        fetch('index.php?controller=tipoDocumento&action=obtener') 
            .then(res => res.json())
            .then(data => {
                lista.innerHTML = '';

                if (Array.isArray(data)) {
                    data.forEach(doc => {
                        const li = document.createElement('li');
                        li.className = 'list-group-item d-flex justify-content-between align-items-center';
                        li.textContent = doc.nombre;

                        const btn = document.createElement('button');
                        btn.innerHTML = '<i class="bi bi-trash"></i>';
                        btn.className = 'btn btn-sm btn-danger';
                        btn.onclick = () => confirmarEliminacion(doc.id);

                        li.appendChild(btn);
                        lista.appendChild(li);
                    });
                } else {
                    mostrarError('Error', 'Formato de respuesta inesperado.');
                }
            })
            .catch(() => {
                mostrarError('Error', 'No se pudieron cargar los tipos de documento.');
            });
    }

    async function confirmarEliminacion(id) {
        const confirm = await mostrarConfirmacion(
            '¿Eliminar tipo de documento?',
            'Esta acción no se puede deshacer.'
        );
        if (confirm.isConfirmed) eliminarDocumento(id);
    }

    function eliminarDocumento(id) {
        fetch('index.php?controller=tipoDocumento&action=eliminar', {
            method: 'POST', // ✅ Usar POST en lugar de DELETE
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: new URLSearchParams({ id })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mostrarExito('Eliminado', data.message);
                    cargarDocumentos();
                } else {
                    mostrarError('Error', data.message || 'No se pudo eliminar el documento');
                }
            });
    }

    form.addEventListener('submit', e => {
        e.preventDefault();
        const nombre = input.value.trim();

        if (!nombre) {
            mostrarError('Campo requerido', 'Debe ingresar el nombre del documento.');
            return;
        }

        fetch('index.php?controller=tipoDocumento&action=crear', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ nombre }) // ✅ El backend espera "nombre"
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mostrarExito('Agregado', data.message || 'Documento agregado correctamente');
                    form.reset();
                    cargarDocumentos();
                } else {
                    mostrarError('Error', data.message || 'No se pudo crear el documento');
                }
            });
    });

    cargarDocumentos();
});

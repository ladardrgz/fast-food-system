import {
    mostrarError,
    mostrarExito
} from '/FastFoodSystem/assets/js/alertas.js';

document.addEventListener('DOMContentLoaded', () => {
    const selectPerfil = document.getElementById('selectPerfil');
    const tablaModulos = document.getElementById('tablaModulos');

    // Cargar perfiles al seleccionar
    function cargarPerfiles() {
        fetch('index.php?controller=perfil&action=listar')
            .then(res => res.json())
            .then(perfiles => {
                selectPerfil.innerHTML = '<option value="">Seleccione un perfil</option>';
                perfiles.forEach(p => {
                    const opt = document.createElement('option');
                    opt.value = p.id_perfil;
                    opt.textContent = p.descripcion_perfil;
                    selectPerfil.appendChild(opt);
                });
            })
            .catch(() => mostrarError('Error', 'No se pudieron cargar los perfiles.'));
    }

    // Cargar módulos con switches según el perfil seleccionado
    function cargarModulos(perfilId) {
        fetch(`index.php?controller=permiso&action=modulosPorPerfil&id=${perfilId}`)
            .then(res => res.json())
            .then(data => {
                tablaModulos.innerHTML = '';
                data.modulos.forEach(modulo => {
                    const tr = document.createElement('tr');

                    const tdNombre = document.createElement('td');
                    tdNombre.textContent = modulo.descripcion_modulo;

                    const tdSwitch = document.createElement('td');
                    tdSwitch.classList.add('text-center');

                    const checkbox = document.createElement('input');
                    checkbox.type = 'checkbox';
                    checkbox.className = 'form-check-input';
                    checkbox.checked = modulo.asignado;

                    checkbox.addEventListener('change', () => {
                        if (checkbox.checked) {
                            asignarModulo(perfilId, modulo.id_modulo);
                        } else {
                            desasignarModulo(perfilId, modulo.id_modulo);
                        }
                    });

                    tdSwitch.appendChild(checkbox);
                    tr.appendChild(tdNombre);
                    tr.appendChild(tdSwitch);
                    tablaModulos.appendChild(tr);
                });
            })
            .catch(() => mostrarError('Error', 'No se pudieron cargar los módulos.'));
    }

    function asignarModulo(perfilId, moduloId) {
        fetch('index.php?controller=permiso&action=asignar', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ perfilId, moduloId })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mostrarExito('Éxito', data.message || 'Permiso asignado correctamente.');
                } else {
                    mostrarError('Error', data.message || 'No se pudo asignar el permiso.');
                }
            })
            .catch(() => mostrarError('Error', 'Fallo al asignar el permiso.'));
    }

    function desasignarModulo(perfilId, moduloId) {
        fetch('index.php?controller=permiso&action=desasignar', {
            method: 'DELETE',
            body: new URLSearchParams({ perfilId, moduloId })
        })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    mostrarExito('Éxito', data.message || 'Permiso eliminado correctamente.');
                } else {
                    mostrarError('Error', data.message || 'No se pudo quitar el permiso.');
                }
            })
            .catch(() => mostrarError('Error', 'Fallo al quitar el permiso.'));
    }


    selectPerfil.addEventListener('change', () => {
        const perfilId = selectPerfil.value;
        if (perfilId) cargarModulos(perfilId);
        else tablaModulos.innerHTML = '';
    });

    cargarPerfiles();
});

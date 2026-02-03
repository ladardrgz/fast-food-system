document.addEventListener('DOMContentLoaded', () => {
    const campana = document.getElementById('iconoCampana');
    const panel = document.getElementById('panelNotificaciones');
    const lista = document.getElementById('listaNoti');
    const contador = document.getElementById('contadorNoti');

    if (!campana || !panel || !lista || !contador) {
        console.warn('Algunos elementos de notificación no se encontraron en el DOM.');
        return;
    }

    function formatearFecha(fechaISO) {
        const fecha = new Date(fechaISO);
        return fecha.toLocaleString(); // Puedes personalizar el formato si lo deseas
    }

    function cargarNotificaciones() {
        fetch('index.php?controller=notificacion&action=listar')
            .then(res => res.json())
            .then(data => {
                lista.innerHTML = '';
                if (!data.success || !Array.isArray(data.data)) {
                    lista.innerHTML = '<li class="text-danger px-3 py-2">Error al cargar notificaciones</li>';
                    return;
                }

                if (data.data.length === 0) {
                    lista.innerHTML = '<li class="text-muted px-3 py-2">Sin notificaciones</li>';
                } else {
                    data.data.forEach(n => {
                        const li = document.createElement('li');
                        li.classList.add('px-3', 'py-2', 'border-bottom');
                        li.innerHTML = `
                            <strong>${n.titulo}</strong><br>
                            <small>${n.mensaje}</small><br>
                            <small class="text-muted">${formatearFecha(n.fecha_creacion)}</small>
                        `;
                        lista.appendChild(li);
                    });
                }
            })
            .catch(err => {
                console.error('Error cargando notificaciones:', err);
                lista.innerHTML = '<li class="text-danger px-3 py-2">Error de conexión</li>';
            });
    }

    function actualizarContador() {
        fetch('index.php?controller=notificacion&action=contar')
            .then(res => res.json())
            .then(data => {
                if (!data.success || typeof data.count !== 'number') {
                    contador.style.display = 'none';
                    return;
                }
                contador.textContent = data.count;
                contador.style.display = data.count > 0 ? 'inline-block' : 'none';
            })
            .catch(err => {
                console.error('Error actualizando contador:', err);
                contador.style.display = 'none';
            });
    }

    campana.addEventListener('click', () => {
        panel.classList.toggle('d-none');

        if (!panel.classList.contains('d-none')) {
            fetch('index.php?controller=notificacion&action=marcarLeidas', { method: 'POST' })
                .then(() => actualizarContador());
            cargarNotificaciones();
        }
    });

    actualizarContador();
});

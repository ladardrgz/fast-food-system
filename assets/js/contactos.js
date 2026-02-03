document.addEventListener('DOMContentLoaded', () => {
    const tipoContactoSelect = document.getElementById('tipoCont');

    fetch('/FastFoodSystem/index.php?controller=TipoContacto&action=obtener')
        .then(res => res.json())
        .then(data => {
            tipoContactoSelect.innerHTML = '<option value="">Seleccione...</option>' +
                data.map(item => `<option value="${item.id}">${item.nombre}</option>`).join('');
        })
        .catch(err => {
            console.error('Error cargando tipos de contacto:', err);
            Swal.fire('Error', 'No se pudieron cargar los tipos de contacto.', 'error');
        });
});

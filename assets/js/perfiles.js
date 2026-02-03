document.addEventListener('DOMContentLoaded', () => {
  const perfilSelect = document.getElementById('perfil');

  fetch('index.php?controller=perfil&action=listar')
    .then(res => res.json())
    .then(data => {
      perfilSelect.innerHTML = '<option value="">Seleccione perfil...</option>' +
        data.map(p => `<option value="${p.id_perfil}">${p.descripcion_perfil}</option>`).join('');
    })
    .catch(err => {
      console.error('Error cargando perfiles:', err);
      Swal.fire('Error', 'No se pudieron cargar los perfiles.', 'error');
    });
});

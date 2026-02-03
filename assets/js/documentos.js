document.addEventListener('DOMContentLoaded', () => {
  const tipoDocSelect = document.getElementById('tipoDoc');

  fetch('/FastFoodSystem/index.php?controller=TipoDocumento&action=obtener')
    .then(res => res.json())
    .then(data => {
      tipoDocSelect.innerHTML = '<option value="">Seleccione...</option>' +
        data.map(doc => `<option value="${doc.id}">${doc.nombre}</option>`).join('');
    })
    .catch(err => {
      console.error('Error cargando tipos de documento:', err);
      Swal.fire('Error', 'No se pudieron cargar los tipos de documento.', 'error');
    });
});

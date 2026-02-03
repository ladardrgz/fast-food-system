document.addEventListener('DOMContentLoaded', () => {
  const btnPerfil = document.getElementById('btnEditarPerfil');
  const btnContrasena = document.getElementById('btnEditarContrasena');

  if (btnPerfil) {
    btnPerfil.addEventListener('click', (e) => {
      e.preventDefault();
      Swal.fire({
        title: '¿Deseás editar tu información básica?',
        text: 'Serás redirigido a la sección de edición de perfil.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, continuar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'index.php?controller=usuario&action=editarPerfil';
        }
      });
    });
  }

  if (btnContrasena) {
    btnContrasena.addEventListener('click', (e) => {
      e.preventDefault();
      Swal.fire({
        title: '¿Deseás cambiar tu contraseña?',
        text: 'Serás redirigido a la sección de seguridad.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, cambiar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = 'index.php?controller=usuario&action=editarContrasena';
        }
      });
    });
  }
});

document.addEventListener('DOMContentLoaded', () => {
  const paisSelect = document.getElementById('pais');
  const provinciaSelect = document.getElementById('provincia');
  const localidadSelect = document.getElementById('localidad');
  const barrioSelect = document.getElementById('barrio');

  function llenarSelect(selectEl, items, placeholder) {
    selectEl.innerHTML = `<option value="">${placeholder}</option>` +
      items.map(item => {
        const id = item.id ?? item.id_pais ?? item.id_provincia ?? item.id_localidad ?? item.id_barrio;
        const nombre = item.nombre ?? item.nombre_pais ?? item.nombre_provincia ?? item.nombre_localidad ?? item.nombre_barrio;
        return `<option value="${id}">${nombre}</option>`;
      }).join('');
  }

  function setEsperando(selectEl, texto) {
    selectEl.innerHTML = `<option value="">${texto}</option>`;
  }

  // 🔹 Inicializar todos con "esperando..."
  setEsperando(provinciaSelect, '...');
  setEsperando(localidadSelect, '...');
  setEsperando(barrioSelect, '...');

  // 🔹 1. Cargar países
  fetch('/FastFoodSystem/index.php?controller=Pais&action=obtener')
    .then(res => res.json())
    .then(data => llenarSelect(paisSelect, data, 'Seleccione país'))
    .catch(err => {
      console.error('Error cargando países:', err);
      Swal.fire('Error', 'No se pudieron cargar los países.', 'error');
    });

  // 🔹 2. País → Provincia
  paisSelect.addEventListener('change', () => {
    const idPais = paisSelect.value;

    setEsperando(provinciaSelect, 'Cargando provincias...');
    setEsperando(localidadSelect, 'Seleccione provincia primero');
    setEsperando(barrioSelect, 'Seleccione localidad primero');

    if (!idPais) {
      setEsperando(provinciaSelect, 'Seleccione país primero');
      return;
    }

    fetch(`/FastFoodSystem/index.php?controller=Provincia&action=obtener&id_pais=${idPais}`)
      .then(res => res.json())
      .then(data => llenarSelect(provinciaSelect, data, 'Seleccione provincia'))
      .catch(err => {
        console.error('Error cargando provincias:', err);
        Swal.fire('Error', 'No se pudieron cargar las provincias.', 'error');
      });
  });

  // 🔹 3. Provincia → Localidad
  provinciaSelect.addEventListener('change', () => {
    const idProv = provinciaSelect.value;

    setEsperando(localidadSelect, 'Cargando localidades...');
    setEsperando(barrioSelect, 'Seleccione localidad primero');

    if (!idProv) {
      setEsperando(localidadSelect, 'Seleccione provincia primero');
      return;
    }

    fetch(`/FastFoodSystem/index.php?controller=Localidad&action=obtener&id_provincia=${idProv}`)
      .then(res => res.json())
      .then(data => llenarSelect(localidadSelect, data, 'Seleccione localidad'))
      .catch(err => {
        console.error('Error cargando localidades:', err);
        Swal.fire('Error', 'No se pudieron cargar las localidades.', 'error');
      });
  });

  // 🔹 4. Localidad → Barrio
  localidadSelect.addEventListener('change', () => {
    const idLoc = localidadSelect.value;

    setEsperando(barrioSelect, 'Cargando barrios...');

    if (!idLoc) {
      setEsperando(barrioSelect, 'Seleccione localidad primero');
      return;
    }

    fetch(`/FastFoodSystem/index.php?controller=Barrio&action=obtener&id_localidad=${idLoc}`)
      .then(res => res.json())
      .then(data => llenarSelect(barrioSelect, data, 'Seleccione barrio'))
      .catch(err => {
        console.error('Error cargando barrios:', err);
        Swal.fire('Error', 'No se pudieron cargar los barrios.', 'error');
      });
  });
});

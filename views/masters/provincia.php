<head>
  <link rel="stylesheet" href="/FastFoodSystem/assets/css/masters.css">
</head>

<div class="container bg-white p-4 rounded shadow">
  <h2 class="text-center">Agregar provincia</h2>

  <form id="formProvincia" class="row g-2 mb-4" novalidate>
    <div class="col-md-6">
      <input type="text" id="nombreProvincia" class="form-control" placeholder="Nombre de provincia" required>
    </div>
    <div class="col-md-4">
      <select id="selectPais" class="form-select" required></select>
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-primary w-100">
        <i class="bi bi-plus-circle"></i> Agregar
      </button>
    </div>
  </form>

  <ul id="listaProvincias" class="list-group"></ul>

  <script type="module" src="/FastFoodSystem/assets/js/validateProvincia.js"></script>
</div>
<head>
    <link rel="stylesheet" href="/FastFoodSystem/assets/css/masters.css">
</head>

<body>
  <div class="container bg-white p-4 rounded shadow">
    <h2 class="text-center">Agregar país</h2>

    <form id="formPais" class="d-flex mb-4 gap-2" novalidate>
      <input type="text" id="nombrePais" class="form-control" placeholder="Nuevo país" required>
      <button type="submit" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Agregar
      </button>
    </form>

    <ul id="listaPaises" class="list-group"></ul>
  </div>

  <script type="module" src="/FastFoodSystem/assets/js/validatePais.js"></script>

</body>
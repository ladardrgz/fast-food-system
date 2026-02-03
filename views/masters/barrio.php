<head>
    <link rel="stylesheet" href="/FastFoodSystem/assets/css/masters.css">
</head>

<body>
    <div class="container bg-white p-4 rounded shadow" novalidate>
        <h2 class="text-center">Agregar barrio</h2>

        <form id="formBarrio" class="d-flex mb-4 gap-2" novalidate>
            <div class="col-md-3">
                <select id="selectPais" class="form-select" required>
                    <option value="">Seleccione país</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="selectProvincia" class="form-select" required>
                    <option value="">Seleccione provincia</option>
                </select>
            </div>
            <div class="col-md-3">
                <select id="selectLocalidad" class="form-select" required>
                    <option value="">Seleccione localidad</option>
                </select>
            </div>
            <div class="col-md-2">
                <input type="text" id="nombreBarrio" class="form-control" placeholder="Nombre barrio" required>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i>
                </button>
            </div>
        </form>

        <ul id="listaBarrios" class="list-group"></ul>
    </div>

    <script type="module" src="/FastFoodSystem/assets/js/validateBarrio.js"></script>

</body>
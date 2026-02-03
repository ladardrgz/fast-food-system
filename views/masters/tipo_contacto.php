<head>
    <link rel="stylesheet" href="/FastFoodSystem/assets/css/masters.css">
</head>

<body>
    <div class="container bg-white p-4 rounded shadow">
        <h2 class="text-center">Agregar tipo de contacto</h2>

        <form id="formTipoContacto" class="d-flex mb-4 gap-2" novalidate>
            <div class="col-md-11">
                <input type="text" id="nombreTipoContacto" class="form-control" placeholder="Ej: Fax" required>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-plus-circle"></i>
                </button>
            </div>
        </form>

        <ul id="listaTipoContacto" class="list-group"></ul>
    </div>

    <script type="module" src="/FastFoodSystem/assets/js/validateTipoContacto.js"></script>
</body>
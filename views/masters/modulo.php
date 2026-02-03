<head>
    <link rel="stylesheet" href="/FastFoodSystem/assets/css/masters.css">
</head>

<body>
    <div class="container bg-white p-4 rounded shadow">
        <h2 class="text-center">Agregar módulo</h2>

        <form id="formModulo" class="d-flex mb-4 gap-2" novalidate>
            <div class="col-md-11">
                <input type="text" id="nombreModulo" class="form-control" placeholder="Nombre del módulo" required>
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary w-100">
                    <i class="bi bi-plus-circle"></i>
                </button>
            </div>
        </form>

        <ul id="listaModulos" class="list-group"></ul>
    </div>

    <script type="module" src="/FastFoodSystem/assets/js/validateModulo.js"></script>

</body>

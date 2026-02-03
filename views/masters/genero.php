<head>
    <link rel="stylesheet" href="/FastFoodSystem/assets/css/masters.css">
</head>

<body>
    <div class="container bg-white p-4 rounded shadow">
        <h2 class="text-center">Agregar género</h2>

        <form id="formGenero" class="d-flex mb-4 gap-2" novalidate>
            <input type="text" id="nombreGenero" class="form-control" placeholder="Nuevo género" required>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Agregar
            </button>
        </form>

        <ul id="listaGeneros" class="list-group"></ul>
    </div>

    <script type="module" src="/FastFoodSystem/assets/js/validateGenero.js"></script>
</body>
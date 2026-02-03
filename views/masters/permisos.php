<head>
    <link rel="stylesheet" href="/FastFoodSystem/assets/css/masters.css">
    <style>
        /* Estilo visual personalizado para el switch */
        .form-check-input[type="checkbox"] {
            width: 2.5em;
            height: 1.4em;
            background-color: #ccc;
            border-radius: 1em;
            position: relative;
            appearance: none;
            cursor: pointer;
            transition: background-color 0.3s;
            vertical-align: middle;
        }

        .form-check-input[type="checkbox"]::before {
            content: "";
            position: absolute;
            width: 1.2em;
            height: 1.2em;
            border-radius: 50%;
            background-color: #fff;
            top: 0.1em;
            left: 0.1em;
            transition: transform 0.3s ease-in-out;
        }

        .form-check-input[type="checkbox"]:checked {
            background-color: #77231F;
        }

        .form-check-input[type="checkbox"]:checked::before {
            transform: translateX(1.1em);
        }
    </style>
</head>

<body>
    <div class="container bg-white p-4 rounded shadow">
        <h2 class="text-center mb-4">Asignar permisos a perfiles</h2>

        <div class="mb-4">
            <select id="selectPerfil" class="form-select" required>
                <option value="">Seleccione un perfil</option>
            </select>
        </div>

        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>Módulo</th>
                    <th class="text-center">Asignado</th>
                </tr>
            </thead>
            <tbody id="tablaModulos">
                <!-- Módulos cargados por JS -->
            </tbody>
        </table>
    </div>
    <script type="module" src="/FastFoodSystem/assets/js/validatePermisos.js"></script>
</body>
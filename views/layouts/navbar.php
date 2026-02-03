<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <!-- Logo y marca -->
        <a class="navbar-brand d-flex align-items-center" href="index.php?controller=panel&action=dashboard">
            <span>FastFoodSystem</span>
        </a>

        <!-- Botón colapsable -->
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menú principal -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">

                <!-- Menús dinámicos -->
                <?php if (in_array('Menú', $modulos)) : ?>
                    <li class="nav-item"><a class="nav-link" href="index.php?controller=cliente&action=verMenu">Menú</a></li>
                <?php endif; ?>

                <?php if (in_array('Usuarios', $modulos)) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Usuarios</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Ver sección</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=usuario&action=registrar">Crear usuario</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=perfil&action=verFormulario">Crear perfil</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=modulo&action=verFormulario">Crear módulo</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=permiso&action=verFormulario">Asignar/quitar permisos</a></li>
                            <li><a class="dropdown-item" href="#">Exportar listado de usuarios</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Clientes', $modulos)) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Clientes</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Ver sección</a></li>
                            <li><a class="dropdown-item" href="#">Ver historial de clientes</a></li>
                            <li><a class="dropdown-item" href="#">Exportar listado de clientes</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Proveedores', $modulos)) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Proveedores</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Ver sección</a></li>
                            <li><a class="dropdown-item" href="#">Crear proveedor</a></li>
                            <li><a class="dropdown-item" href="#">Exportar listado de proveedores</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Caja', $modulos)) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Caja</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Apertura de caja</a></li>
                            <li><a class="dropdown-item" href="#">Movimientos de caja</a></li>
                            <li><a class="dropdown-item" href="#">Registrar ingreso</a></li>
                            <li><a class="dropdown-item" href="#">Registrar egreso</a></li>
                            <li><a class="dropdown-item" href="#">Reembolsos / devoluciones</a></li>
                            <li><a class="dropdown-item" href="#">Cierre de caja</a></li>
                            <li><a class="dropdown-item" href="#">Historial de cajas</a></li>
                            <li><a class="dropdown-item" href="#">Reportes de caja</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Ventas', $modulos)) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Ventas</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Ver sección</a></li>
                            <li><a class="dropdown-item" href="#">Crear venta</a></li>
                            <li><a class="dropdown-item" href="#">Exportar listado de ventas</a></li>
                            <li><a class="dropdown-item" href="#">Devoluciones de productos</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Inventario', $modulos)) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Inventario</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?controller=inventario&action=verInventario">Ver inventario</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=producto&action=verFormulario">Crear producto</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=inventario&action=ajustarStock">Ajustar stock</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=inventario&action=movimientos">Ver movimientos de inventario</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=inventario&action=alertas">Alertas de stock</a></li>
                        </ul>
                    </li>
                <?php endif; ?>


                <?php if (in_array('Productos', $modulos)) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Productos</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Ver sección</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=categoriaproducto&action=verFormulario">Agregar categoría</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=ingrediente&action=verFormulario">Agregar ingredientes</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=unidadmedida&action=verFormulario">Agregar unidades de medida</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Pedidos', $modulos)) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Pedidos</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="#">Ver sección</a></li>
                            <li><a class="dropdown-item" href="#">Nuevo pedido</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <?php if (in_array('Configuración', $modulos)) : ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Configuración</a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="index.php?controller=pais&action=verFormulario">Crear país</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=provincia&action=verFormulario">Crear provincia</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=localidad&action=verFormulario">Crear localidad</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=barrio&action=verFormulario">Crear barrio</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=documento&action=verFormulario">Crear documento</a></li>
                            <li><a class="dropdown-item" href="index.php?controller=tipocontacto&action=verFormulario">Crear contacto</a></li>
                        </ul>
                    </li>
                <?php endif; ?>

                <!-- Imagen de perfil -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center" href="#" data-bs-toggle="dropdown">
                        <img src="/GastroSystem/assets/images/Perfil.png" alt="Perfil" class="perfil-icono">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="index.php?controller=usuario&action=administrarCuenta">Administrar tu cuenta de FastFoodSystem</a></li>
                        <hr class="dropdown-divider">
                        <li><a class="dropdown-item text-danger" href="index.php?controller=Login&action=logout">
                                <i class="bi bi-box-arrow-right"></i> Cerrar sesión</a></li>
                    </ul>
                </li>

                <!-- Notificación: Campana + Panel desplegable -->
                <div class="position-relative me-3">
                    <span id="iconoCampana" class="nav-link position-relative">
                        <i class="bi bi-bell fs-5 text-white"></i>
                        <span id="contadorNoti" class="badge bg-danger position-absolute top-0 start-100 translate-middle">0</span>
                    </span>

                    <ul id="panelNotificaciones" class="list-unstyled bg-white border rounded shadow d-none position-absolute mt-2" style="width: 320px; right: 0; z-index: 1050;">
                        <li class="border-bottom p-2 bg-light fw-bold text-center">Notificaciones</li>
                        <div id="listaNoti"></div>
                    </ul>
                </div>

                <!-- Flechas de navegación -->
                <li class="nav-item d-flex align-items-center ms-2">
                    <a class="nav-link" href="javascript:history.back()">
                        <i class="bi bi-arrow-left-circle" style="font-size: 1.5rem; color: white;"></i>
                    </a>
                </li>
                <li class="nav-item d-flex align-items-center ms-2">
                    <a class="nav-link" href="javascript:history.forward()">
                        <i class="bi bi-arrow-right-circle" style="font-size: 1.5rem; color: white;"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Notificación flotante (inicialmente oculta) -->
    <div id="notificacionFlotante"></div>
</nav>
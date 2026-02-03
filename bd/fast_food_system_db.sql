CREATE DATABASE FastFoodSystem;
USE FastFoodSystem;
CREATE TABLE paises (
	id_pais INT PRIMARY KEY AUTO_INCREMENT,
    nombre_pais VARCHAR(50)
);
INSERT INTO paises(nombre_pais) VALUES 
('Argentina'),
('Paraguay'),
('Antigua y Barbuda'),
('Bahamas'),
('Barbados'),
('Belice'),
('Bolivia'),
('Brasil'),
('Chile'),
('Colombia'),
('Costa Rica'),
('Cuba'),
('Dominica'),
('Ecuador'),
('El Salvador'),
('Granada'),
('Guatemala'),
('Guyana'),
('Haití'),
('Honduras'),
('Jamaica'),
('México'),
('Nicaragua'),
('Panamá'),
('Perú'),
('República Dominicana'),
('San Cristóbal y Nieves'),
('San Vicente y las Granadinas'),
('Santa Lucía'),
('Surinam'),
('Trinidad y Tobago'),
('Uruguay'),
('Venezuela');
-- Provincias
CREATE TABLE provincias (
    id_provincia INT PRIMARY KEY AUTO_INCREMENT,
    nombre_provincia VARCHAR(50),
    rela_pais INT,
    FOREIGN KEY (rela_pais) REFERENCES paises(id_pais)
);
INSERT INTO provincias (nombre_provincia, rela_pais) VALUES ('Buenos Aires', 1), ('Catamarca', 1), ('Chaco', 1), ('Chubut', 1), 
('Ciudad Autónoma de Buenos Aires', 1), ('Córdoba', 1), ('Corrientes', 1), ('Entre Ríos', 1), ('Formosa', 1), ('Jujuy', 1), 
('La Pampa', 1), ('La Rioja', 1), ('Mendoza', 1), ('Misiones', 1), ('Neuquén', 1), ('Río Negro', 1), ('Salta', 1), ('San Juan', 1), 
('San Luis', 1), ('Santa Cruz', 1), ('Santa Fe', 1), ('Santiago del Estero', 1), ('Tierra del Fuego', 1), ('Tucumán', 1);
-- Localidades
CREATE TABLE localidades (
    id_localidad INT PRIMARY KEY AUTO_INCREMENT,
    nombre_localidad VARCHAR(50),
    rela_provincia INT,
    FOREIGN KEY (rela_provincia) REFERENCES provincias(id_provincia)
);
INSERT INTO localidades (nombre_localidad, rela_provincia) VALUES ('Formosa', 9), ('Pirané', 9), ('Pozo del Tigre', 9), ('Laishí', 9), 
('San Martín II', 9), ('Villa Dos Trece', 9), ('Villafañe', 9), ('Ramón Lista', 9), ('Río Muerto', 9), ('Pilcomayo', 9), ('Gral Belgrano', 9),
('Pilagás', 9), ('Matacos', 9), ('Bermejo', 9), ('Las Lomitas', 9), ('Guemes', 9);
-- Barrios
CREATE TABLE barrios (
    id_barrio INT PRIMARY KEY AUTO_INCREMENT,
    nombre_barrio VARCHAR(50),
    rela_localidad INT,
    FOREIGN KEY (rela_localidad) REFERENCES localidades(id_localidad)
);
INSERT INTO barrios (nombre_barrio, rela_localidad) VALUES
('Barrio 2 de Abril', 1),
('Barrio 7 de Mayo', 1),
('Barrio Antenor Gauna', 1),
('Barrio Bernardino Rivadavia', 1),
('Barrio Centenario', 1),
('Barrio Coluccio', 1),
('Barrio Curé Cuá', 1),
('Barrio Divino Niño Jesús', 1),
('Barrio El Amanecer', 1),
('Barrio El Palmar', 1),
('Barrio El Pucú', 1),
('Barrio Eva Perón', 1),
('Barrio Guadalupe', 1),
('Barrio Independencia', 1),
('Barrio Irigoyen', 1),
('Barrio Juan Domingo Perón', 1),
('Barrio Juan Manuel de Rosas', 1),
('Barrio La Colonia', 1),
('Barrio La Lomita', 1),
('Barrio La Nueva Formosa', 1),
('Barrio La Paz', 1),
('Barrio Laguna Siam', 1),
('Barrio Las Orquídeas', 1),
('Barrio Lote 4', 1),
('Barrio Lote 111', 1),
('Barrio Lote 67', 1),
('Barrio Lote Rural 3 Bis', 1),
('Barrio Los Inmigrantes', 1),
('Barrio Los Naranjos', 1),
('Barrio Los Pinos', 1),
('Barrio Mariano Moreno', 1),
('Barrio Medalla Milagrosa', 1),
('Barrio Nanqom', 1),
('Barrio Nuestra Señora de Luján', 1),
('Barrio Parque Urbano', 1),
('Barrio República Argentina', 1),
('Barrio Ricardo Balbín', 1),
('Barrio San Agustín', 1),
('Barrio San Antonio', 1),
('Barrio San Carlos', 1),
('Barrio San Cayetano', 1),
('Barrio San Fernando', 1),
('Barrio San Francisco de Asís', 1),
('Barrio San José Obrero', 1),
('Barrio San Juan Bautista', 1),
('Barrio San Lorenzo', 1),
('Barrio San Miguel', 1),
('Barrio San Pedro', 1),
('Barrio San Roque', 1),
('Barrio Santa Rosa', 1),
('Barrio Sagrado Corazón', 1),
('Barrio Sagrado Corazón de María', 1),
('Barrio Simón Bolívar', 1),
('Barrio Timbó', 1),
('Barrio Urunday', 1),
('Barrio Veinticinco de Mayo', 1),
('Barrio Venezuela', 1),
('Barrio Vial', 1),
('Barrio Villa Hermosa', 1),
('Barrio Villa Lourdes', 1),
('Barrio Villa Mabel', 1),
('Barrio Villa del Carmen', 1);

-- Tabla de direcciones o domicilios
CREATE TABLE direcciones (
    id_direccion INT PRIMARY KEY AUTO_INCREMENT,
    calle_direccion VARCHAR(100),
    numero_direccion VARCHAR(10),
    piso_direccion VARCHAR(10) DEFAULT 'S/C',
    dpto_direccion VARCHAR(10) DEFAULT 'S/C',
    latitud_direccion DECIMAL(10, 8) NULL,
    longitud_direccion DECIMAL(11, 8) NULL,
    rela_barrios INT NOT NULL,
    FOREIGN KEY (rela_barrios) REFERENCES barrios(id_barrio)
);

-- Tipo de documentos
CREATE TABLE tipos_documentos (
	id_documento INT PRIMARY KEY AUTO_INCREMENT,
    nombre_documento VARCHAR(50)
);
INSERT INTO tipos_documentos (nombre_documento) VALUES
('DNI'), ('CDI'), ('CUIT'), ('CUIL'), ('DNIe'), ('LC');

-- Valores del documento
CREATE TABLE detalle_documentos (
    id_detalle_documento INT PRIMARY KEY AUTO_INCREMENT,
    valor_documento VARCHAR(50),
    rela_tipo_documento INT,
    FOREIGN KEY (rela_tipo_documento) REFERENCES tipos_documentos(id_documento)
);

-- Tipos de contacto
CREATE TABLE tipos_contactos (
    id_tipo_contacto INT PRIMARY KEY AUTO_INCREMENT,
    nombre_contacto VARCHAR(50)
);
INSERT INTO tipos_contactos (nombre_contacto) VALUES ('Correo electrónico'), ('Número de teléfono');

-- Valores del contacto
CREATE TABLE detalles_contactos (
    id_contacto INT PRIMARY KEY AUTO_INCREMENT,
    valor_contacto VARCHAR(100),
    rela_tipo_contacto INT,
    FOREIGN KEY (rela_tipo_contacto) REFERENCES tipos_contactos(id_tipo_contacto)
);

-- Tabla de generos
CREATE TABLE generos (
    id_genero INT PRIMARY KEY AUTO_INCREMENT,
    nombre_genero VARCHAR(50) NOT NULL UNIQUE
);

INSERT INTO generos (nombre_genero) VALUES
('Masculino'),
('Femenino'),
('No binario'),
('Otro'),
('Prefiero no decirlo');

-- Tabla personas para administrar información personal
CREATE TABLE personas (
    id_persona INT PRIMARY KEY AUTO_INCREMENT,
    nombre_persona VARCHAR(50),
    apellido_persona VARCHAR(50),
    fecha_nacimiento_persona DATE,
    rela_genero INT,
    rela_direccion INT,
    rela_documento INT,
    rela_contacto INT,
    FOREIGN KEY (rela_genero) REFERENCES generos(id_genero),
    FOREIGN KEY (rela_direccion) REFERENCES direcciones(id_direccion),
    FOREIGN KEY (rela_documento) REFERENCES detalle_documentos(id_detalle_documento),
    FOREIGN KEY (rela_contacto) REFERENCES detalles_contactos(id_contacto)
);

-- Tabla para administrar perfiles o roles de un usuario
CREATE TABLE perfiles (
    id_perfil INT PRIMARY KEY AUTO_INCREMENT,
    descripcion_perfil VARCHAR(50),
    activo_perfil TINYINT(1) DEFAULT 1
);
INSERT INTO perfiles (descripcion_perfil) VALUES ('Administrador'), ('Encargado'), ('Empleado'), ('Repartidor'), ('Cliente');

-- Tabla de módulos o permisos para un perfil o rol específico
CREATE TABLE modulos (
    id_modulo INT PRIMARY KEY AUTO_INCREMENT,
    descripcion_modulo VARCHAR(100),
    activo_modulo TINYINT(1) DEFAULT 1
);
INSERT INTO modulos (descripcion_modulo) VALUES ('Menú'), ('Usuarios'), ('Clientes'), ('Proveedores'), ('Ventas'), ('Inventario'), 
('Productos'), ('Pedidos'), ('Configuración'), ('Caja');

-- Relación entre módulos y perfiles
CREATE TABLE modulos_perfiles (
    rela_modulo INT,
    rela_perfil INT,
    PRIMARY KEY (rela_modulo, rela_perfil),
    FOREIGN KEY (rela_modulo) REFERENCES modulos(id_modulo) ON DELETE CASCADE,
    FOREIGN KEY (rela_perfil) REFERENCES perfiles(id_perfil) ON DELETE CASCADE
);

-- ADMINISTRADOR (Perfil 1)
-- Tiene acceso completo al sistema para tareas de configuración, mantenimiento y supervisión total.
INSERT INTO modulos_perfiles (rela_modulo, rela_perfil) VALUES
(1, 1), (2, 1), (3, 1), (4, 1), (5, 1), (6, 1), (7, 1), (8, 1), (9, 1), (10, 1);

-- ENCARGADO (Perfil 2)
-- Tiene acceso total operativo al sistema para gestionar procesos y usuarios, sin cambiar configuraciones del sistema base.
INSERT INTO modulos_perfiles (rela_modulo, rela_perfil) VALUES
(1, 2), (2, 2), (3, 2), (4, 2), (5, 2), (6, 2), (7, 2), (8, 2), (9, 2), (10, 2);

-- EMPLEADO (Perfil 3)
-- Accede a las funciones operativas necesarias para realizar ventas, gestionar productos y atención al cliente.
INSERT INTO modulos_perfiles (rela_modulo, rela_perfil) VALUES
(1, 3), (3, 3), (5, 3), (6, 3), (7, 3), (8, 3), (10, 3);

-- REPARTIDOR (Perfil 4)
-- Tiene acceso únicamente al módulo de pedidos, ya que su rol es realizar entregas.
INSERT INTO modulos_perfiles (rela_modulo, rela_perfil) VALUES
(8, 4);

-- CLIENTE (Perfil 5)
-- Tiene acceso limitado a funcionalidades como ver el menú y realizar pedidos.
INSERT INTO modulos_perfiles (rela_modulo, rela_perfil) VALUES
(1, 5), -- Menú
(8, 5); -- Pedidos

-- Tabla de usuarios
CREATE TABLE usuarios (
    id_usuario INT PRIMARY KEY AUTO_INCREMENT,
    nombre_usuario VARCHAR(50),
    password_usuario VARCHAR(255),
    fecha_registro_usuario TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	password_temporal VARCHAR(255), 
    password_temporal_visible VARCHAR(255) DEFAULT NULL, -- Atributo para prueba de funcionamiento de password temporal para futura integración de API PHPMailer
    expiracion_password_temporal DATETIME,
    estado_usuario TINYINT(1) DEFAULT 1,
    rela_persona INT,
    rela_perfil INT,
    FOREIGN KEY (rela_persona) REFERENCES personas(id_persona),
    FOREIGN KEY (rela_perfil) REFERENCES perfiles(id_perfil)
);

-- Tabla para administrar sesiones
CREATE TABLE sesiones (
    id_sesion INT PRIMARY KEY AUTO_INCREMENT,
    id_usuario INT NOT NULL,
    activa TINYINT(1) NOT NULL DEFAULT 0,
    fecha_ultimo_login DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (id_usuario) REFERENCES usuarios(id_usuario) ON DELETE CASCADE
);

-- Tabla para administrar clientes
CREATE TABLE clientes (
    id_cliente INT PRIMARY KEY AUTO_INCREMENT,
	estado_cliente TINYINT DEFAULT 1,
    rela_persona INT NOT NULL,
    FOREIGN KEY (rela_persona) REFERENCES personas(id_persona)
);

-- Tabla para administrar empleados
CREATE TABLE empleados (
    id_empleado INT PRIMARY KEY AUTO_INCREMENT,
    rela_persona INT NOT NULL,
    fecha_alta_empleado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estado_empleado TINYINT DEFAULT 1,
    FOREIGN KEY (rela_persona) REFERENCES personas(id_persona)
);

-- Categorías de productos
CREATE TABLE categorias_productos (
    id_categoria INT PRIMARY KEY AUTO_INCREMENT,
    nombre_categoria VARCHAR(50)
);

INSERT INTO categorias_productos (nombre_categoria) VALUES 
('Bebidas'), ('Guisos y cazuelas'), ('Ensaladas'),  
('Milanesas'), ('Tartas y empanadas'), ('Minutas'),
('Pastas'), ('Carnes al horno o parrilla'), 
('Pizzas'), ('Acompañamientos'), ('Postres'), 
('Sandwiches');

-- 	Define el producto como entidad comercial. Nombre, descripción, precio, imagen.
CREATE TABLE productos (
    id_producto INT PRIMARY KEY AUTO_INCREMENT,
    nombre_producto VARCHAR(100),
    descripcion_producto VARCHAR(100),
	imagen_producto VARCHAR(255),
    precio_producto DECIMAL(10,2),
    rela_categoria INT,
    estado_producto TINYINT DEFAULT 1,
    FOREIGN KEY (rela_categoria) REFERENCES categorias_productos(id_categoria)
);

INSERT INTO productos (nombre_producto, descripcion_producto, precio_producto, rela_categoria) VALUES
('Guiso de porotos', 'Porotos, papa, cebolla y chorizo colorado', 2500.00, 1),
('Jugo de naranja', 'Exprimido natural', 800.00, 2),
('Flan casero', 'Flan de huevo con dulce de leche', 1200.00, 3),
('Ensalada César', 'Lechuga, pollo, croutons, queso y aderezo', 2300.00, 4),
('Papas fritas', 'Papas crocantes', 1500.00, 5);

-- Unidad de medida para ingredientes
CREATE TABLE unidades_medida (
    id_unidad INT PRIMARY KEY AUTO_INCREMENT,
    nombre_unidad_medida VARCHAR(50) NOT NULL,
    abreviatura_unidad_medida VARCHAR(10) NOT NULL
);

INSERT INTO unidades_medida (nombre_unidad_medida, abreviatura_unidad_medida) VALUES
('Kilogramo', 'kg'),
('Gramo', 'g'),
('Litro', 'l'),
('Mililitro', 'ml'),
('Unidad', 'unidad'),
('Cucharada', 'cda'),
('Cucharadita', 'cdta'),
('Taza', 'taza'),
('Pizca', 'pizca'),
('Pote', 'pote');

CREATE TABLE ingredientes (
    id_ingrediente INT PRIMARY KEY AUTO_INCREMENT,
    nombre_ingrediente VARCHAR(100) NOT NULL,
    rela_unidad INT NOT NULL,
    FOREIGN KEY (rela_unidad) REFERENCES unidades_medida(id_unidad)
);

INSERT INTO ingredientes (nombre_ingrediente, rela_unidad) VALUES
-- Verduras
('Papa', 1),
('Cebolla', 1),
('Zanahoria', 1),
('Ajo', 5),
('Pimiento rojo', 1),
('Tomate', 1),
('Espinaca', 1),
('Lechuga', 1),

-- Condimentos
('Sal', 9),
('Pimienta', 9),
('Comino', 7),
('Pimentón', 6),
('Orégano', 6),
('Laurel', 5),
('Curry', 6),
('Ajo en polvo', 6),
('Ají molido', 6);

-- Define cómo se compone un producto a nivel de receta (ingredientes y cantidades). Composición de productos (recetas)
CREATE TABLE productos_ingredientes (
    id_producto INT NOT NULL,
    id_ingrediente INT NOT NULL,
    cantidad_ingrediente DECIMAL(10,2) NOT NULL,
    PRIMARY KEY (id_producto, id_ingrediente),
    FOREIGN KEY (id_producto) REFERENCES productos(id_producto),
    FOREIGN KEY (id_ingrediente) REFERENCES ingredientes(id_ingrediente)
);

-- Stock de ingredientes
CREATE TABLE stock_ingredientes (
    id_ingrediente INT PRIMARY KEY,
    cantidad_actual DECIMAL(10,2) DEFAULT 0,
    stock_min_ingredientes INT,
    FOREIGN KEY (id_ingrediente) REFERENCES ingredientes(id_ingrediente)
);

-- Proveedores (requiere tabla personas)
CREATE TABLE proveedores (
    id_proveedor INT PRIMARY KEY AUTO_INCREMENT,
    rela_persona INT,
    razon_social VARCHAR(100) ,
    estado_proveedor TINYINT DEFAULT 1,
    FOREIGN KEY (rela_persona) REFERENCES personas(id_persona)
);

-- Compras de ingredientes a proveedores
CREATE TABLE compras (
    id_compra INT PRIMARY KEY AUTO_INCREMENT,
    fecha_compra DATETIME,
    rela_proveedor INT,
    total_compra DECIMAL(10,2),
    FOREIGN KEY (rela_proveedor) REFERENCES proveedores(id_proveedor)
);

CREATE TABLE detalle_compras (
    id_detalle_compra INT PRIMARY KEY AUTO_INCREMENT,
    rela_compra INT,
    rela_ingrediente INT,
    cantidad_compra DECIMAL(10,2),
    precio_costo DECIMAL(10,2),
    FOREIGN KEY (rela_compra) REFERENCES compras(id_compra),
    FOREIGN KEY (rela_ingrediente) REFERENCES ingredientes(id_ingrediente)
);

-- Pedidos realizados por clientes
CREATE TABLE pedidos (
    id_pedido INT PRIMARY KEY AUTO_INCREMENT,
    fecha_hora_pedido DATETIME,
    tipo_pedido ENUM('Delivery', 'Para llevar'),
    estado_pedido ENUM('Pendiente', 'En preparación', 'Cancelado') 
    DEFAULT 'Pendiente',
	rela_cliente INT,
    rela_empleado INT,
    rela_direccion INT,
	FOREIGN KEY (rela_direccion) REFERENCES direcciones(id_direccion),
    FOREIGN KEY (rela_cliente) REFERENCES clientes(id_cliente),
    FOREIGN KEY (rela_empleado) REFERENCES empleados(id_empleado)
);

-- Detalle de cada pedido (los productos pedidos)
CREATE TABLE detalle_pedidos (
    id_detalle_pedido INT PRIMARY KEY AUTO_INCREMENT,
    cantidad_detalle_pedido INT,
    precio_unitario_detalle_pedido DECIMAL(10,2),
	rela_pedido INT,
    rela_producto INT,
    FOREIGN KEY (rela_pedido) REFERENCES pedidos(id_pedido),
    FOREIGN KEY (rela_producto) REFERENCES productos(id_producto)
);

-- Facturas (comprobante generado al cerrar el pedido)
CREATE TABLE facturas (
    id_factura INT PRIMARY KEY AUTO_INCREMENT,
    rela_pedido INT,
    fecha_emision DATETIME,
    total_factura DECIMAL(10,2),
    FOREIGN KEY (rela_pedido) REFERENCES pedidos(id_pedido)
);

-- Formas de pago
CREATE TABLE formas_pago (
    id_forma_pago INT PRIMARY KEY AUTO_INCREMENT,
    descripcion_forma_pago VARCHAR(50)
);

INSERT INTO formas_pago (descripcion_forma_pago) VALUES
('Efectivo'),
('Tarjeta débito'),
('Tarjeta crédito'),
('Transferencia');

-- 1. Tabla central de transacciones (pagos, cobros, devoluciones)
CREATE TABLE transacciones (
    id_transaccion INT PRIMARY KEY AUTO_INCREMENT,
    tipo_transaccion ENUM('Pago', 'Cobro', 'Devolución') NOT NULL,
    fecha_transaccion DATETIME DEFAULT CURRENT_TIMESTAMP,
    monto_total DECIMAL(10,2) NOT NULL,
    observaciones TEXT
);

-- 2. Relación entre transacción y forma de pago (permite múltiples formas de pago por transacción)
CREATE TABLE pagos (
    id_pago INT PRIMARY KEY AUTO_INCREMENT,
    rela_transaccion INT NOT NULL,
    rela_forma_pago INT NOT NULL,
    FOREIGN KEY (rela_transaccion) REFERENCES transacciones(id_transaccion),
    FOREIGN KEY (rela_forma_pago) REFERENCES formas_pago(id_forma_pago)
);

-- 3. Asociación entre transacción y factura (si aplica)
CREATE TABLE transacciones_facturas (
    rela_transaccion INT,
    rela_factura INT,
    PRIMARY KEY (rela_transaccion, rela_factura),
    FOREIGN KEY (rela_transaccion) REFERENCES transacciones(id_transaccion),
    FOREIGN KEY (rela_factura) REFERENCES facturas(id_factura)
);

-- 4. Asociación opcional con cliente o proveedor
CREATE TABLE transacciones_entidades (
    rela_transaccion INT PRIMARY KEY,
    id_cliente INT,
    id_proveedor INT,
    FOREIGN KEY (rela_transaccion) REFERENCES transacciones(id_transaccion),
    FOREIGN KEY (id_cliente) REFERENCES clientes(id_cliente),
    FOREIGN KEY (id_proveedor) REFERENCES proveedores(id_proveedor)
);

-- Tabla de notificaciones
CREATE TABLE notificaciones (
    id_notificacion INT PRIMARY KEY AUTO_INCREMENT,
    fecha_creacion_notificacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    titulo_notificacion VARCHAR(100) NOT NULL,
    mensaje_notificacion TEXT NOT NULL,
    leida_notificacion TINYINT(1) DEFAULT 0,
    rela_usuario INT,
    FOREIGN KEY (rela_usuario) REFERENCES usuarios(id_usuario)
);

-- Tabla de auditoría
CREATE TABLE auditoria (
    id_auditoria INT PRIMARY KEY AUTO_INCREMENT,
    fecha_hora_auditoria DATETIME DEFAULT CURRENT_TIMESTAMP,
    usuario_auditoria VARCHAR(50),
    accion_auditoria VARCHAR(100),
    tabla_afectada_auditoria VARCHAR(50),
    detalle_auditoria TEXT
);

-- Tabla de puntos acumulados por usuario (un registro por usuario)
CREATE TABLE puntos_usuario (
    rela_usuario INT PRIMARY KEY,
    acumulacion_ptos INT DEFAULT 0,
    canjeados_ptos INT DEFAULT 0,
    fecha_ultima_actualizacion_ptos TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (rela_usuario) REFERENCES usuarios(id_usuario)
);

-- Tabla para registrar los canjes de puntos
CREATE TABLE canjes (
    id_canje INT PRIMARY KEY AUTO_INCREMENT,
    rela_usuario INT NOT NULL,
    ptos_utilizados_canje INT NOT NULL,
    descripcion_canje TEXT,
    fecha_canje TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (rela_usuario) REFERENCES usuarios(id_usuario)
);

-- Tabla para la administración de una caja guarda los cortes de caja o sesiones de caja. Cada vez que se abre o cierra caja, se genera un registro.
CREATE TABLE cajas (
    id_caja INT PRIMARY KEY AUTO_INCREMENT,
    fecha_apertura DATETIME DEFAULT CURRENT_TIMESTAMP,
    fecha_cierre DATETIME NULL,
    monto_apertura DECIMAL(10,2) DEFAULT 0,
    monto_cierre DECIMAL(10,2) DEFAULT 0,
    total_ingresos DECIMAL(10,2) DEFAULT 0,
    total_egresos DECIMAL(10,2) DEFAULT 0,
    observaciones TEXT,
    estado_caja ENUM('Abierta', 'Cerrada') DEFAULT 'Abierta',
    rela_empleado INT,
    FOREIGN KEY (rela_empleado) REFERENCES empleados(id_empleado)
);

-- Tabla para movimientos de la caja registra todos los movimientos de dinero durante una sesión de caja: ingresos (cobros), egresos (pagos, devoluciones), etc.
CREATE TABLE movimientos_caja (
    id_movimiento INT PRIMARY KEY AUTO_INCREMENT,
    fecha_movimiento DATETIME DEFAULT CURRENT_TIMESTAMP,
    tipo_movimiento ENUM('Ingreso', 'Egreso') NOT NULL,
    descripcion_movimiento VARCHAR(255),
    monto_movimiento DECIMAL(10,2) NOT NULL,
    rela_caja INT NOT NULL,
    rela_transaccion INT,
    FOREIGN KEY (rela_caja) REFERENCES cajas(id_caja),
    FOREIGN KEY (rela_transaccion) REFERENCES transacciones(id_transaccion)
);

-- Tabla para reportes por períodos especifícos
CREATE TABLE periodos (
    id_periodo INT PRIMARY KEY AUTO_INCREMENT,
    nombre_periodo VARCHAR(50), 
    fecha_inicio DATE NOT NULL,
    fecha_fin DATE NOT NULL,
    descripcion TEXT
);

-- Tabla devoluciones
CREATE TABLE devoluciones (
    id_devolucion INT PRIMARY KEY AUTO_INCREMENT,
    fecha_devolucion DATETIME DEFAULT CURRENT_TIMESTAMP,
    motivo_devolucion TEXT NOT NULL,
    cantidad_devuelta INT NOT NULL,
    rela_detalle_pedido INT NOT NULL,
    rela_transaccion INT, -- opcional, si hubo devolución de dinero
    rela_empleado INT, -- quien procesó la devolución
    FOREIGN KEY (rela_detalle_pedido) REFERENCES detalle_pedidos(id_detalle_pedido),
    FOREIGN KEY (rela_transaccion) REFERENCES transacciones(id_transaccion),
    FOREIGN KEY (rela_empleado) REFERENCES empleados(id_empleado)
);

-- =========================================
-- Insertar un administrador general del sistema (Perfil 1)
-- =========================================

-- Dirección
INSERT INTO direcciones (calle_direccion, numero_direccion, rela_barrios)
VALUES ('O Higgins', '340', 43);

-- Documento
INSERT INTO detalle_documentos (valor_documento, rela_tipo_documento)
VALUES ('40987501', 1);

-- Contacto
INSERT INTO detalles_contactos (valor_contacto, rela_tipo_contacto)
VALUES ('gastrosystem@gmail.com', 1);

-- Persona
INSERT INTO personas (nombre_persona, apellido_persona, fecha_nacimiento_persona, rela_genero, rela_direccion, rela_documento, rela_contacto)
VALUES ('Alejandro', 'Gonzaléz', '1980-05-01', 1, 1, 1, 1);

-- Usuario
INSERT INTO usuarios (nombre_usuario, password_usuario, rela_persona, rela_perfil)
VALUES ('administrador', '$2y$10$BLTqQRJ2j/.pSjMeMUSp5evPjnOrPRyHdbia1RQycMo66E5URmeGK', 1, 1);

-- =========================================
-- Insertar un encargado (Perfil 2)
-- =========================================

-- Dirección
INSERT INTO direcciones (calle_direccion, numero_direccion, rela_barrios)
VALUES ('San Martín', '120', 4);

-- Documento
INSERT INTO detalle_documentos (valor_documento, rela_tipo_documento)
VALUES ('38765421', 1);

-- Contacto
INSERT INTO detalles_contactos (valor_contacto, rela_tipo_contacto)
VALUES ('encargado@gmail.com', 1);

-- Persona
INSERT INTO personas (nombre_persona, apellido_persona, fecha_nacimiento_persona, rela_genero, rela_direccion, rela_documento, rela_contacto)
VALUES ('Laura', 'Fernández', '1985-11-15', 2, 2, 2, 2);

-- Usuario
INSERT INTO usuarios (nombre_usuario, password_usuario, rela_persona, rela_perfil)
VALUES ('encargado', '$2y$10$GWQIEa66OCBScoQWppkoZ.5iRr/BUpw35xnNWlyoeQiwXAManP2kW', 2, 2);

-- =========================================
-- Insertar un cliente (Perfil 5)
-- =========================================

-- Dirección
INSERT INTO direcciones (calle_direccion, numero_direccion, rela_barrios)
VALUES ('Oliva', '496', 2);

-- Documento
INSERT INTO detalle_documentos (valor_documento, rela_tipo_documento)
VALUES ('32849531', 1);

-- Contacto
INSERT INTO detalles_contactos (valor_contacto, rela_tipo_contacto)
VALUES ('anagomez294@gmail.com', 1);

-- Persona
INSERT INTO personas (nombre_persona, apellido_persona, fecha_nacimiento_persona, rela_genero, rela_direccion, rela_documento, rela_contacto)
VALUES ('Anabella', 'Gómez', '1990-05-20', 2, 3, 3, 3);

-- Cliente
INSERT INTO clientes (rela_persona)
VALUES (3);

-- Usuario
INSERT INTO usuarios (nombre_usuario, password_usuario, rela_persona, rela_perfil)
VALUES ('cliente', '$2y$10$PnOK0L34c73PRTWkFQ4VjuKVxiGMhpxFzw6wPnJxdH1mJjuwfH3by', 3, 5);

-- =========================================
-- Insertar un empleado (Perfil 3)
-- =========================================

-- Dirección
INSERT INTO direcciones (calle_direccion, numero_direccion, rela_barrios)
VALUES ('Belgrano', '789', 3);

-- Documento
INSERT INTO detalle_documentos (valor_documento, rela_tipo_documento)
VALUES ('44156607', 1);

-- Contacto
INSERT INTO detalles_contactos (valor_contacto, rela_tipo_contacto)
VALUES ('carloslopez238@gmail.com', 1);

-- Persona
INSERT INTO personas (nombre_persona, apellido_persona, fecha_nacimiento_persona, rela_genero, rela_direccion, rela_documento, rela_contacto)
VALUES ('Carlos', 'López', '1990-02-20', 1, 4, 4, 4);

-- Empleado
INSERT INTO empleados (rela_persona, fecha_alta_empleado)
VALUES (3, '2024-05-01');

-- Usuario
INSERT INTO usuarios (nombre_usuario, password_usuario, rela_persona, rela_perfil)
VALUES ('empleado', '$2y$10$zPjP1kywOEFShbG1fa4JJeAw8mwWxJjrGvdMgVDm4AAdzsceFpD/G', 3, 3);

-- =========================================
-- Insertar un repartidor (Perfil 4)
-- =========================================

-- Dirección
INSERT INTO direcciones (calle_direccion, numero_direccion, rela_barrios)
VALUES ('Mitre', '55', 5);

-- Documento
INSERT INTO detalle_documentos (valor_documento, rela_tipo_documento)
VALUES ('42563044', 1);

-- Contacto
INSERT INTO detalles_contactos (valor_contacto, rela_tipo_contacto)
VALUES ('diegoramirez2948@gmail.com', 1);

-- Persona
INSERT INTO personas (nombre_persona, apellido_persona, fecha_nacimiento_persona, rela_genero, rela_direccion, rela_documento, rela_contacto)
VALUES ('Diego', 'Ramírez', '1992-08-10', 1, 5, 5, 5);

-- Usuario
INSERT INTO usuarios (nombre_usuario, password_usuario, rela_persona, rela_perfil)
VALUES ('repartidor', '$2y$10$mq5p/RAzpiB9sfR8gg142O9tvw/FCOkd5G0Wsu2YQDbsshj0Q1abC', 4, 4);

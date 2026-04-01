---
[EN]
FastFoodSystem
Sales and Inventory Management System for Gastronomic Businesses

# Technical overview #

FastFoodSystem is a web-based system designed for gastronomic businesses, focused on sales management, inventory control, and user administration.

This project represents an initial functional mockup of a real-world gastronomic management system. It includes a fully working authentication system, role-based access control, master tables, and a complete UI/UX layout for both internal and external areas.

Core system components such as login, user registration, roles, and permissions are fully functional, while the remaining modules are implemented at a structural and interface level, providing a solid foundation for future functional development.

# Implemented features #

Authentication and Security (Fully Functional)

User registration and login.

Secure authentication flow.

Role-Based Access Control (RBAC).

Permission assignment by role.

User account administration.

Sales Management (System Layout)

Sales workflow interface design.

Order and transaction UI structure.

Cash register module layout.

Inventory Management (System Layout)

Product and stock management interfaces.

Category-based product organization.

Stock control logic structure.

# System structure #

Internal system (administrative panel).

External website (public-facing).

Clear separation between public and private areas.

User Roles and Test Credentials

The system includes predefined user roles that represent a real gastronomic business workflow.
The following credentials are provided for testing and demonstration purposes only.

Administrator

Username: administrador

Password: admin123

Permissions: Full system access, user and role management, system configuration.

Manager (Encargado)

Username: encargado

Password: encargado123

Permissions: Operational supervision and inventory management access.

Employee

Username: empleado

Password: empleado123

Permissions: Basic sales-related system access.

Delivery Staff (Repartidor)

Username: repartidor

Password: repartidor123

Permissions: Order delivery tracking and status updates.

Customer

Username: cliente

Password: cliente123

Permissions: Access to the external website and personal account management.

These credentials are intended only for testing. The system architecture supports proper authentication, role-based authorization, and secure credential handling.

# Technologies used #

PHP

JavaScript

HTML5

CSS3

Bootstrap

Relational database schema with master tables 

# Project structure #

/docs
  Software Requirements Specification (SRS) document used as the foundation for system development.

/bd
  Database scripts and test data loaders.

# Installation and testing guide #

Prerequisites

Local web server (XAMPP, WAMP, Laragon, or similar).

PHP enabled.

MySQL or compatible database engine.

Step-by-Step Setup

Download the project
Download the compressed (.zip) file from this repository.

Extract the files
Unzip the downloaded file.

Copy to your web server directory
Place the project folder inside your web server root directory, for example:

htdocs (XAMPP)

www (WAMP)

Configure database connection

Open the database configuration file.

Verify or update database credentials, host, port, and database name if you are using a non-default setup.

Load the database

Access the database installation script.

Execute it with a single click to automatically create the database schema and load test data.

Run the system

Open the project URL in your browser:
http://localhost/FastFoodSystem

# Technical notes #

Authentication, roles, and permissions are fully functional.

Master tables implemented and operational.

Remaining modules implemented as structural and interface definitions.

Modular and scalable architecture prepared for full feature development.

Author

Developed by Lada Elizabet Rodriguez

---
[ES]
FastFoodSystem
Sistema de Gestión de Ventas e Inventario para Negocios Gastronómicos

# Resumen Técnico #

FastFoodSystem es un sistema web diseñado para negocios gastronómicos, enfocado en la gestión de ventas, el control de inventario y la administración de usuarios.

Este proyecto representa una maqueta funcional inicial de un sistema de gestión gastronómica real. Incluye un sistema de autenticación completamente funcional, control de acceso basado en roles, mesas maestras y un diseño UI/UX completo para áreas internas y externas.

Los componentes principales del sistema, como inicio de sesión, registro de usuarios, roles y permisos, son completamente funcionales, mientras que los módulos restantes están implementados a nivel estructural y de interfaz, lo que proporciona una base sólida para el desarrollo funcional futuro.

# Características Implementadas #

Autenticación y Seguridad (Totalmente Funcional)

Registro e inicio de sesión de usuarios.

Flujo de autenticación seguro.

Control de Acceso Basado en Roles (RBAC).

Asignación de permisos por rol.

Administración de cuentas de usuario.

Gestión de Ventas (Diseño del Sistema)

Diseño de la interfaz del flujo de trabajo de ventas.

Estructura de la interfaz de usuario para pedidos y transacciones. Diseño del módulo de caja registradora.

Gestión de inventario (Diseño del sistema)

Interfaces de gestión de productos y existencias.

Organización de productos por categorías.

Estructura lógica de control de existencias.

# Estructura del sistema #

Sistema interno (panel administrativo).

Sitio web externo (público).

Separación clara entre áreas públicas y privadas.

Roles de usuario y credenciales de prueba

El sistema incluye roles de usuario predefinidos que representan el flujo de trabajo real de un negocio gastronómico.
Las siguientes credenciales se proporcionan únicamente con fines de prueba y demostración.

Administrador

Nombre de usuario: administrador

Contraseña: admin123

Permisos: Acceso completo al sistema, gestión de usuarios y roles, configuración del sistema.

Gerente (Encargado)

Nombre de usuario: encargado

Contraseña: encargado123

Permisos: Supervisión operativa y acceso a la gestión de inventario.

Empleado

Nombre de usuario: empleado

Contraseña: empleado123

Permisos: Acceso básico al sistema relacionado con ventas. Repartidor

Nombre de usuario: repartidor

Contraseña: repartidor123

Permisos: Seguimiento de entregas y actualizaciones de estado.

Cliente

Nombre de usuario: cliente

Contraseña: cliente123

Permisos: Acceso al sitio web externo y administración de cuentas personales.

Estas credenciales son solo para pruebas. La arquitectura del sistema admite la autenticación adecuada, la autorización basada en roles y el manejo seguro de credenciales.

# Tecnologías utilizadas #

PHP

JavaScript

HTML5

CSS3

Bootstrap

Esquema de base de datos relacional con tablas maestras

# Estructura del proyecto #

/docs
Documento de Especificación de Requisitos de Software (SRS) utilizado como base para el desarrollo del sistema.

/bd
Scripts de base de datos y cargadores de datos de prueba.

# Guía de instalación y pruebas #

Requisitos previos

Servidor web local (XAMPP, WAMP, Laragon o similar).

PHP habilitado.

MySQL o un motor de base de datos compatible.

Configuración paso a paso

Descargar el proyecto
Descargar el archivo comprimido (.zip) de este repositorio.

Extraer los archivos
Descomprimir el archivo descargado.

Copiar al directorio de su servidor web
Colocar la carpeta del proyecto dentro del directorio raíz de su servidor web, por ejemplo:

htdocs (XAMPP)

www (WAMP)

Configurar la conexión a la base de datos

Abrir el archivo de configuración de la base de datos.

Verificar o actualizar las credenciales de la base de datos, el host, el puerto y el nombre de la base de datos si se utiliza una configuración diferente a la predeterminada.

Cargar la base de datos

Acceder al script de instalación de la base de datos.

Ejecutarlo con un solo clic para crear automáticamente el esquema de la base de datos y cargar los datos de prueba.

Ejecutar el sistema

Abrir la URL del proyecto en su navegador:
http://localhost/FastFoodSystem

# Notas técnicas #

La autenticación, los roles y los permisos son completamente funcionales.

Tablas maestras implementadas y operativas.

Los módulos restantes se implementaron como definiciones estructurales y de interfaz.

Arquitectura modular y escalable, preparada para el desarrollo completo de funcionalidades.

Autor/a

Desarrollado por Lada Elizabet Rodriguez

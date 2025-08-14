# Sistema de Facturación en PHP

Este es un sistema de facturación completo desarrollado en PHP y JavaScript, utilizando Materialize CSS como framework de frontend. Permite la gestión de clientes, productos, y el ciclo completo de facturación desde cotizaciones hasta facturas y pagos.

## Características

-   **Gestión de Clientes:** CRUD completo para el catálogo de clientes.
-   **Gestión de Productos:** CRUD completo para productos y servicios.
-   **Ciclo de Documentos:**
    -   Creación y gestión de Cotizaciones.
    -   Creación y gestión de Órdenes de Venta.
    -   Creación y gestión de Facturas.
-   **Funcionalidades de Factura:**
    -   Cancelación de facturas.
    -   Registro y control de pagos.
-   **Catálogos del SAT:** Integración de catálogos para Uso de CFDI, Método de Pago y Forma de Pago.
-   **Autenticación:** Sistema de login para proteger el acceso a la aplicación.

## Requisitos

-   PHP 7.4 o superior.
-   Servidor web como Apache o Nginx.
-   Base de datos MySQL o MariaDB.

## Instalación y Configuración

Sigue estos pasos para poner en marcha el proyecto en tu entorno local.

### 1. Configurar la Base de Datos

1.  **Importar el esquema:** Utiliza un gestor de bases de datos como phpMyAdmin o la línea de comandos para importar el archivo `database.sql` en tu base de datos. Esto creará todas las tablas necesarias.

    ```sh
    mysql -u tu_usuario -p tu_base_de_datos < database.sql
    ```

2.  **Configurar la conexión:** Abre el archivo `src/config/config.php` y actualiza las constantes de la base de datos con tus credenciales.

    ```php
    // Database configuration
    define('DB_HOST', 'localhost');
    define('DB_USERNAME', 'tu_usuario');
    define('DB_PASSWORD', 'tu_contraseña');
    define('DB_NAME', 'facturacion_db'); // El nombre que le diste a tu BD
    ```

### 2. Poblar la Base de Datos (Catálogos y Admin)

Para que el sistema funcione correctamente, necesitas poblar las tablas con datos iniciales y crear un usuario administrador por defecto.

El script de siembra (`seed.php`) se encarga de:
- Poblar los catálogos del SAT (formas de pago, uso de CFDI, etc.).
- Poblar la tabla de códigos postales de México para la funcionalidad de autocompletado de direcciones. La fuente de estos datos es `data/CPdescarga.txt`.
- Crear un usuario administrador por defecto.

Ejecuta el siguiente comando desde la raíz del proyecto para realizar todas estas acciones:

```sh
php seed.php
```

Esto poblará los catálogos y creará un usuario con las siguientes credenciales:
-   **Usuario:** `admin`
-   **Contraseña:** `admin`

### 3. Ejecutar la Aplicación

Coloca los archivos del proyecto en el directorio de tu servidor web (ej. `htdocs` en XAMPP, `www` en WampServer) y navega a la URL correspondiente en tu navegador.

Serás redirigido a la página de login. ¡Usa las credenciales del administrador para ingresar!

## Estructura del Proyecto

-   `/api`: Endpoints de la API para la comunicación entre el frontend y el backend.
-   `/assets`: Archivos CSS, JS e imágenes.
-   `/data`: Contiene archivos de datos para la siembra, como el catálogo de códigos postales.
-   `/src`: Código fuente de PHP.
    -   `/config`: Archivo de configuración.
    -   `/lib`: Clases base, como la de la base de datos.
    -   `/models`: Modelos que interactúan con la base de datos.
-   `/templates`: Plantillas HTML para las diferentes vistas de la aplicación.
-   `index.php`: Enrutador principal y punto de entrada.
-   `database.sql`: Esquema de la base de datos.
-   `create_admin.php`: Script para crear el usuario admin.
-   `README.md`: Este archivo.

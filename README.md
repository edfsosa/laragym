# Laragym

**Laragym** es una aplicación web desarrollada con Laravel y Filament para la gestión integral de gimnasios. Permite administrar usuarios, membresías, rutinas de entrenamiento, pagos, entrenadores y mucho más desde un panel centralizado y moderno.

## Características Principales

-   Gestión de usuarios y roles (entrenadores, miembros, administradores).
-   Control de membresías, tipos de planes y pagos.
-   Asignación y seguimiento de rutinas de entrenamiento.
-   Programación de clases y reservas.
-   Registro de progreso y rutinas completadas.
-   Panel de administración con interfaz intuitiva (Filament).
-   Dashboard con estadísticas del gimnasio.
-   🌐 Portal web para miembros y entrenadores.

## Requisitos del Sistema

-   PHP >= 8.2
-   Composer
-   MySQL / MariaDB / PostgreSQL
-   Node.js & NPM (para compilación de assets con Vite)
-   Extensiones PHP habilitadas: `pdo`, `mbstring`, `openssl`, `tokenizer`, `xml`, `ctype`, `json`, `bcmath`

## Instalación

1. Clona el repositorio:

    ```bash
    git clone https://github.com/edfsosa/laragym.git
    ```

2. Entra al directorio del proyecto:

    ```bash
    cd laragym
    ```

3. Instala las dependencias de PHP:

    ```bash
    composer install
    ```

4. Copia el archivo `.env` y configura las variables:

    ```bash
    cp .env.example .env
    ```

5. Genera la clave de la aplicación:

    ```bash
    php artisan key:generate
    ```

6. Configura tu base de datos en el archivo `.env` y luego ejecuta:

    ```bash
    php artisan migrate --seed
    ```

7. Instala dependencias de frontend y compila los assets:
    ```bash
    npm install && npm run build
    ```

## Uso

1. Levanta el servidor de desarrollo:

    ```bash
    php artisan serve
    ```

2. Accede desde tu navegador:

    ```
    http://localhost:8000
    ```

3. Accede al **Panel Administrativo** en:
    ```
    http://localhost:8000/admin
    ```

## Acceso por defecto

Puedes iniciar sesión en el panel de administración con las siguientes credenciales (si está sembrado con `--seed`):

-   **Email**: admin@example.com
-   **Contraseña**: password

> Se recomienda cambiar la contraseña después del primer ingreso.

## Estructura del Proyecto

-   `app/Models`: Modelos del sistema.
-   `app/Filament`: Recursos de administración.
-   `resources/views`: Vistas del portal para miembros y entrenadores.
-   `database/migrations`: Migraciones de la base de datos.
-   `routes/web.php`: Rutas web públicas y protegidas.
-   `routes/filament.php`: Rutas del panel de administración.

## Contribuciones

¡Las contribuciones son bienvenidas! Si deseas mejorar Laragym:

1. Haz un fork del repositorio.
2. Crea una nueva rama: `git checkout -b feature/nueva-funcionalidad`.
3. Realiza tus cambios y haz commit: `git commit -m 'Agrega nueva funcionalidad'`.
4. Sube tus cambios: `git push origin feature/nueva-funcionalidad`.
5. Abre un Pull Request.

## Licencia

Este proyecto está licenciado bajo [MIT License](LICENSE).

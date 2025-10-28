# Laragym

Laragym es una aplicación desarrollada con Laravel para la gestión de gimnasios. Este proyecto permite administrar usuarios, membresías, clases y más.

## Características

- Gestión de usuarios y roles.
- Control de membresías y pagos.
- Programación de clases y horarios.
- Panel de administración intuitivo.

## Requisitos

- PHP >= 8.0
- Composer
- MySQL o cualquier base de datos compatible con Laravel

## Instalación

1. Clona el repositorio:
    ```bash
    git clone https://github.com/tu-usuario/laragym.git
    ```
2. Navega al directorio del proyecto:
    ```bash
    cd laragym
    ```
3. Instala las dependencias:
    ```bash
    composer install
    ```
4. Configura el archivo `.env`:
    ```bash
    cp .env.example .env
    ```
    Actualiza las credenciales de la base de datos en el archivo `.env`.

5. Genera la clave de la aplicación:
    ```bash
    php artisan key:generate
    ```
6. Ejecuta las migraciones:
    ```bash
    php artisan migrate
    ```

## Uso

1. Inicia el servidor de desarrollo:
    ```bash
    php artisan serve
    ```
2. Accede a la aplicación en tu navegador:
    ```
    http://localhost:8000
    ```

## Contribuciones

¡Las contribuciones son bienvenidas! Por favor, abre un issue o envía un pull request.

## Licencia

Este proyecto está bajo la licencia [MIT](LICENSE).
# 🚀 Proyecto PHP MySQL - Prueba de Configuración

Este es un proyecto simple de PHP y MySQL diseñado para probar la correcta configuración de Visual Studio Code en Ubuntu con WSL (Windows Subsystem for Linux).

## 📋 Descripción

El proyecto incluye una aplicación web básica que demuestra:
- Conexión a base de datos MySQL usando PDO
- Operaciones CRUD (Crear, Leer, Actualizar, Eliminar)
- Interfaz web responsive con CSS moderno
- Gestión de usuarios y productos
- Estructura de proyecto organizada

# � Proyecto PHP MySQL - Prueba de Configuración

Este es un proyecto simple de PHP y MySQL diseñado para probar la correcta configuración de Visual Studio Code en Ubuntu con WSL.

## � Descripción

Aplicación web básica que demuestra conexión a MySQL con PDO y operaciones CRUD.

## 🛠️ Requisitos Previos

- PHP 7.4+
- MySQL / MariaDB
- Visual Studio Code

## 🚀 Instalación rápida

```bash
git clone https://github.com/albertbertus/proyecto-php-mysql.git
cd proyecto-php-mysql
```

Configura la base de datos y ejecuta el script `sql/setup.sql` desde MySQL.

Edita `includes/config.php` con tus credenciales locales o utiliza variables de entorno.

Para desarrollo rápido:

```bash
php -S localhost:8000
# abrir http://localhost:8000
```

## 🔗 Repositorio

El código fuente está publicado en: https://github.com/albertbertus/proyecto-php-mysql

## ⚠️ Nota de seguridad

No subas a GitHub archivos con credenciales sensibles. El archivo `includes/config.php` contiene credenciales de ejemplo. Para compartir el proyecto públicamente considera:

- Mover las credenciales a un archivo `.env` y añadirlo a `.gitignore`.
- Usar variables de entorno en producción.
- Regenerar credenciales si se publicaron por error.

---

¡Disfruta desarrollando con PHP y MySQL! 🎉
# 🚀 Proyecto PHP MySQL - Prueba de Configuración

Este es un proyecto simple de PHP y MySQL diseñado para probar la correcta configuración de Visual Studio Code en Ubuntu con WSL (Windows Subsystem for Linux).

## 📋 Descripción

El proyecto incluye una aplicación web básica que demuestra:
- Conexión a base de datos MySQL usando PDO
- Operaciones CRUD (Crear, Leer, Actualizar, Eliminar)
- Interfaz web responsive con CSS moderno
- Gestión de usuarios y productos
- Estructura de proyecto organizada

## 🛠️ Requisitos Previos

### Software Necesario

1. **Ubuntu en WSL** (Windows Subsystem for Linux)
2. **PHP 7.4 o superior**
3. **MySQL 5.7 o superior** (o MariaDB)
4. **Visual Studio Code** con extensiones para PHP
5. **Servidor web** (Apache o Nginx) o PHP Built-in Server

### Instalación de Dependencias en Ubuntu WSL

```bash
# Actualizar el sistema
sudo apt update && sudo apt upgrade -y

# Instalar PHP y extensiones necesarias
sudo apt install php php-mysql php-pdo php-mbstring php-curl php-json -y

# Instalar MySQL Server
sudo apt install mysql-server -y

# Iniciar y configurar MySQL
sudo service mysql start
sudo mysql_secure_installation

# Instalar Apache (opcional, si no usas PHP Built-in Server)
sudo apt install apache2 -y
```

## 📁 Estructura del Proyecto

```
proyecto-php-mysql/
├── css/
│   └── styles.css          # Estilos CSS modernos y responsive
├── includes/
│   ├── config.php          # Configuración de base de datos
│   └── crud.php            # Funciones CRUD avanzadas
├── sql/
│   └── setup.sql           # Script de inicialización de BD
├── index.php               # Página principal
└── README.md               # Documentación (este archivo)
```

## 🚀 Instalación y Configuración

### Paso 1: Clonar o Descargar el Proyecto

Si tienes este proyecto en un repositorio:
```bash
git clone [URL_DEL_REPOSITORIO]
cd proyecto-php-mysql
```

### Paso 2: Configurar la Base de Datos

1. **Accede a MySQL:**
```bash
sudo mysql -u root -p
```

2. **Ejecuta el script de configuración:**
```sql
source sql/setup.sql
```

3. **Verifica que se creó correctamente:**
```sql
USE proyecto_prueba;
SHOW TABLES;
SELECT * FROM usuarios;
SELECT * FROM productos;
```

### Paso 3: Configurar la Conexión

1. **Edita el archivo `includes/config.php` (ya configurado):**
```php
// Credenciales preconfiguradas para el proyecto
define('DB_HOST', 'localhost');
define('DB_USERNAME', 'proyecto_user');
define('DB_PASSWORD', 'proyecto123');
define('DB_NAME', 'proyecto_prueba');
```

### Paso 4: Ejecutar el Proyecto

#### Opción A: PHP Built-in Server (Recomendado para desarrollo)
```bash
# Navega al directorio del proyecto
cd /ruta/hacia/proyecto-php-mysql

# Inicia el servidor PHP
php -S localhost:8000

# Abre tu navegador en: http://localhost:8000
```

#### Opción B: Apache Server
```bash
# Copia el proyecto a la carpeta web de Apache
sudo cp -r . /var/www/html/proyecto-php-mysql

# Inicia Apache
sudo service apache2 start

# Abre tu navegador en: http://localhost/proyecto-php-mysql
```

## 🔧 Configuración de Visual Studio Code

### Extensiones Recomendadas

Instala estas extensiones en VSCode para una mejor experiencia de desarrollo:

1. **PHP Intelephense** - Autocompletado y análisis de código PHP
2. **PHP Debug** - Depuración de código PHP
3. **MySQL** - Gestión de bases de datos MySQL
4. **Auto Rename Tag** - Renombrado automático de etiquetas HTML
5. **Prettier** - Formateador de código
6. **GitLens** - Herramientas avanzadas de Git

### Configuración de VSCode para WSL

1. **Instala la extensión "Remote - WSL"**
2. **Abre VSCode desde WSL:**
```bash
code .
```

3. **Configura el depurador PHP** (archivo `.vscode/launch.json`):
```json
{
    "version": "0.2.0",
    "configurations": [
        {
            "name": "Listen for Xdebug",
            "type": "php",
            "request": "launch",
            "port": 9003,
            "pathMappings": {
                "/var/www/html": "${workspaceFolder}"
            }
        }
    ]
}
```

## 🎯 Funcionalidades del Proyecto

### Gestión de Usuarios
- ✅ Listar usuarios registrados
- ✅ Agregar nuevos usuarios
- ✅ Eliminar usuarios existentes
- ✅ Validación de datos de entrada

### Gestión de Productos
- ✅ Catálogo de productos
- ✅ Agregar nuevos productos
- ✅ Eliminar productos
- ✅ Categorización de productos
- ✅ Control de stock y precios

### Características Técnicas
- ✅ Conexión segura a MySQL con PDO
- ✅ Prevención de inyección SQL
- ✅ Diseño responsive
- ✅ Interfaz moderna con CSS3
- ✅ Manejo de errores
- ✅ Validación de formularios

## 🔍 Pruebas de Funcionamiento

### 1. Verificar Conexión a Base de Datos
Al cargar la página principal, deberías ver:
- Estado de conexión: "Conectado correctamente"
- Número de usuarios y productos registrados

### 2. Probar Operaciones CRUD
- **Crear:** Agrega un nuevo usuario o producto
- **Leer:** Visualiza las tablas de datos
- **Eliminar:** Usa los botones de "Eliminar"

### 3. Verificar Responsive Design
- Redimensiona la ventana del navegador
- Prueba en diferentes dispositivos

## 🐛 Solución de Problemas

### Error: "No se pudo conectar a la base de datos"
1. Verifica que MySQL esté funcionando: `sudo service mysql status`
2. Confirma las credenciales en `includes/config.php`
3. Asegúrate de que la base de datos `proyecto_prueba` exista

### Error: "Call to undefined function mysql_connect()"
- Instala la extensión PHP MySQL: `sudo apt install php-mysql`
- Reinicia el servidor web

### Error: "Permission denied" al acceder a archivos
```bash
# Ajusta los permisos del directorio
sudo chown -R $USER:$USER /ruta/hacia/proyecto
chmod -R 755 /ruta/hacia/proyecto
```

### El servidor PHP no inicia
```bash
# Verifica la instalación de PHP
php -v

# Reinstala PHP si es necesario
sudo apt install --reinstall php
```

## 📚 Recursos Adicionales

### Documentación Útil
- [PHP Manual](https://www.php.net/manual/)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [PDO Tutorial](https://phpdelusions.net/pdo)
- [WSL Documentation](https://docs.microsoft.com/en-us/windows/wsl/)

### Comandos Útiles de MySQL
```sql
-- Ver todas las bases de datos
SHOW DATABASES;

-- Usar una base de datos específica
USE proyecto_prueba;

-- Ver todas las tablas
SHOW TABLES;

-- Describir estructura de una tabla
DESCRIBE usuarios;

-- Respaldar base de datos
mysqldump -u root -p proyecto_prueba > backup.sql

-- Restaurar base de datos
mysql -u root -p proyecto_prueba < backup.sql
```

## 🤝 Contribuciones

Este proyecto está diseñado para pruebas de configuración. Si encuentras problemas o mejoras:

1. Documenta el problema claramente
2. Incluye información del sistema (PHP, MySQL versions)
3. Proporciona pasos para reproducir el error

## 📄 Licencia

Este proyecto está bajo la Licencia MIT. Puedes usarlo libremente para aprendizaje y desarrollo.

## 📞 Soporte

Si necesitas ayuda adicional:
1. Revisa la sección de "Solución de Problemas"
2. Verifica la documentación oficial de PHP y MySQL
3. Consulta los logs de error del servidor web

---

**¡Disfruta desarrollando con PHP y MySQL en Visual Studio Code! 🎉**
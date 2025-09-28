<?php
/**
 * Configuración de la base de datos (cargada desde variables de entorno)
 */

// Cargar .env (si existe)
require_once __DIR__ . '/env.php';

// Definir constantes a partir de variables de entorno
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USERNAME', getenv('DB_USERNAME') ?: 'root');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'database');
define('DB_CHARSET', getenv('DB_CHARSET') ?: 'utf8mb4');

/**
 * Clase Database para manejar la conexión a MySQL
 */
class Database {
    private $host = DB_HOST;
    private $username = DB_USERNAME;
    private $password = DB_PASSWORD;
    private $database = DB_NAME;
    private $charset = DB_CHARSET;
    private $connection = null;

    /**
     * Obtener la conexión a la base de datos
     */
    public function getConnection() {
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->database . ";charset=" . $this->charset;
            $this->connection = new PDO($dsn, $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            return $this->connection;
        } catch(PDOException $e) {
            echo "Error de conexión: " . $e->getMessage();
            return null;
        }
    }

    /**
     * Cerrar la conexión
     */
    public function closeConnection() {
        $this->connection = null;
    }
}

/**
 * Función para obtener una conexión de base de datos
 */
function getDBConnection() {
    $database = new Database();
    return $database->getConnection();
}
?>
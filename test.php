<?php
/**
 * Script de prueba rápida para verificar la configuración
 * Ejecuta este archivo para comprobar que todo funciona correctamente
 */

echo "🔧 PRUEBA DE CONFIGURACIÓN PHP + MySQL\n";
echo "=====================================\n\n";

// Verificar versión de PHP
echo "📋 Información del Sistema:\n";
echo "- Versión de PHP: " . phpversion() . "\n";
echo "- Sistema Operativo: " . php_uname() . "\n";
echo "- Servidor Web: " . $_SERVER['SERVER_SOFTWARE'] ?? 'PHP Built-in Server' . "\n\n";

// Verificar extensiones de PHP necesarias
echo "🧩 Extensiones de PHP:\n";
$extensiones = ['pdo', 'pdo_mysql', 'mysqli', 'mbstring', 'json'];
foreach ($extensiones as $ext) {
    $estado = extension_loaded($ext) ? '✅' : '❌';
    echo "- {$ext}: {$estado}\n";
}
echo "\n";

// Probar conexión a la base de datos
echo "🗄️ Prueba de Conexión a MySQL:\n";
require_once 'includes/config.php';

try {
    $db = new Database();
    $conn = $db->getConnection();
    
    if ($conn) {
        echo "✅ Conexión exitosa a MySQL\n";
        echo "- Host: " . DB_HOST . "\n";
        echo "- Base de datos: " . DB_NAME . "\n";
        
        // Probar consultas básicas
        $stmt = $conn->query("SELECT COUNT(*) as count FROM usuarios");
        $usuarios = $stmt->fetch()['count'];
        
        $stmt = $conn->query("SELECT COUNT(*) as count FROM productos");
        $productos = $stmt->fetch()['count'];
        
        echo "- Usuarios en BD: {$usuarios}\n";
        echo "- Productos en BD: {$productos}\n";
        
        echo "\n📊 Estadísticas adicionales:\n";
        
        // Obtener información de MySQL
        $stmt = $conn->query("SELECT VERSION() as version");
        $mysql_version = $stmt->fetch()['version'];
        echo "- Versión de MySQL: {$mysql_version}\n";
        
        // Verificar tablas
        $stmt = $conn->query("SHOW TABLES");
        $tablas = $stmt->fetchAll(PDO::FETCH_COLUMN);
        echo "- Tablas disponibles: " . implode(', ', $tablas) . "\n";
        
    } else {
        echo "❌ Error al conectar con MySQL\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}

echo "\n🚀 PRUEBAS COMPLETADAS\n";
echo "===================\n\n";

if (php_sapi_name() === 'cli') {
    echo "💡 Para probar la interfaz web, ejecuta:\n";
    echo "   php -S localhost:8000\n";
    echo "   Luego abre: http://localhost:8000\n\n";
}

echo "📖 Para más información, consulta el archivo README.md\n";
?>
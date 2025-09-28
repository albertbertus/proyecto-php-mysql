<?php
/**
 * Funciones CRUD (Create, Read, Update, Delete)
 * Operaciones avanzadas para la base de datos
 */

require_once 'config.php';

/**
 * Clase para manejar operaciones de usuarios
 */
class UsuarioManager {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    /**
     * Obtener todos los usuarios con paginación
     */
    public function obtenerUsuarios($limite = 10, $offset = 0) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios ORDER BY fecha_registro DESC LIMIT ? OFFSET ?");
        $stmt->execute([$limite, $offset]);
        return $stmt->fetchAll();
    }

    /**
     * Obtener un usuario por ID
     */
    public function obtenerUsuarioPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Crear un nuevo usuario
     */
    public function crearUsuario($nombre, $email, $telefono) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO usuarios (nombre, email, telefono) VALUES (?, ?, ?)");
            $stmt->execute([$nombre, $email, $telefono]);
            return ['success' => true, 'id' => $this->conn->lastInsertId()];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Actualizar un usuario
     */
    public function actualizarUsuario($id, $nombre, $email, $telefono) {
        try {
            $stmt = $this->conn->prepare("UPDATE usuarios SET nombre = ?, email = ?, telefono = ? WHERE id = ?");
            $stmt->execute([$nombre, $email, $telefono, $id]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Eliminar un usuario
     */
    public function eliminarUsuario($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM usuarios WHERE id = ?");
            $stmt->execute([$id]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Buscar usuarios por nombre o email
     */
    public function buscarUsuarios($termino) {
        $stmt = $this->conn->prepare("SELECT * FROM usuarios WHERE nombre LIKE ? OR email LIKE ?");
        $termino = "%{$termino}%";
        $stmt->execute([$termino, $termino]);
        return $stmt->fetchAll();
    }

    /**
     * Contar total de usuarios
     */
    public function contarUsuarios() {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM usuarios");
        return $stmt->fetchColumn();
    }
}

/**
 * Clase para manejar operaciones de productos
 */
class ProductoManager {
    private $conn;

    public function __construct() {
        $this->conn = getDBConnection();
    }

    /**
     * Obtener todos los productos con paginación
     */
    public function obtenerProductos($limite = 10, $offset = 0) {
        $stmt = $this->conn->prepare("SELECT * FROM productos ORDER BY fecha_creacion DESC LIMIT ? OFFSET ?");
        $stmt->execute([$limite, $offset]);
        return $stmt->fetchAll();
    }

    /**
     * Obtener un producto por ID
     */
    public function obtenerProductoPorId($id) {
        $stmt = $this->conn->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    /**
     * Crear un nuevo producto
     */
    public function crearProducto($nombre, $descripcion, $precio, $stock, $categoria) {
        try {
            $stmt = $this->conn->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, categoria) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$nombre, $descripcion, $precio, $stock, $categoria]);
            return ['success' => true, 'id' => $this->conn->lastInsertId()];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Actualizar un producto
     */
    public function actualizarProducto($id, $nombre, $descripcion, $precio, $stock, $categoria) {
        try {
            $stmt = $this->conn->prepare("UPDATE productos SET nombre = ?, descripcion = ?, precio = ?, stock = ?, categoria = ? WHERE id = ?");
            $stmt->execute([$nombre, $descripcion, $precio, $stock, $categoria, $id]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Eliminar un producto
     */
    public function eliminarProducto($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM productos WHERE id = ?");
            $stmt->execute([$id]);
            return ['success' => true];
        } catch (PDOException $e) {
            return ['success' => false, 'error' => $e->getMessage()];
        }
    }

    /**
     * Buscar productos por nombre o categoría
     */
    public function buscarProductos($termino) {
        $stmt = $this->conn->prepare("SELECT * FROM productos WHERE nombre LIKE ? OR categoria LIKE ? OR descripcion LIKE ?");
        $termino = "%{$termino}%";
        $stmt->execute([$termino, $termino, $termino]);
        return $stmt->fetchAll();
    }

    /**
     * Obtener productos por categoría
     */
    public function obtenerProductosPorCategoria($categoria) {
        $stmt = $this->conn->prepare("SELECT * FROM productos WHERE categoria = ?");
        $stmt->execute([$categoria]);
        return $stmt->fetchAll();
    }

    /**
     * Obtener productos con stock bajo
     */
    public function obtenerProductosStockBajo($limite = 5) {
        $stmt = $this->conn->prepare("SELECT * FROM productos WHERE stock <= ? ORDER BY stock ASC");
        $stmt->execute([$limite]);
        return $stmt->fetchAll();
    }

    /**
     * Contar total de productos
     */
    public function contarProductos() {
        $stmt = $this->conn->query("SELECT COUNT(*) FROM productos");
        return $stmt->fetchColumn();
    }

    /**
     * Obtener estadísticas de productos
     */
    public function obtenerEstadisticas() {
        $stats = [];
        
        // Total de productos
        $stats['total_productos'] = $this->contarProductos();
        
        // Valor total del inventario
        $stmt = $this->conn->query("SELECT SUM(precio * stock) as valor_total FROM productos");
        $stats['valor_inventario'] = $stmt->fetchColumn();
        
        // Productos por categoría
        $stmt = $this->conn->query("SELECT categoria, COUNT(*) as cantidad FROM productos GROUP BY categoria");
        $stats['por_categoria'] = $stmt->fetchAll();
        
        // Producto más caro
        $stmt = $this->conn->query("SELECT nombre, precio FROM productos ORDER BY precio DESC LIMIT 1");
        $stats['mas_caro'] = $stmt->fetch();
        
        return $stats;
    }
}

/**
 * Función para probar la conexión y las operaciones básicas
 */
function probarConexion() {
    try {
        $conn = getDBConnection();
        if ($conn) {
            echo "✅ Conexión a la base de datos exitosa\n";
            
            // Probar operaciones básicas
            $usuarioManager = new UsuarioManager();
            $productoManager = new ProductoManager();
            
            $totalUsuarios = $usuarioManager->contarUsuarios();
            $totalProductos = $productoManager->contarProductos();
            
            echo "👥 Usuarios en la base de datos: {$totalUsuarios}\n";
            echo "📦 Productos en la base de datos: {$totalProductos}\n";
            
            return true;
        } else {
            echo "❌ Error al conectar con la base de datos\n";
            return false;
        }
    } catch (Exception $e) {
        echo "❌ Error: " . $e->getMessage() . "\n";
        return false;
    }
}
?>
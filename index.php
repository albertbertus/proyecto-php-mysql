<?php
// Incluir la configuración de la base de datos
require_once 'includes/config.php';

// Manejar las acciones del formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = getDBConnection();
    
    if (isset($_POST['action'])) {
        switch ($_POST['action']) {
            case 'add_user':
                $nombre = $_POST['nombre'];
                $email = $_POST['email'];
                $telefono = $_POST['telefono'];
                
                $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, telefono) VALUES (?, ?, ?)");
                $stmt->execute([$nombre, $email, $telefono]);
                $mensaje = "Usuario agregado exitosamente.";
                break;
                
            case 'add_product':
                $nombre = $_POST['nombre'];
                $descripcion = $_POST['descripcion'];
                $precio = $_POST['precio'];
                $stock = $_POST['stock'];
                $categoria = $_POST['categoria'];
                
                $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, categoria) VALUES (?, ?, ?, ?, ?)");
                $stmt->execute([$nombre, $descripcion, $precio, $stock, $categoria]);
                $mensaje = "Producto agregado exitosamente.";
                break;
                
            case 'delete_user':
                $id = $_POST['id'];
                $stmt = $conn->prepare("DELETE FROM usuarios WHERE id = ?");
                $stmt->execute([$id]);
                $mensaje = "Usuario eliminado exitosamente.";
                break;
                
            case 'delete_product':
                $id = $_POST['id'];
                $stmt = $conn->prepare("DELETE FROM productos WHERE id = ?");
                $stmt->execute([$id]);
                $mensaje = "Producto eliminado exitosamente.";
                break;
        }
    }
}

// Obtener datos para mostrar
$conn = getDBConnection();
if ($conn) {
    $usuarios = $conn->query("SELECT * FROM usuarios ORDER BY id DESC")->fetchAll();
    $productos = $conn->query("SELECT * FROM productos ORDER BY id DESC")->fetchAll();
} else {
    $error = "No se pudo conectar a la base de datos. Verifica la configuración.";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proyecto PHP MySQL - Prueba de Configuración</title>
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <header>
        <h1>🚀 Proyecto PHP MySQL</h1>
        <p>Prueba de configuración de Visual Studio Code con Ubuntu en WSL</p>
    </header>

    <div class="container">
        <?php if (isset($mensaje)): ?>
            <div class="alert alert-success"><?php echo $mensaje; ?></div>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php else: ?>
            
            <!-- Estado de la conexión -->
            <div class="status-panel">
                <h2>✅ Estado de la Conexión</h2>
                <p><strong>Base de datos:</strong> <?php echo DB_NAME; ?></p>
                <p><strong>Host:</strong> <?php echo DB_HOST; ?></p>
                <p><strong>Estado:</strong> <span class="status-ok">Conectado correctamente</span></p>
                <p><strong>Usuarios registrados:</strong> <?php echo count($usuarios); ?></p>
                <p><strong>Productos en catálogo:</strong> <?php echo count($productos); ?></p>
            </div>

            <!-- Sección de Usuarios -->
            <div class="section">
                <h2>👥 Gestión de Usuarios</h2>
                
                <div class="form-container">
                    <h3>Agregar Nuevo Usuario</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="add_user">
                        <div class="form-group">
                            <input type="text" name="nombre" placeholder="Nombre completo" required>
                        </div>
                        <div class="form-group">
                            <input type="email" name="email" placeholder="Email" required>
                        </div>
                        <div class="form-group">
                            <input type="tel" name="telefono" placeholder="Teléfono">
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Usuario</button>
                    </form>
                </div>

                <div class="table-container">
                    <h3>Lista de Usuarios</h3>
                    <?php if (!empty($usuarios)): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Fecha Registro</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($usuarios as $usuario): ?>
                                    <tr>
                                        <td><?php echo $usuario['id']; ?></td>
                                        <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                        <td><?php echo htmlspecialchars($usuario['email']); ?></td>
                                        <td><?php echo htmlspecialchars($usuario['telefono']); ?></td>
                                        <td><?php echo date('d/m/Y H:i', strtotime($usuario['fecha_registro'])); ?></td>
                                        <td>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="action" value="delete_user">
                                                <input type="hidden" name="id" value="<?php echo $usuario['id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No hay usuarios registrados.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Sección de Productos -->
            <div class="section">
                <h2>📦 Gestión de Productos</h2>
                
                <div class="form-container">
                    <h3>Agregar Nuevo Producto</h3>
                    <form method="POST">
                        <input type="hidden" name="action" value="add_product">
                        <div class="form-group">
                            <input type="text" name="nombre" placeholder="Nombre del producto" required>
                        </div>
                        <div class="form-group">
                            <textarea name="descripcion" placeholder="Descripción del producto"></textarea>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <input type="number" name="precio" step="0.01" placeholder="Precio" required>
                            </div>
                            <div class="form-group">
                                <input type="number" name="stock" placeholder="Stock" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <select name="categoria" required>
                                <option value="">Selecciona una categoría</option>
                                <option value="Electrónicos">Electrónicos</option>
                                <option value="Accesorios">Accesorios</option>
                                <option value="Audio">Audio</option>
                                <option value="Oficina">Oficina</option>
                                <option value="Gaming">Gaming</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Agregar Producto</button>
                    </form>
                </div>

                <div class="table-container">
                    <h3>Catálogo de Productos</h3>
                    <?php if (!empty($productos)): ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Precio</th>
                                    <th>Stock</th>
                                    <th>Categoría</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($productos as $producto): ?>
                                    <tr>
                                        <td><?php echo $producto['id']; ?></td>
                                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                                        <td><?php echo htmlspecialchars(substr($producto['descripcion'], 0, 50)) . '...'; ?></td>
                                        <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                                        <td><?php echo $producto['stock']; ?></td>
                                        <td><?php echo htmlspecialchars($producto['categoria']); ?></td>
                                        <td>
                                            <form method="POST" style="display:inline;">
                                                <input type="hidden" name="action" value="delete_product">
                                                <input type="hidden" name="id" value="<?php echo $producto['id']; ?>">
                                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro?')">Eliminar</button>
                                            </form>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p>No hay productos en el catálogo.</p>
                    <?php endif; ?>
                </div>
            </div>

        <?php endif; ?>
    </div>

    <footer>
        <p>Proyecto de prueba PHP + MySQL | Visual Studio Code + Ubuntu WSL | <?php echo date('Y'); ?></p>
    </footer>
</body>
</html>
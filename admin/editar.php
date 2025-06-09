<?php
require '../config/bbdd.php';

$db = new Database();
$con = $db->conectar();

$id = $_GET['id'] ?? null;
$mensaje = "";

// Obtener producto
if ($id) {
    $sql = $con->prepare("SELECT * FROM productos WHERE id = ?");
    $sql->execute([$id]);
    $producto = $sql->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        die("Producto no encontrado.");
    }
} else {
    die("ID inválido.");
}

// Actualizar producto
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $descripcion = $_POST['descripcion'];
    $precio = floatval($_POST['precio']);
    $categoria = intval($_POST['categoria']);
    $activo = isset($_POST['activo']) ? 1 : 0;
    $descuento = intval($_POST['descuento']);

    $stmt = $con->prepare("UPDATE productos SET nombre = ?, descrpcion = ?, precio = ?, id_categoria = ?, activo = ?, descuento = ? WHERE id = ?");
    $stmt->execute([$nombre, $descripcion, $precio, $categoria, $activo, $descuento, $id]);

    $mensaje = "✅ Producto actualizado correctamente.";
    // Recargar producto
    $sql = $con->prepare("SELECT * FROM productos WHERE id = ?");
    $sql->execute([$id]);
    $producto = $sql->fetch(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2>Editar producto: <?php echo htmlspecialchars($producto['nombre']); ?></h2>
    <?php if ($mensaje): ?>
        <div class="alert alert-success"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="<?php echo htmlspecialchars($producto['nombre']); ?>" required>
        </div>
        <div class="mb-3">
            <label>Descripción</label>
            <textarea name="descripcion" class="form-control" required><?php echo htmlspecialchars($producto['descrpcion']); ?></textarea>
        </div>
        <div class="mb-3">
            <label>Precio</label>
            <input type="number" name="precio" step="0.01" class="form-control" value="<?php echo $producto['precio']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Categoría (ID)</label>
            <input type="number" name="categoria" class="form-control" value="<?php echo $producto['id_categoria']; ?>" required>
        </div>
        <div class="mb-3">
            <label>Descuento (%)</label>
            <input type="number" name="descuento" class="form-control" value="<?php echo $producto['descuento']; ?>" min="0" max="100">
        </div>
        <div class="form-check mb-3">
            <input type="checkbox" name="activo" class="form-check-input" id="activo" <?php if ($producto['activo']) echo "checked"; ?>>
            <label for="activo" class="form-check-label">Activo</label>
        </div>
        <button class="btn btn-primary" type="submit">Guardar cambios</button>
        <a href="visualizar.php" class="btn btn-secondary">Volver</a>
    </form>
</body>
</html>

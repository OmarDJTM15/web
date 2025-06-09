<?php
require '../config/bbdd.php';

$db = new Database();
$con = $db->conectar();

$mensaje = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $precio = floatval($_POST['precio'] ?? 0);
    $categoria = intval($_POST['categoria'] ?? 0);
    $activo = isset($_POST['activo']) ? 1 : 0;
    $descuento = isset($_POST['descuento']) ?? 0;

    if ($nombre && $descripcion && $precio > 0) {
        $sql = $con->prepare("INSERT INTO productos (nombre, descrpcion, precio, id_categoria, activo, descuento) VALUES (?, ?, ?, ?, ?,?)");
        $sql->execute([$nombre, $descripcion, $precio, $categoria, $activo, $descuento]);
        $mensaje = "✅ Producto agregado correctamente.";
    } else {
        $mensaje = "⚠️ Por favor llena todos los campos obligatorios.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2>Agregar nuevo producto</h2>

    <?php if ($mensaje): ?>
        <div class="alert alert-info"><?php echo $mensaje; ?></div>
    <?php endif; ?>

    <form method="post">
        <div class="mb-3">
            <label class="form-label">Nombre del producto</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Descripción</label>
            <textarea name="descripcion" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Precio</label>
            <input type="number" step="0.01" name="precio" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Categoría (ID)</label>
            <input type="number" name="categoria" class="form-control" required>
        </div>
        

        <div class="form-check mb-3">
            <input class="form-check-input" type="checkbox" name="activo" id="activo" checked>
            <label class="form-check-label" for="activo">
                Producto activo
            </label>
        </div>
        <div class="mb-3">
            <label class="form-label">Descuento</label>
            <input type="number" name="categoria" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Guardar producto</button>
        <a href="visualizar.php" class="btn btn-secondary">Volver</a>
    </form>
</body>
</html>

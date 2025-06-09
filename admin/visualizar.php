<?php
require '../config/bbdd.php';

$db = new Database();
$con = $db->conectar();

$sql = $con->query("SELECT * FROM productos ORDER BY id ASC");
$productos = $sql->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    <h2>Lista de productos en la base de datos</h2>
    <a href="add.php" class="btn btn-success mb-3">Agregar nuevo producto</a>
    <a href="../index.php" class="btn btn-secondary mb-3">Volver al inicio</a>

    <?php if (count($productos) > 0): ?>
        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Precio</th>
                    <th>Categoría</th>
                    <th>Activo</th>
                    <th>Descuento</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productos as $producto): ?>
                    <tr>
                        <td><?php echo $producto['id']; ?></td>
                        <td><?php echo htmlspecialchars($producto['nombre']); ?></td>
                        <td><?php echo htmlspecialchars($producto['descrpcion']); ?></td>
                        <td>$<?php echo number_format($producto['precio'], 2); ?></td>
                        <td><?php echo $producto['id_categoria']; ?></td>
                        <td><?php echo $producto['activo'] ? 'Sí' : 'No'; ?></td>
                        <td><?php echo $producto['descuento']; ?>%</td>
                        <td>
                            <a href="editar.php?id=<?php echo $producto['id']; ?>" class="btn btn-sm btn-primary">Editar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <p class="alert alert-warning">No hay productos registrados.</p>
    <?php endif; ?>
</body>
</html>

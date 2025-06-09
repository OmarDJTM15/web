<?php
// Crear base de datos SQLite y tabla productos
$db = new SQLite3(__DIR__ . '/../admin/tienda.db');

// Crear tabla (sin coma final)
$db->exec("
    CREATE TABLE IF NOT EXISTS productos (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nombre TEXT NOT NULL,
        descrpcion TEXT NOT NULL,
        precio REAL NOT NULL,
        id_categoria INTEGER NOT NULL,
        activo INTEGER NOT NULL,
        descuento INTEGER NOT NULL
    );
");

// Insertar datos
$db->exec("
    INSERT INTO productos (nombre, descrpcion, precio, id_categoria, activo, descuento) VALUES
        ('Playera blanca personalizable', 'playera personalizada blanca extra comoda', 500.00, 1, 1, 0),
        ('playera negra personalizada', 'playera personalizada blanca extra comoda', 300.00, 1, 1, 0),
        ('Playera estampado graduacion', 'Playera estampado graduacion', 250.00, 1, 1, 0),
        ('Playera RABBIT CLOTHING', 'Playera RABBIT CLOTHING NEGRA', 700.00, 1, 1, 0)
");

echo "Base de datos SQLite creada con éxito.";
?>

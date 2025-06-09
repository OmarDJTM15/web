<?php
class Database
{
    private $dbfile;

    function __construct()
    {
        // Ruta absoluta al archivo .db (desde cualquier subcarpeta como /admin)
        $this->dbfile = __DIR__ . '/../admin/tienda.db';
    }
    function conectar()
    {
        try {
            $pdo = new PDO("sqlite:" . $this->dbfile);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        } catch (PDOException $e) {
            echo 'Error de conexión: ' . $e->getMessage();
            exit;
        }
    }
}
?>

<?php
include "conexion.php"; // Este archivo debe definir $pdo como PDO

$sql = "SELECT * FROM productos";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($productos);
?>

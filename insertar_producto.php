<?php
include "conexion.php"; // define $pdo

$nombre = $_POST["nombre"] ?? '';
$categoria = $_POST["categoria"] ?? '';
$precio = $_POST["precio"] ?? 0;

$sql = "INSERT INTO productos (nombre, categoria, precio) VALUES (?, ?, ?)";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([$nombre, $categoria, $precio])) {
  echo "OK";
} else {
  $error = $stmt->errorInfo();
  echo "Error: " . $error[2];
}
?>

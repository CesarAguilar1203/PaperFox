<?php
include "conexion.php";

$id = $_POST["id"] ?? 0;
$nombre = $_POST["nombre"] ?? '';
$categoria = $_POST["categoria"] ?? '';
$precio = $_POST["precio"] ?? 0;

$sql = "UPDATE productos SET nombre = ?, categoria = ?, precio = ? WHERE id = ?";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([$nombre, $categoria, $precio, $id])) {
  echo "OK";
} else {
  $error = $stmt->errorInfo();
  echo "Error: " . $error[2];
}
?>

<?php
include "conexion.php";

$id = $_POST["id"] ?? 0;

$sql = "DELETE FROM productos WHERE id = ?";
$stmt = $pdo->prepare($sql);

if ($stmt->execute([$id])) {
  echo "OK";
} else {
  $error = $stmt->errorInfo();
  echo "Error: " . $error[2];
}
?>

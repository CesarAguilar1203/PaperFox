<?php
include "conexion.php";

$nombre = $_POST["nombre"];
$categoria = $_POST["categoria"];
$precio = $_POST["precio"];

$sql = "INSERT INTO productos (nombre, categoria, precio) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssd", $nombre, $categoria, $precio);

if ($stmt->execute()) {
  echo "OK";
} else {
  echo "Error: " . $stmt->error;
}
?>

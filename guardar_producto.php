<?php
include "conexion.php";

$id = $_POST["id"];
$nombre = $_POST["nombre"];
$categoria = $_POST["categoria"];
$precio = $_POST["precio"];

$sql = "UPDATE productos SET nombre=?, categoria=?, precio=? WHERE id=?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssdi", $nombre, $categoria, $precio, $id);

if ($stmt->execute()) {
  echo "OK";
} else {
  echo "Error: " . $stmt->error;
}
?>
<?php
include "conexion.php";

$id = $_POST["id"];

$sql = "DELETE FROM productos WHERE id=?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
  echo "OK";
} else {
  echo "Error: " . $stmt->error;
}
?>

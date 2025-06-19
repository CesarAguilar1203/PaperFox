<?php
include 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $nombre_completo = $_POST['nombre_completo'] ?? '';
  $correo = $_POST['correo'] ?? '';
  $mensaje = $_POST['mensaje'] ?? '';

  if (!$nombre_completo || !$correo || !$mensaje) {
    echo "Faltan datos obligatorios";
    exit;
  }

  $sql = "INSERT INTO contactos (nombre_completo, correo, mensaje) VALUES (?, ?, ?)";
  $stmt = $pdo->prepare($sql);

  if ($stmt->execute([$nombre_completo, $correo, $mensaje])) {
    echo "OK";
  } else {
    $error = $stmt->errorInfo();
    echo "Error al guardar mensaje: " . $error[2];
  }
}
?>

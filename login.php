<?php
session_start();
include 'conexion.php'; // Aquí defines $pdo

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $correo = $_POST['correo'] ?? '';
  $contraseña = $_POST['contraseña'] ?? '';

  if (!$correo || !$contraseña) {
    echo "Faltan datos";
    exit;
  }

  $stmt = $pdo->prepare("SELECT id, contraseña FROM usuarios WHERE correo = ?");
  $stmt->execute([$correo]);
  $user = $stmt->fetch();

  if ($user) {
    $hash_en_bd = $user['contraseña'];

    // Verifica si ya es un hash válido (empieza con '$2y$')
    if (str_starts_with($hash_en_bd, '$2y$')) {
      // Ya está hasheada, verificar con password_verify
      if (password_verify($contraseña, $hash_en_bd)) {
        $_SESSION['usuario_id'] = $user['id'];
        echo "OK";
      } else {
        echo "Contraseña incorrecta";
      }
    } else {
      // Aún no hasheada: compararla directamente
      if ($contraseña === $hash_en_bd) {
        // Hashear y actualizar en la base de datos
        $nuevo_hash = password_hash($contraseña, PASSWORD_DEFAULT);
        $update = $pdo->prepare("UPDATE usuarios SET contraseña = ? WHERE id = ?");
        $update->execute([$nuevo_hash, $user['id']]);

        $_SESSION['usuario_id'] = $user['id'];
        echo "OK (contraseña actualizada)";
      } else {
        echo "Contraseña incorrecta";
      }
    }
  } else {
    echo "Usuario no encontrado";
  }
}
?>

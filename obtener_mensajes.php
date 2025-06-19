<?php
header('Content-Type: application/json; charset=utf-8');
include 'conexion.php';

try {
    $stmt = $pdo->query("SELECT nombre_completo, correo, asunto, mensaje, fecha_envio FROM contactos ORDER BY fecha_envio DESC");
    $mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($mensajes);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?>

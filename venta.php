<?php
include 'conexion.php'; // Tu archivo de conexión debe definir $conexion (mysqli)

header('Content-Type: application/json');

// Leer el JSON enviado desde JS
$data = json_decode(file_get_contents('php://input'), true);
$productos = $data['productos'] ?? [];

if (empty($productos)) {
    echo json_encode(['status' => 'error', 'message' => 'No hay productos']);
    exit;
}

// Calcular total de la venta
$total = 0;
foreach ($productos as $p) {
    // Validar que tenga campos necesarios
    if (!isset($p['id'], $p['precio'], $p['cantidad'])) {
        echo json_encode(['status' => 'error', 'message' => 'Datos de producto incompletos']);
        exit;
    }
    $total += $p['precio'] * $p['cantidad'];
}

// Iniciar transacción
$conexion->begin_transaction();

try {
    // Insertar en tabla ventas
    $stmt = $conexion->prepare("INSERT INTO ventas (total) VALUES (?)");
    $stmt->bind_param("d", $total);
    $stmt->execute();
    $id_venta = $conexion->insert_id;

    // Insertar detalle_ventas
    $stmt_detalle = $conexion->prepare("INSERT INTO detalle_ventas (venta_id, producto_id, cantidad, precio) VALUES (?, ?, ?, ?)");

    foreach ($productos as $p) {
        $stmt_detalle->bind_param("iiid", $id_venta, $p['id'], $p['cantidad'], $p['precio']);
        $stmt_detalle->execute();
    }

    // Confirmar transacción
    $conexion->commit();

    echo json_encode(['status' => 'ok', 'message' => 'Venta guardada']);
} catch (Exception $e) {
    // Si algo falla, revertir todo
    $conexion->rollback();

    echo json_encode(['status' => 'error', 'message' => 'Error al guardar la venta: ' . $e->getMessage()]);
}
?>

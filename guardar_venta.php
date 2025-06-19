<?php
header('Content-Type: application/json; charset=utf-8');
include 'conexion.php';

$data = json_decode(file_get_contents('php://input'), true);

$productos = $data['items'] ?? [];

if (empty($productos)) {
    echo json_encode(['status' => 'error', 'message' => 'No hay productos en la venta']);
    exit;
}

try {
    $pdo->beginTransaction();

    // Calcular total
    $total = 0;
    foreach ($productos as $p) {
        $total += $p['precio_unitario'] * $p['cantidad'];
    }

    // Insertar venta
    $stmt = $pdo->prepare("INSERT INTO ventas (total) VALUES (:total)");
    $stmt->execute(['total' => $total]);
    $id_venta = $pdo->lastInsertId();

    // Insertar detalles de venta
    $stmtDetalle = $pdo->prepare("
        INSERT INTO detalle_ventas (id_venta, id_producto, cantidad, precio_unitario)
        VALUES (:id_venta, :id_producto, :cantidad, :precio_unitario)
    ");

    foreach ($productos as $p) {
        $stmtDetalle->execute([
            'id_venta' => $id_venta,
            'id_producto' => $p['id_producto'],
            'cantidad' => $p['cantidad'],
            'precio_unitario' => $p['precio_unitario']
        ]);
    }

    $pdo->commit();

    echo json_encode(['status' => 'ok', 'message' => 'Venta guardada correctamente']);

} catch (Exception $e) {
    $pdo->rollBack();
    echo json_encode(['status' => 'error', 'message' => 'Error al guardar la venta: ' . $e->getMessage()]);
}
?>

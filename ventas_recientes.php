<?php
header('Content-Type: application/json; charset=utf-8');
include 'conexion.php';

try {
    $sql = "
        SELECT v.fecha, p.nombre, p.categoria, dv.cantidad, dv.precio_unitario
        FROM ventas v
        JOIN detalle_ventas dv ON v.id = dv.id_venta
        JOIN productos p ON p.id = dv.id_producto
        ORDER BY v.fecha DESC
        LIMIT 20
    ";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $ventas = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($ventas);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>

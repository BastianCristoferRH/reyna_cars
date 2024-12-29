<?php
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rut = $_POST['rut'] ?? null;
    $repuestos_seleccionados = array_filter($_POST['repuestos'] ?? []); // Filtra valores vacíos

    if (!$rut || empty($repuestos_seleccionados)) {
        die("<p style='color:red;'>Por favor, ingresa un RUT y selecciona al menos un repuesto.</p>");
    }

    $query_cliente = "SELECT nombre, apellido, direccion FROM ft_form_1 WHERE identificacion = ?";
    $stmt_cliente = $connection->prepare($query_cliente);
    $stmt_cliente->bind_param("s", $rut);
    $stmt_cliente->execute();
    $result_cliente = $stmt_cliente->get_result();
    $cliente = $result_cliente->fetch_assoc();

    if (!$cliente) {
        die("<p style='color:red;'>No se encontró un cliente con el RUT proporcionado.</p>");
    }

    $repuestos = [];
    $total = 0;

    foreach ($repuestos_seleccionados as $repuesto_id) {
        $query_repuesto = "SELECT marca, modelo, anio, descripcion, precio FROM ft_form_3 WHERE submission_id = ?";
        $stmt_repuesto = $connection->prepare($query_repuesto);
        $stmt_repuesto->bind_param("i", $repuesto_id);
        $stmt_repuesto->execute();
        $result_repuesto = $stmt_repuesto->get_result();

        if ($result_repuesto && $result_repuesto->num_rows > 0) {
            $repuesto = $result_repuesto->fetch_assoc();
            $repuestos[] = $repuesto;
            $total += $repuesto['precio'];
        }
    }

    if (empty($repuestos)) {
        die("<p style='color:red;'>No se encontraron los repuestos seleccionados.</p>");
    }
} else {
    die("<p style='color:red;'>Acceso no válido.</p>");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Factura</title>
</head>
<body>
    <h1>Factura</h1>

    <h3>Datos del Cliente:</h3>
    <p><strong>Nombre:</strong> <?= $cliente['nombre'] ?> <?= $cliente['apellido'] ?></p>
    <p><strong>Dirección:</strong> <?= $cliente['direccion'] ?></p>
    <p><strong>RUT:</strong> <?= $rut ?></p>

    <h3>Detalles de los Repuestos:</h3>
    <ul>
        <?php foreach ($repuestos as $repuesto): ?>
            <li>
                <?= $repuesto['marca'] ?> - <?= $repuesto['modelo'] ?> (<?= $repuesto['anio'] ?>) - <?= $repuesto['descripcion'] ?> - $<?= $repuesto['precio'] ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <h3>Total a pagar:</h3>
    <p><strong>$<?= $total ?></strong></p>

    <a href="index.php">Volver</a>
</body>
</html>

<?php
require_once 'conexion.php';

$query_repuestos = "SELECT submission_id, marca, modelo, anio, descripcion, precio FROM ft_form_3";
$result_repuestos = $connection->query($query_repuestos);

$repuestos = [];
if ($result_repuestos && $result_repuestos->num_rows > 0) {
    while ($row = $result_repuestos->fetch_assoc()) {
        $repuestos[] = $row;
    }
}

function obtenerClientePorRUT($connection, $rut) {
    $query_cliente = "SELECT nombre, apellido, direccion FROM ft_form_1 WHERE identificacion = ?";
    $stmt = $connection->prepare($query_cliente);
    $stmt->bind_param("s", $rut);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generar Factura</title>
</head>
<body>
    <h1>Generar Factura</h1>
    
    <form action="factura.php" method="POST">
        <label for="rut">Ingrese el RUT del cliente:</label>
        <input type="text" id="rut" name="rut" placeholder="19835151-2" required>
        
        <h3>Seleccione hasta 3 repuestos:</h3>

        <label for="repuesto1">Repuesto 1:</label>
        <select name="repuestos[]" id="repuesto1">
            <option value="">Seleccione un repuesto</option>
            <?php foreach ($repuestos as $repuesto): ?>
                <option value="<?= $repuesto['submission_id'] ?>">
                    <?= $repuesto['marca'] ?> - <?= $repuesto['modelo'] ?> (<?= $repuesto['anio'] ?>) - <?= $repuesto['descripcion'] ?> - $<?= $repuesto['precio'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="repuesto2">Repuesto 2:</label>
        <select name="repuestos[]" id="repuesto2">
            <option value="">Seleccione un repuesto</option>
            <?php foreach ($repuestos as $repuesto): ?>
                <option value="<?= $repuesto['submission_id'] ?>">
                    <?= $repuesto['marca'] ?> - <?= $repuesto['modelo'] ?> (<?= $repuesto['anio'] ?>) - <?= $repuesto['descripcion'] ?> - $<?= $repuesto['precio'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <label for="repuesto3">Repuesto 3:</label>
        <select name="repuestos[]" id="repuesto3">
            <option value="">Seleccione un repuesto</option>
            <?php foreach ($repuestos as $repuesto): ?>
                <option value="<?= $repuesto['submission_id'] ?>">
                    <?= $repuesto['marca'] ?> - <?= $repuesto['modelo'] ?> (<?= $repuesto['anio'] ?>) - <?= $repuesto['descripcion'] ?> - $<?= $repuesto['precio'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit">Generar Factura</button>
    </form>

    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['rut']) && isset($_POST['repuestos'])) {
            $rut = $_POST['rut'];
            $repuestos_seleccionados = array_filter($_POST['repuestos']); // Filtra valores vacíos

            // Buscar datos del cliente
            $cliente = obtenerClientePorRUT($connection, $rut);

            if (!$cliente) {
                echo "<p style='color:red;'>No se encontró un cliente con el RUT proporcionado.</p>";
            } elseif (count($repuestos_seleccionados) > 3) {
                echo "<p style='color:red;'>Puedes seleccionar un máximo de 3 repuestos.</p>";
            } else {
                $total = 0;
                echo "<h2>Factura:</h2>";
                echo "<p><strong>Cliente:</strong> " . $cliente['nombre'] . " " . $cliente['apellido'] . "</p>";
                echo "<p><strong>Dirección:</strong> " . $cliente['direccion'] . "</p>";
                echo "<ul>";

                foreach ($repuestos_seleccionados as $repuesto_id) {
                    $query = "SELECT marca, modelo, anio, descripcion, precio FROM ft_form_3 WHERE submission_id = ?";
                    $stmt = $connection->prepare($query);
                    $stmt->bind_param("i", $repuesto_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result && $result->num_rows > 0) {
                        $repuesto = $result->fetch_assoc();
                        echo "<li>" . $repuesto['marca'] . " - " . $repuesto['modelo'] . " (" . $repuesto['anio'] . ") - " . $repuesto['descripcion'] . " - $" . $repuesto['precio'] . "</li>";
                        $total += $repuesto['precio'];
                    }
                }

                echo "</ul>";
                echo "<h3>Total a pagar: $" . $total . "</h3>";
            }
        }
    }
    ?>
</body>
</html>

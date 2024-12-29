<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Repuestos</title>
</head>
<body>
    <h1>Formulario de Registro de Repuestos</h1>
    <form action="http://localhost/reyna_cars/formtools/process.php" method="POST">
        <input type="hidden" name="form_tools_form_id" value="3" />
        <label for="marca">Marca:</label>
        <input type="text" id="marca" name="marca" required><br><br>
        <label for="modelo">Modelo:</label>
        <input type="text" id="modelo" name="modelo" required><br><br>
        <label for="anio">Año:</label>
        <input type="text" id="anio" name="anio" required><br><br>
        <label for="num_parte">Número de Parte:</label>
        <input type="text" id="num_parte" name="num_parte" required><br><br>
        <label for="codigo">Código:</label>
        <input type="text" id="codigo" name="codigo" required><br><br>
        <label for="descripcion">Descripción:</label>
        <input type="text" id="descripcion" name="descripcion" required><br><br>
        <label for="precio">Precio:</label>
        <input type="number" id="precio" name="precio" required><br><br>

        <button type="submit">Registrar Repuesto</button>
    </form>
</body>
</html>

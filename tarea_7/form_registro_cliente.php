<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario de Registro de Clientes</title>
</head>

<body>
    <h1>Formulario de Registro de Clientes</h1>
    <!-- Agregamos la ubicacion del archivo del form tools -->
    <form action="http://localhost/reyna_cars/formtools/process.php" method="post">
        <!--le asignamos la id del formulario creado en form tool-->
        <input type="hidden" name="form_tools_form_id" value="1" />
        <!--le colocamos los input para pasarselo al form tools-->
        <label for="nombre">Nombre:</label>
        <input type="text" id="nombre" name="nombre" required>
        <br><br>
        <label for="apellido">Apellido:</label>
        <input type="text" id="apellido" name="apellido" required>
        <br><br>
        <label for="identificacion">Identificación (Rut):</label>
        <input type="text" id="identificacion" name="identificacion" required>
        <br><br>
        <label for="sexo">Sexo:</label>
        <select id="sexo" name="sexo" required>
            <option value="Masculino">Masculino</option>
            <option value="Femenino">Femenino</option>
            <option value="Otro">Otro</option>
        </select>
        <br><br>
        <label for="direccion">Dirección:</label>
        <input type="text" id="direccion" name="direccion" required>
        <br><br>
        <label for="telefono">Teléfono:</label>
        <input type="tel" id="telefono" name="telefono" required>
        <br><br>
        <label for="correo">Correo Electrónico:</label>
        <input type="email" id="correo" name="correo" required>
        <br><br>
        <!--lo mandamos con un submit -->
        <button type="submit">Enviar</button>
    </form>
</body>

</html>
<?php
//validacion de los inputs
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $usuario = $_POST['usuario']; //usuario
    $clave = $_POST['clave']; //clave
    //el usuario tiene que estar en palabras minuscula y contener 6 caracteres
    if (!preg_match("/^[a-z]{6}$/", $usuario)) {
        $error = "El usuario debe tener exactamente 6 caracteres en minúscula."; // error en caso de que no cumple
    //la clave debe contener letras mayusculas y un minimo de 6 caractares o mas
    } else if (!preg_match("/^[A-Z]{6,}$/", $clave)) {
        $error = "La clave debe tener al menos 6 caracteres en mayúscula.";
    }

    if (!isset($error)) {
        echo "Formulario enviado correctamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuarios</title>
</head>

<body>
    <h1>Formulario de Registro de Usuarios</h1>

    <?php
    //condicional si no cumple con unos de los requerimientos no funcionales
    if (isset($error)) {
        echo "<p style='color: red;'>$error</p>";
    }
    ?>
    <!--formulario conectado con form tools-->
    <form action="http://localhost/reyna_cars/formtools/process.php" method="post">
        <input type="hidden" name="form_tools_form_id" value="4" />
        <label for="usuario">Usuario:</label>
        <input type="text" id="usuario" name="usuario" required minlength="6" maxlength="6"><br><br> <!--realizamos otra validacion  con max y min-->
        <label for="clave">Clave:</label>
        <input type="password" id="clave" name="clave" required minlength="6"><br><br> <!--validamos con minlength-->

        <button type="submit">Registrar Usuario</button>
    </form>
</body>

</html>
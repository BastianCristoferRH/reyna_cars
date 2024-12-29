<?php

/**
 * File: process.php
 *
 * This file processes any form submissions for forms already added and configured within Form Tools.
 * It initializes the form or processes a regular form submission.
 */

// Habilitar el reporte de todos los errores y mostrar errores en la pantalla
error_reporting(E_ALL);
ini_set('display_errors', 1);  // Habilita la visualización de errores
ini_set('log_errors', 1);      // Habilita el registro de errores
ini_set('error_log', __DIR__ . '/error_log.txt');  // Ruta de archivo de registro de errores

use FormTools\Core;
use FormTools\Forms;
use FormTools\Submissions;
use FormTools\Themes;

// Incluir las funciones de la biblioteca principal
require_once(__DIR__ . "/global/library.php");

// Si se proporciona la API, inclúyela también
@include_once(__DIR__ . "/global/api/api.php");

Core::init();
$LANG = Core::$L;

// Verifica si se recibieron datos POST
if (empty($_POST)) {
    $page_vars = array("message_type" => "error", "message" => $LANG["processing_no_post_vars"]);
    Themes::displayPage("error.tpl", $page_vars);
    exit;
}

// Depuración: Muestra los datos POST recibidos
echo '<pre>';
print_r($_POST);  // Muestra todos los datos POST recibidos
echo '</pre>';

// Verifica si el ID del formulario está presente
if (empty($_POST["form_tools_form_id"])) {
    $page_vars = array("message_type" => "error", "message" => $LANG["processing_no_form_id"]);
    Themes::displayPage("error.tpl", $page_vars);
    exit;
}

// Depuración: Muestra el ID del formulario
echo 'Formulario ID: ' . $_POST["form_tools_form_id"];

// Intenta inicializar o procesar la presentación del formulario
try {
    // Si es una inicialización del formulario
    if (isset($_POST["form_tools_initialize_form"])) {
        // Depuración: Muestra los datos antes de inicializar el formulario
        echo 'Inicializando formulario con los siguientes datos:';
        print_r($_POST);
        Forms::initializeForm($_POST);
    } 
    // Si es una presentación de formulario regular
    else {
        // Depuración: Muestra los datos antes de procesar la presentación del formulario
        echo 'Procesando datos del formulario:';
        print_r($_POST);
        Submissions::processFormSubmission($_POST);
    }
} catch (Exception $e) {
    // Si ocurre una excepción, muestra el mensaje de error
    echo 'Error: ' . $e->getMessage();
    exit;
}

?>

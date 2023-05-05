<?php

// Carico gli script di base
spl_autoload_register(function ($class) {
    require __DIR__ . "/../../common/$class.php";
});

// Importo la classe Sessione
require __DIR__ . "/../../model/contatto.php";

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

header("Content-type: application/json; charset=UTF-8");

if (!isset($_GET['id']) || empty($id = $_GET['id']))
{
    echo json_encode(array("Message" => "No id passed"));
    die();
}

$contatto = new Contatto();

$result = $contatto->ottieniTuttiContatti($id);

echo json_encode(array("contatti" => $result));
?>
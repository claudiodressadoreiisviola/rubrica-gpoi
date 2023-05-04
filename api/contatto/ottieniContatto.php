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
//qui result è un array
$result = $contatto->ottieniContatto($id);
//adesso result è un oggetto
$result = (json_decode(json_encode($result)));

if ((int)$result->id >0)
{

    echo json_encode($result, JSON_PRETTY_PRINT);
    die();
}
else
{
    echo json_encode(array("Message" => "No record"));
    die();
}
?>

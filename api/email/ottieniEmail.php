<?php

// Carico gli script di base
spl_autoload_register(function ($class) {
    require __DIR__ . "/../../common/$class.php";
});

// Importo la classe Sessione
require __DIR__ . "/../../model/email.php";

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

header("Content-type: application/json; charset=UTF-8");

if (!isset($_GET['id']) || empty($id = $_GET['id']))
{
    echo json_encode(array("Message" => "No id passed"));
    die();
}

$email = new Email();

//qui result è un array
$result = $email->ottieniEmail($id);

if ($result == false)
{
    echo json_encode(array("message" => "Nessun record trovato"), JSON_PRETTY_PRINT);
}
else
{
    echo json_encode($result, JSON_PRETTY_PRINT);
}

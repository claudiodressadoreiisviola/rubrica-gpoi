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
$result = $email->ottieniTutteEmail($id);

$emails = array();
for ($i = 0; $i < (count($result)); $i++) {
    $mail = array(
        "id" =>  $result[$i]['id'],
        "cognome" => $result[$i]["cognome"],
        "nome" => $result[$i]["nome"],
        "sito_web" => $result[$i]["sito_web"],
        "indirizzo" => $result[$i]["indirizzo"],
        "descrizione" => $result[$i]["descrizione"],
    );
    array_push($emails, $mail);
}

echo json_encode($emails);
?>
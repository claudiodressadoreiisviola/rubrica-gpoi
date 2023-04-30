<?php

// Carico gli script di base
spl_autoload_register(function ($class) {
    require __DIR__ . "/../../common/$class.php";
});

// Importo la classe Sessione
require __DIR__ . "/../../model/telefono.php";

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

header("Content-type: application/json; charset=UTF-8");

if (!isset($_GET['id']) || empty($id = $_GET['id']))
{
    echo json_encode(array("Message" => "No id passed"));
    die();
}

$telefono = new Telefono();
$result = $telefono->ottieniTuttiTelefoni($id);

$telefoni = array();
for ($i = 0; $i < (count($result)); $i++) {
    $telephone= array(
        "id" =>  $result[$i]['id'],
        "cognome" => $result[$i]["cognome"],
        "nome" => $result[$i]["nome"],
        "sito_web" => $result[$i]["sito_web"],
        "numero" => $result[$i]["numero"],
        "cc" => $result[$i]["cc"],
        "descrizione" => $result[$i]["descrizione"],
    );
    array_push($telefoni, $telephone);
}

echo json_encode($telefoni);
?>
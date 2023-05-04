<?php

// Carico gli script di base
spl_autoload_register(function ($class) {
    require __DIR__ . "/../../common/$class.php";
});

// Importo la classe Sessione
require __DIR__ . "/../../model/indirizzo.php";

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

header("Content-type: application/json; charset=UTF-8");

if (!isset($_GET['id']) || empty($id = $_GET['id']))
{
    echo json_encode(array("Message" => "No id passed"));
    die();
}

$indirizzo = new Indirizzo();
$result = $indirizzo->ottieniTuttiIndirizzi($id);

$indirizzi = array();
for ($i = 0; $i < (count($result)); $i++) {
    $address= array(
        "id" =>  $result[$i]['id'],
        "cognome" => $result[$i]["cognome"],
        "nome" => $result[$i]["nome"],
        "sito_web" => $result[$i]["sito_web"],
        "comune" => $result[$i]["comune"],
        "provincia" => $result[$i]["provinica"],
        "codice_postale" => $result[$i]["codice_postale"],
        "tipo_via" => $result[$i]["tipo_via"],
        "via" => $result[$i]["via"],
        "descrizione" => $result[$i]["descrizione"],
    );
    array_push($indirizzi, $address);
}

echo json_encode($indirizzi);
?>
<?php

// Carico gli script di base
spl_autoload_register(function ($class) {
    require __DIR__ . "/../../common/$class.php";
});

// Importo la classe Sessione
require __DIR__ . "/../../model/utente.php";

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

$data = json_decode(file_get_contents("php://input"));

if (empty($data->email) || empty($data->password)) {
    http_response_code(400);
    echo json_encode(array("message" => "Informazioni inviate non corrette o insufficienti, contattare l'amministratore per maggiori informazioni"));
    die();
}

$utente = new Utente();

try {
    echo json_encode(array("ID" => $utente->login($data->email, $data->password)));

    setcookie("sessione", $this->SessionID, time()+60*60*24*30, '/');
} catch (Exception $e) {
    echo json_encode(array("message" => $e->getMessage()));
}
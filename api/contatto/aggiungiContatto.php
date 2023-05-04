<?php

spl_autoload_register(function ($class) {
    require __DIR__ . "/../../common/$class.php";
});

require __DIR__ . '/../../model/contatto.php';
$data = json_decode(file_get_contents("php://input"));


if (empty($data->nome) || empty($data->cognome) || empty($data->sito_web)) {
    http_response_code(400);
    echo json_encode(["message" => "Compila tutti i campi"]);
    die();
}

$contatto = new Contatto();

echo json_encode($contatto->aggiungiContatto($data->nome, $data->cognome, $data->sito_web));
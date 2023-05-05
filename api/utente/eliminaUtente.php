<?php
require '../../model/utente.php';
header("Content-type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"));

if (empty($data->id)) {
    http_response_code(400);
    echo json_encode(["message" => "Fill every field"]);
    die();
}
$utente = new Utente();
if ($utente->eliminaUtente($data->id)== 1) {
    http_response_code(201);
    echo json_encode(["message" => "Elimination completed"]);
    die();
} else {
    http_response_code(400);
    echo json_encode(["message" => "Elimination failed "]);
    die();
}
?>
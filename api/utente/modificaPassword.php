<?php
require '../../model/utente.php';
header("Content-type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"));

if (empty($data->id)|| empty($data->newPassword)) {
    http_response_code(400);
    echo json_encode(["message" => "Fill every field"]);
    die();
}
$utente = new Utente();
if ($utente->modificaPassword($data->id, $data->newPassword)== 1) {
    http_response_code(201);
    echo json_encode(["message" => "Change completed"]);
    die();
} else {
    http_response_code(400);
    echo json_encode(["message" => "Change failed "]);
    die();
}
?>
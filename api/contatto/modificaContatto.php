<?php
require '../../model/contatto.php';
header("Content-type: application/json; charset=UTF-8");

$data = json_decode(file_get_contents("php://input"));

if (empty($data->id)|| empty($data->nome) || empty($data->cognome) || empty($data->sito_web)) {
    http_response_code(400);
    echo json_encode(["message" => "Fill every field"]);
    die();
}
$contatto = new Contatto();
if ($contatto->modificaContatto($data->id,$data->nome,$data->cognome,$data->sito_web)== 1) {
    http_response_code(201);
    echo json_encode(["message" => "Modify completed"]);
    die();
} else {
    http_response_code(400);
    echo json_encode(["message" => "Modify failed "]);
    die();
}
?>
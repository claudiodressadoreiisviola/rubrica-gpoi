<?php

spl_autoload_register(function ($class) {
    require __DIR__ . "/../COMMON/$class.php";
});

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class Indirizzo
{
    private Connect $db;
    private PDO $conn;

    public function __construct()
    {
        $this->db = new Connect;
        $this->conn = $this->db->getConnection();
    }

    public function ottieniIndirizzo($id)
    {
        $sql = "SELECT i.id, c.nome, c.cognome, c.sito_web, i.comune, i.provincia, i.codice_postale, i.tipo_via, i.via, t.descrizione  
                FROM indirizzo i 
                INNER JOIN contatto c ON c.id = i.contatto 
                INNER JOIN tipo t ON t.id = i.tipo 
                WHERE i.id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ottieniTuttiIndirizzi($id)
    {
        $sql = "SELECT i.id, c.nome, c.cognome, c.sito_web, i.comune, i.provincia, i.codice_postale, i.tipo_via, i.via, t.descrizione  
                FROM indirizzo i 
                INNER JOIN contatto c ON c.id = i.contatto 
                INNER JOIN tipo t ON t.id = i.tipo";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    
}
?>
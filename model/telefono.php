<?php

spl_autoload_register(function ($class) {
    require __DIR__ . "/../COMMON/$class.php";
});

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class Telefono
{
    private Database $db;
    private PDO $conn;

    public function __construct()
    {
        $this->db = new Database;
        $this->conn = $this->db->getConnection();
    }

    public function ottieniTelefono($id)
    {
        $sql = "SELECT t.id, c.nome, c.cognome, c.sito_web, t.numero, t.cc, t2.descrizione
                FROM telefono t 
                INNER JOIN contatto c ON c.id = t.contatto 
                INNER JOIN tipo t2 ON t2.id = t.tipo 
                WHERE t.id = :id";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ottieniTuttiTelefoni($id)
    {
        $sql = "SELECT t.id, c.nome, c.cognome, c.sito_web, t.numero, t.cc, t2.descrizione
                FROM telefono t 
                INNER JOIN contatto c ON c.id = t.contatto 
                INNER JOIN tipo t2 ON t2.id = t.tipo";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    
}
?>
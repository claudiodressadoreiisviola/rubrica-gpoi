<?php

spl_autoload_register(function ($class) {
    require __DIR__ . "/../COMMON/$class.php";
});

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class Email
{
    private Database $database;
    private PDO $connection;

    public function __construct()
    {
        // Inizializzo il database
        $this->database = new Database;
        $this->connection = $this->database->getConnection();
    }

    public function ottieniEmail($id)
    {
        $sql = "SELECT e.id, c.nome, c.cognome, c.sito_web, e.indirizzo, t.descrizione  
                FROM email e 
                INNER JOIN contatto c ON c.id = e.contatto 
                INNER JOIN tipo t ON t.id = e.tipo
                WHERE e.id = :id";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ottieniTutteEmail($id)
    {
        $sql = "SELECT e.id, c.nome, c.cognome, c.sito_web, e.indirizzo, t.descrizione  
                FROM email e 
                INNER JOIN contatto c ON c.id = e.contatto 
                INNER JOIN tipo t ON t.id = e.tipo";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    
}
?>
<?php

spl_autoload_register(function ($class) {
    require __DIR__ . "/../COMMON/$class.php";
});

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class Indirizzo
{
    private Database $database;
    private PDO $connection;

    public function __construct()
    {
        // Inizializzo il database
        $this->database = new Database;
        $this->connection = $this->database->getConnection();
    }

    public function ottieniIndirizzo($id)
    {
        $sql = "SELECT i.id, c.nome, c.cognome, i.comune, i.provincia, i.codice_postale, i.tipo_via, i.via, t.descrizione  
                FROM indirizzo i 
                INNER JOIN contatto c ON c.id = i.contatto 
                INNER JOIN tipo t ON t.id = i.tipo 
                WHERE i.id = :id";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }  
}
?>
<?php

spl_autoload_register(function ($class) {
    require __DIR__ . "/../COMMON/$class.php";
});

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class Telefono
{
    private Database $database;
    private PDO $connection;

    public function __construct()
    {
        // Inizializzo il database
        $this->database = new Database;
        $this->connection = $this->database->getConnection();
    }

    public function ottieniTelefono($id)
    {
        $sql = "SELECT t.id, c.nome, c.cognome, t.numero, t.cc, t2.descrizione
                FROM telefono t 
                INNER JOIN contatto c ON c.id = t.contatto 
                INNER JOIN tipo t2 ON t2.id = t.tipo 
                WHERE t.id = :id";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }  
}
?>
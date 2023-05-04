<?php

spl_autoload_register(function ($class) {
    require __DIR__ . "/../COMMON/$class.php";
});

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class Rubrica
{
    private Database $database;
    private PDO $connection;

    public function __construct()
    {
        // Inizializzo il database
        $this->database = new Database;
        $this->connection = $this->database->getConnection();
    }

    public function ottieniRubirca($id)
    {
        $sql = "SELECT c.id AS 'ID Contatto',c.nome AS 'Cognome contatto', c.cognome AS 'Cognome contatto', c.sito_web AS 'Sito web', r.nota AS 'Nota' , r.soprannome AS 'Soprannome'
                FROM rubrica r 
                INNER JOIN utente u  ON u.id = r.utente 
                INNER JOIN contatto c ON c.id = r.contatto 
                WHERE u.id = :id ";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
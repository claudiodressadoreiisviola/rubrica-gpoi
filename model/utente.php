<?php

spl_autoload_register(function ($class) {
    require __DIR__ . "/../common/$class.php";
});

require __DIR__ . "/contatto.php";

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

Class Utente
{
    private Database $database;
    private PDO $connection;

    public function __construct()
    {
        // Inizializzo il database
        $this->database = new Database;
        $this->connection = $this->database->getConnection();
    }

    public function ottieniUtente($id)
    {
        $sql = "SELECT u.id, u.password, c.nome, c.cognome
                FROM utente u
                INNER JOIN contatto c ON c.id=u.contatto 
                WHERE u.id = :id";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function login($email, $password)
    {
        $sql = "SELECT u.id
                FROM utente u
                WHERE u.email = :email AND u.password = :password";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function registra($email, $password, $nome, $cognome, $sito_web)
    {
        $contatto = new Contatto();
        
        $contatto->aggiungiContatto($nome, $cognome, $sito_web);

        $sql = "INSERT INTO utente ( email, password )
                FROM utente u
                WHERE u.email = :email AND u.password = :password";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $password, PDO::PARAM_STR);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
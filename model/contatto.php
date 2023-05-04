<?php

spl_autoload_register(function ($class) {
    require __DIR__ . "/../COMMON/$class.php";
});

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class Contatto
{
    private Database $database;
    private PDO $connection;

    public function __construct()
    {
        // Inizializzo il database
        $this->database = new Database;
        $this->connection = $this->database->getConnection();
    }

    public function ottieniContatto($id)
    {
        $sql = "SELECT id, nome, cognome, sito_web 
                FROM contatto 
                WHERE id = :id";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function ottieniTuttiContatti($id)
    {
        $sql = "SELECT r.id, c.nome, c.cognome, c.sito_web
                FROM rubrica r
                INNER JOIN utente u ON u.id = r.utente 
                INNER JOIN contatto c ON c.id = r.contatto
                WHERE r.utente = :id";
                
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }   

    public function aggiungiContatto($nome, $cognome, $sito_web)
    {
        $sql = "SELECT c.id 
                FROM contatto c 
                WHERE c.nome = :nome AND cognome = :cognome AND sito_web = :sito_web";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':cognome', $cognome, PDO::PARAM_STR);
        $stmt->bindValue(':sito_web', $sito_web, PDO::PARAM_STR);

        $stmt->execute();

        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if($result == false)
        {
            $sql = "INSERT  INTO contatto (nome, cognome, sito_web)
                    VALUES (:nome, :cognome, :sito_web)";

            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindValue(':cognome', $cognome, PDO::PARAM_STR);
            $stmt->bindValue(':sito_web', $sito_web, PDO::PARAM_STR);

            $stmt->execute();

            $idcontatto = $stmt->lastInsertID();

            return array("message" => "Contatto creato con successo");
        }
       else 
        {
            http_response_code(400);
            return array("message" => "Contatto gia esistente");
        } 
    }
}
?>
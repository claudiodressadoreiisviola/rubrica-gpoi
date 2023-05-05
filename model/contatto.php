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
        $sql = "SELECT id, nome, cognome, sito_web 
                FROM contatto ";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    
    public function eliminaContatto($id){
            $contatto = $this->ottieniContatto($id);
    
            if ($contatto == null)
                return false;
    
            $sql=sprintf("UPDATE contatto SET attivo=0 WHERE id=:id");
            $stmt = $this->connection->prepare($sql);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            if ($stmt->execute())
        {
        return 1;
        }
        else return "problemi";
        }
    
    public function aggiungiContatto($nome,$cognome,$sito_web){
    {
        $sql = sprintf("INSERT INTO contatto (nome, cognome,sito_web)
       VALUES (:nome,:cognome,:sito_web)");

    $stmt = $this->connection->prepare($sql);
    $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindValue(':cognome', $cognome, PDO::PARAM_STR);
    $stmt->bindValue(':email', $sito_web, PDO::PARAM_STR);

if ($stmt->execute())
{
return $stmt->rowCount();
}
else return "problemi";
    }
    }

    public function modificaContatto($id,$nome,$cognome,$email,$sito_web){
        $sql = sprintf("UPDATE contatto 
        SET nome=:nome, cognome=:cognome, sito_web=:sito_web
        WHERE id=:id");
 
     $stmt = $this->connection->prepare($sql);
     $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
     $stmt->bindValue(':id', $id, PDO::PARAM_INT);
     $stmt->bindValue(':cognome', $cognome, PDO::PARAM_STR);
     $stmt->bindValue(':email', $sito_web, PDO::PARAM_STR);
 
 if ($stmt->execute())
 {
 return $stmt->rowCount();
 }
 else return "problemi";
     }
    }

?>
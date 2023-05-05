<?php

spl_autoload_register(function ($class) {
    require __DIR__ . "/../common/$class.php";
});

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

Class Utente
{
    // I dati inerenti alla sessione: l'id della sessione, l'utente e la scadenza
    public $SessionID = "";
    public $UserID = "";

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
        $sql = "SELECT u.id, u.password, c.nome, c.cognome, c.sito_web
                FROM utente u
                INNER JOIN contatto c ON c.id=u.contatto 
                WHERE u.id = :id";

        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function registrazione($email,$password){
        $sql = sprintf("INSERT INTO utente (email,password)
        VALUES (:email,:password)");
 
     $stmt = $this->connection->prepare($sql);
     $stmt->bindValue(':nome', $email, PDO::PARAM_STR);
     $stmt->bindValue(':cognome', $password, PDO::PARAM_STR);
 
 if ($stmt->execute())
 {
 return $stmt->rowCount();
 }
 else return "problemi";
    }
    public function eliminaUtente($id){
     
        $utente = $this->ottieniUtente($id);
    
        if ($utente == null)
            return false;

        $sql=sprintf("UPDATE utente SET attivo=0 WHERE id=:id");
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        if ($stmt->execute())
    {
    return 1;
    }
    else return "problemi";
    }

    public function modificaPassword($id,$newPassword){

        $sql=sprintf("UPDATE utente SET password=:newPassword WHERE id=:id");
        $stmt = $this->connection->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->bindValue(':newPassword', $newPassword, PDO::PARAM_STR);
        if ($stmt->execute())
    {
    return 1;
    }
    else return "problemi";
    }
}
?>
<?php

spl_autoload_register(function ($class) {
    require __DIR__ . "/../COMMON/$class.php";
});

set_exception_handler("errorHandler::handleException");
set_error_handler("errorHandler::handleError");

class Rubrica
{
    private Connect $db;
    private PDO $conn;

    public function __construct()
    {
        $this->db = new Connect;
        $this->conn = $this->db->getConnection();
    }

    public function ottieniRubirca($id)
    {
        $sql = "SELECT r.id, c.nome, c.cognome, c.sito_web, r.nota , r.soprannome 
                FROM rubrica r 
                INNER JOIN utente u  ON u.id = r.utente 
                INNER JOIN contatto c ON c.id = r.contatto 
                WHERE u.id = :id ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
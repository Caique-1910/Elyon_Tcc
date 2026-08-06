<?php

require_once __DIR__ . '/../config/database.php';

class Feedback
{
    private PDO $conn;
    private string $table = "feedback";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    // Listar feedbacks
    public function listar()
    {
        $sql = "SELECT * FROM {$this->table}";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Buscar feedback por ID
    public function buscarPorId($idfeedback)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE idfeedback = :idfeedback";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idfeedback', $idfeedback);

        $stmt->execute();

        return $stmt->fetch();
    }

    // Cadastrar feedback
    public function cadastrar($idusuario, $idperfume, $comentario)
    {
        $sql = "INSERT INTO {$this->table}
                (idusuario, idperfume, comentario)
                VALUES
                (:idusuario, :idperfume, :comentario)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':idusuario', $idusuario);
        $stmt->bindParam(':idperfume', $idperfume);
        $stmt->bindParam(':comentario', $comentario);

        return $stmt->execute();
    }

    // Atualizar feedback
    public function atualizar($idfeedback, $comentario)
    {
        $sql = "UPDATE {$this->table}
                SET comentario = :comentario
                WHERE idfeedback = :idfeedback";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':idfeedback', $idfeedback);
        $stmt->bindParam(':comentario', $comentario);

        return $stmt->execute();
    }

    // Excluir feedback
    public function excluir($idfeedback)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE idfeedback = :idfeedback";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idfeedback', $idfeedback);

        return $stmt->execute();
    }
}
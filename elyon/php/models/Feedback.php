
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

    // CADASTRAR FEEDBACK
    public function cadastrar($idusuario, $idproduto, $comentario, $estrela)
    {
        $sql = "INSERT INTO feedback
                (Idusuario, Idproduto, Comentario, Estrela)
                VALUES
                (:idusuario, :idproduto, :comentario, :estrela)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindValue(':idusuario', $idusuario, PDO::PARAM_INT);
        $stmt->bindValue(':idproduto', $idproduto, PDO::PARAM_INT);
        $stmt->bindValue(':comentario', $comentario, PDO::PARAM_STR);
        $stmt->bindValue(':estrela', $estrela, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // LISTAR FEEDBACKS POR PRODUTO
    public function listarPorProduto($idproduto)
    {
        $sql = "SELECT
                    F.Idfeedback,
                    F.Idusuario,
                    F.Idproduto,
                    F.Comentario,
                    F.Estrela,
                    U.Nome AS NomeUsuario
                FROM feedback F
                INNER JOIN usuario U
                    ON F.Idusuario = U.Idusuario
                WHERE F.Idproduto = :idproduto
                ORDER BY F.Idfeedback DESC";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(
            ':idproduto',
            $idproduto,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

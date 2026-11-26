
<?php

require_once __DIR__ . '/../config/database.php';

class Marca
{
    private PDO $conn;
    private string $table = "marca";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    public function listar()
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function buscarPorId($idmarca)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE Idmarca = :idmarca";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idmarca', $idmarca, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function cadastrar($nome)
    {
        $sql = "INSERT INTO {$this->table}
                (Nome)
                VALUES
                (:nome)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':nome', $nome);

        return $stmt->execute();
    }

    public function atualizar($idmarca, $nome)
    {
        $sql = "UPDATE {$this->table}
                SET Nome = :nome
                WHERE Idmarca = :idmarca";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idmarca', $idmarca, PDO::PARAM_INT);
        $stmt->bindParam(':nome', $nome);

        return $stmt->execute();
    }

    public function excluir($idmarca)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE Idmarca = :idmarca";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idmarca', $idmarca, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

<?php

require_once __DIR__ . '/../config/database.php';

class Perfume
{
    private PDO $conn;
    private string $table = "perfume";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    // Listar perfumes
    public function listar()
    {
        $sql = "SELECT * FROM {$this->table}";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Buscar perfume pelo ID
    public function buscarPorId($idperfume)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE idperfume = :idperfume";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idperfume', $idperfume);

        $stmt->execute();

        return $stmt->fetch();
    }

    // Cadastrar perfume
    public function cadastrar($nome, $preco, $marcaid, $descricao)
    {
        $sql = "INSERT INTO {$this->table}
                (nome, preco, marcaid, descricao)
                VALUES
                (:nome, :preco, :marcaid, :descricao)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':marcaid', $marcaid);
        $stmt->bindParam(':descricao', $descricao);

        return $stmt->execute();
    }

    // Atualizar perfume
    public function atualizar($idperfume, $nome, $preco, $marcaid, $descricao)
    {
        $sql = "UPDATE {$this->table}
                SET
                    nome = :nome,
                    preco = :preco,
                    marcaid = :marcaid,
                    descricao = :descricao
                WHERE idperfume = :idperfume";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':idperfume', $idperfume);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':preco', $preco);
        $stmt->bindParam(':marcaid', $marcaid);
        $stmt->bindParam(':descricao', $descricao);

        return $stmt->execute();
    }

    // Excluir perfume
    public function excluir($idperfume)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE idperfume = :idperfume";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idperfume', $idperfume);

        return $stmt->execute();
    }
}
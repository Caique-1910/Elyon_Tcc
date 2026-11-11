<?php

require_once __DIR__ . '/../config/database.php';

class TipoProduto
{
    private PDO $conn;
    private string $table = "tipoproduto";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    // Listar tipos de produto
    public function listar()
    {
        $sql = "SELECT * FROM {$this->table}";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Buscar tipo de produto pelo ID
    public function buscarPorId($idtipoproduto)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE Idtipoproduto = :idtipoproduto";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(
            ':idtipoproduto',
            $idtipoproduto,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return $stmt->fetch();
    }

    // Cadastrar tipo de produto
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

    // Atualizar tipo de produto
    public function atualizar($idtipoproduto, $nome)
    {
        $sql = "UPDATE {$this->table}
                SET Nome = :nome
                WHERE Idtipoproduto = :idtipoproduto";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(
            ':idtipoproduto',
            $idtipoproduto,
            PDO::PARAM_INT
        );

        $stmt->bindParam(':nome', $nome);

        return $stmt->execute();
    }

    // Excluir tipo de produto
    public function excluir($idtipoproduto)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE Idtipoproduto = :idtipoproduto";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(
            ':idtipoproduto',
            $idtipoproduto,
            PDO::PARAM_INT
        );

        return $stmt->execute();
    }
}
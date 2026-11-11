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

    // Listar todas as marcas
    public function listar()
    {
        $sql = "SELECT * FROM {$this->table}";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Buscar marca pelo ID
    public function buscarPorId($idmarca)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE Idmarca = :idmarca";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idmarca', $idmarca, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch();
    }

    // Cadastrar marca
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

    // Atualizar marca
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

    // Excluir marca
    public function excluir($idmarca)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE Idmarca = :idmarca";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idmarca', $idmarca, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
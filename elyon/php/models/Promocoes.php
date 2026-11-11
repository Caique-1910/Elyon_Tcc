<?php

require_once __DIR__ . '/../config/database.php';

class Promocoes
{
    private PDO $conn;
    private string $table = "promocoes";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    // Listar promoções
    public function listar()
    {
        $sql = "SELECT * FROM {$this->table}";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Buscar promoção pelo ID
    public function buscarPorId($idpromocao)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE Idpromocao = :idpromocao";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(
            ':idpromocao',
            $idpromocao,
            PDO::PARAM_INT
        );

        $stmt->execute();

        return $stmt->fetch();
    }

    // Cadastrar promoção
    public function cadastrar(
        $valoratual,
        $valordesconto,
        $datainicio,
        $datafim,
        $ativo = 1
    ) {
        $sql = "INSERT INTO {$this->table}
                (Valoratual, Valordesconto, Datainicio, Datafim, Ativo)
                VALUES
                (:valoratual, :valordesconto, :datainicio, :datafim, :ativo)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':valoratual', $valoratual);
        $stmt->bindParam(':valordesconto', $valordesconto);
        $stmt->bindParam(':datainicio', $datainicio);
        $stmt->bindParam(':datafim', $datafim);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Atualizar promoção
    public function atualizar(
        $idpromocao,
        $valoratual,
        $valordesconto,
        $datainicio,
        $datafim,
        $ativo
    ) {
        $sql = "UPDATE {$this->table}
                SET
                    Valoratual = :valoratual,
                    Valordesconto = :valordesconto,
                    Datainicio = :datainicio,
                    Datafim = :datafim,
                    Ativo = :ativo
                WHERE Idpromocao = :idpromocao";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(
            ':idpromocao',
            $idpromocao,
            PDO::PARAM_INT
        );

        $stmt->bindParam(':valoratual', $valoratual);
        $stmt->bindParam(':valordesconto', $valordesconto);
        $stmt->bindParam(':datainicio', $datainicio);
        $stmt->bindParam(':datafim', $datafim);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);

        return $stmt->execute();
    }

    // Excluir promoção
    public function excluir($idpromocao)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE Idpromocao = :idpromocao";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(
            ':idpromocao',
            $idpromocao,
            PDO::PARAM_INT
        );

        return $stmt->execute();
    }
}
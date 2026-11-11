<?php

require_once __DIR__ . '/../config/database.php';

class FormaPagamento
{
    private PDO $conn;
    private string $table = "formapagamento";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    // Listar formas de pagamento
    public function listar()
    {
        $sql = "SELECT * FROM {$this->table}";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Buscar forma de pagamento pelo ID
    public function buscarPorId($idfpag)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE Idfpag = :idfpag";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idfpag', $idfpag, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch();
    }

    // Cadastrar forma de pagamento
    public function cadastrar($formapag, $ativo = 1, $codigonf = null)
    {
        $sql = "INSERT INTO {$this->table}
                (Formapag, Ativo, Codigonf)
                VALUES
                (:formapag, :ativo, :codigonf)";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':formapag', $formapag);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->bindParam(':codigonf', $codigonf);

        return $stmt->execute();
    }

    // Atualizar forma de pagamento
    public function atualizar($idfpag, $formapag, $ativo, $codigonf)
    {
        $sql = "UPDATE {$this->table}
                SET
                    Formapag = :formapag,
                    Ativo = :ativo,
                    Codigonf = :codigonf
                WHERE Idfpag = :idfpag";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':idfpag', $idfpag, PDO::PARAM_INT);
        $stmt->bindParam(':formapag', $formapag);
        $stmt->bindParam(':ativo', $ativo, PDO::PARAM_INT);
        $stmt->bindParam(':codigonf', $codigonf);

        return $stmt->execute();
    }

    // Excluir forma de pagamento
    public function excluir($idfpag)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE Idfpag = :idfpag";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idfpag', $idfpag, PDO::PARAM_INT);

        return $stmt->execute();
    }
}
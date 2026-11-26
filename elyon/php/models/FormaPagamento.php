
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

    public function listar()
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    public function buscarPorId($idfpag)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE Idfpag = :idfpag";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idfpag', $idfpag, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

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

    public function excluir($idfpag)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE Idfpag = :idfpag";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idfpag', $idfpag, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

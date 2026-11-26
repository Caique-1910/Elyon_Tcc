
<?php

require_once __DIR__ . '/../config/database.php';

class Pagamento
{
    private PDO $conn;
    private string $table = "pagamento";

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

    public function buscarPorId($idpag)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE Idpag = :idpag";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idpag', $idpag, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function cadastrar($idpedido, $idfpag, $idusuario, $valor)
    {
        $sql = "INSERT INTO {$this->table}
                (Idpedido, Idfpag, Idusuario, Valor)
                VALUES
                (:idpedido, :idfpag, :idusuario, :valor)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idpedido', $idpedido, PDO::PARAM_INT);
        $stmt->bindParam(':idfpag', $idfpag, PDO::PARAM_INT);
        $stmt->bindParam(':idusuario', $idusuario, PDO::PARAM_INT);
        $stmt->bindParam(':valor', $valor);

        return $stmt->execute();
    }

    public function atualizar($idpag, $idfpag, $valor)
    {
        $sql = "UPDATE {$this->table}
                SET
                    Idfpag = :idfpag,
                    Valor = :valor
                WHERE Idpag = :idpag";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idpag', $idpag, PDO::PARAM_INT);
        $stmt->bindParam(':idfpag', $idfpag, PDO::PARAM_INT);
        $stmt->bindParam(':valor', $valor);

        return $stmt->execute();
    }

    public function excluir($idpag)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE Idpag = :idpag";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idpag', $idpag, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

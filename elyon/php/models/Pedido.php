
<?php

require_once __DIR__ . '/../config/database.php';

class Pedido
{
    private PDO $conn;
    private string $table = "pedido";

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

    public function buscarPorId($idpedido)
    {
        $sql = "SELECT * FROM {$this->table}
                WHERE Idpedido = :idpedido";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idpedido', $idpedido, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function cadastrar(
        $idusuario,
        $idproduto,
        $quantidade,
        $dataentrega,
        $valor
    ) {
        $sql = "INSERT INTO {$this->table}
                (Idusuario, Idproduto, Quantidade, Dataentrega, Valor)
                VALUES
                (:idusuario, :idproduto, :quantidade, :dataentrega, :valor)";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idusuario', $idusuario, PDO::PARAM_INT);
        $stmt->bindParam(':idproduto', $idproduto, PDO::PARAM_INT);
        $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindParam(':dataentrega', $dataentrega);
        $stmt->bindParam(':valor', $valor);

        return $stmt->execute();
    }

    public function atualizar(
        $idpedido,
        $quantidade,
        $dataentrega,
        $valor
    ) {
        $sql = "UPDATE {$this->table}
                SET
                    Quantidade = :quantidade,
                    Dataentrega = :dataentrega,
                    Valor = :valor
                WHERE Idpedido = :idpedido";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idpedido', $idpedido, PDO::PARAM_INT);
        $stmt->bindParam(':quantidade', $quantidade, PDO::PARAM_INT);
        $stmt->bindParam(':dataentrega', $dataentrega);
        $stmt->bindParam(':valor', $valor);

        return $stmt->execute();
    }

    public function excluir($idpedido)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE Idpedido = :idpedido";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idpedido', $idpedido, PDO::PARAM_INT);

        return $stmt->execute();
    }
}

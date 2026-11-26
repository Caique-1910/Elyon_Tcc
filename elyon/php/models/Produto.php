
<?php

require_once __DIR__ . '/../config/database.php';

class Produto
{
    private PDO $conn;
    private string $table = "produto";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    // LISTAGEM GERAL - HOME
    public function listar()
    {
        $sql = "SELECT
                    P.Idproduto,
                    P.Nome,
                    P.Preco,
                    P.Descricao,
                    P.Imagem,
                    M.Nome AS Marca,
                    T.Nome AS Tipo
                FROM produto P
                INNER JOIN marca M
                    ON P.Marcaid = M.Idmarca
                INNER JOIN tipoproduto T
                    ON P.Tipoprodutoid = T.Idtipoproduto";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // MASCULINO
    public function listarMasculino()
    {
        return $this->listarPorTipo('Masculino');
    }

    // FEMININO
    public function listarFeminino()
    {
        return $this->listarPorTipo('Feminino');
    }

    // CABELOS
    public function listarCabelos()
    {
        return $this->listarPorTipo('Cabelos');
    }

    // SKINCARE
    public function listarSkincare()
    {
        return $this->listarPorTipo('Skincare');
    }

    // MAQUIAGEM
    public function listarMaquiagem()
    {
        return $this->listarPorTipo('Maquiagem');
    }

    // BUSCA POR TIPO
    private function listarPorTipo($tipo)
    {
        $sql = "SELECT
                    P.Idproduto,
                    P.Nome,
                    P.Preco,
                    P.Descricao,
                    P.Imagem,
                    M.Nome AS Marca,
                    T.Nome AS Tipo
                FROM produto P
                INNER JOIN marca M
                    ON P.Marcaid = M.Idmarca
                INNER JOIN tipoproduto T
                    ON P.Tipoprodutoid = T.Idtipoproduto
                WHERE T.Nome = :tipo";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // DETALHES DO PRODUTO
    public function buscarPorId($idproduto)
    {
        $sql = "SELECT
                    P.Idproduto,
                    P.Nome,
                    P.Preco,
                    P.Descricao,
                    P.Imagem,
                    M.Nome AS Marca,
                    T.Nome AS Tipo
                FROM produto P
                INNER JOIN marca M
                    ON P.Marcaid = M.Idmarca
                INNER JOIN tipoproduto T
                    ON P.Tipoprodutoid = T.Idtipoproduto
                WHERE P.Idproduto = :idproduto";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idproduto', $idproduto, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->fetch();
    }
}

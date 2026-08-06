<?php

class Database
{
    private $host = "localhost";
    private $database = "elyon";
    private $usuario = "root";
    private $senha = "";

    private $conexao;

    public function conectar()
    {
        if ($this->conexao === null) {

            try {

                $this->conexao = new PDO(
                    "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4",
                    $this->usuario,
                    $this->senha
                );

                $this->conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $this->conexao->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            } catch (PDOException $e) {

                die("Erro ao conectar com o banco: " . $e->getMessage());

            }

        }

        return $this->conexao;
    }
}
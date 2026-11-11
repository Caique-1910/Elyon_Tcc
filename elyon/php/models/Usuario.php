<?php

require_once __DIR__ . '/../config/database.php';

class Usuario
{
    private PDO $conn;

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    // BUSCAR USUÁRIO PELO E-MAIL
    public function buscarPorEmail($email)
    {
        $sql = "SELECT *
                FROM usuario
                WHERE Email = :email";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':email', $email);

        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // CADASTRAR USUÁRIO
    public function cadastrar($nome, $email, $senha)
    {
        $sql = "INSERT INTO usuario
                (Nome, Email, Senha)
                VALUES
                (:nome, :email, :senha)";

        $stmt = $this->conn->prepare($sql);

        $senhaHash = password_hash(
            $senha,
            PASSWORD_DEFAULT
        );

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senhaHash);

        return $stmt->execute();
    }

    // LOGIN
    public function login($email, $senha)
    {
        $usuario = $this->buscarPorEmail($email);

        if (!$usuario) {
            return false;
        }

        if (!password_verify($senha, $usuario['Senha'])) {
            return false;
        }

        return $usuario;
    }
}
<?php

require_once __DIR__ . '/../config/database.php';

class Usuario
{
    private PDO $conn;
    private string $table = "usuario";

    public function __construct()
    {
        $database = new Database();
        $this->conn = $database->conectar();
    }

    // Listar usuários
    public function listar()
    {
        $sql = "SELECT * FROM {$this->table}";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll();
    }

    // Buscar por ID
    public function buscarPorId($idusuario)
    {
        $sql = "SELECT * FROM {$this->table} WHERE idusuario = :idusuario";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idusuario', $idusuario, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch();
    }

    // Buscar por e-mail
    public function buscarPorEmail($email)
    {
        $sql = "SELECT * FROM {$this->table} WHERE email = :email";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch();
    }

    // Cadastrar usuário
    public function cadastrar($nome, $email, $senha)
    {
        $sql = "INSERT INTO {$this->table}
                (nome, email, senha)
                VALUES
                (:nome, :email, :senha)";

        $stmt = $this->conn->prepare($sql);

        $senha = password_hash($senha, PASSWORD_DEFAULT);

        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);

        return $stmt->execute();
    }

    // Atualizar usuário
    public function atualizar($idusuario, $nome, $email)
    {
        $sql = "UPDATE {$this->table}
                SET
                    nome = :nome,
                    email = :email
                WHERE idusuario = :idusuario";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':idusuario', $idusuario);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);

        return $stmt->execute();
    }

    // Excluir usuário
    public function excluir($idusuario)
    {
        $sql = "DELETE FROM {$this->table}
                WHERE idusuario = :idusuario";

        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':idusuario', $idusuario);

        return $stmt->execute();
    }

    // Login
    public function login($email, $senha)
    {
        $usuario = $this->buscarPorEmail($email);

        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
        }

        return false;
    }
}
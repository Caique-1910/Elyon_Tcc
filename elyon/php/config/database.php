
<?php

class Database
{
    private string $host = 'localhost';
    private string $database = 'u413309708_elyon';
    private string $usuario = 'u413309708_elyon';
    private string $senha = 'Elyon2026';

    private ?PDO $conexao = null;

    public function conectar(): PDO
    {
        if ($this->conexao === null) {

            try {

                $this->conexao = new PDO(
                    "mysql:host={$this->host};dbname={$this->database};charset=utf8mb4",
                    $this->usuario,
                    $this->senha,
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                        PDO::ATTR_EMULATE_PREPARES => false
                    ]
                );

            } catch (PDOException $e) {

                error_log(
                    'Erro de conexão com o banco: ' . $e->getMessage()
                );

                throw new RuntimeException(
                    'Não foi possível conectar ao banco de dados.',
                    0,
                    $e
                );
            }
        }

        return $this->conexao;
    }
}

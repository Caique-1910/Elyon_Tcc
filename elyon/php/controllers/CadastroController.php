
<?php

require_once __DIR__ . '/../models/Usuario.php';

class CadastroController
{
    // INICIA A SESSÃO QUANDO NECESSÁRIO
    private function iniciarSessao(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    // GERA O TOKEN CSRF
    private function gerarTokenCsrf(): void
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
    }

    // VALIDA O TOKEN CSRF
    private function validarTokenCsrf(): bool
    {
        $tokenRecebido = $_POST['csrf_token'] ?? '';
        $tokenSessao = $_SESSION['csrf_token'] ?? '';

        return
            is_string($tokenRecebido) &&
            is_string($tokenSessao) &&
            $tokenSessao !== '' &&
            hash_equals($tokenSessao, $tokenRecebido);
    }

    // ABRE A PÁGINA DE CADASTRO
    public function index()
    {
        $this->iniciarSessao();
        $this->gerarTokenCsrf();

        require __DIR__ . '/../views/cadastro/index.php';
    }

    // PROCESSA O CADASTRO
    public function cadastrar()
    {
        $this->iniciarSessao();

        // VERIFICA SE O FORMULÁRIO FOI ENVIADO POR POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/cadastro');
            exit;
        }

        // VALIDA O TOKEN CSRF
        if (!$this->validarTokenCsrf()) {
            http_response_code(403);
            exit('Requisição inválida ou expirada.');
        }

        // RECEBE OS DADOS DO FORMULÁRIO
        $nomeRecebido = $_POST['nome'] ?? '';
        $emailRecebido = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';
        $confirmarSenha = $_POST['confirmar_senha'] ?? '';

        // VERIFICA SE OS DADOS SÃO STRINGS
        if (
            !is_string($nomeRecebido) ||
            !is_string($emailRecebido) ||
            !is_string($senha) ||
            !is_string($confirmarSenha)
        ) {
            echo 'Dados inválidos. Verifique os campos e tente novamente.';
            return;
        }

        // ORGANIZA OS DADOS RECEBIDOS
        $nome = trim($nomeRecebido);
        $email = trim($emailRecebido);

        // VERIFICA CAMPOS OBRIGATÓRIOS
        if (
            $nome === '' ||
            $email === '' ||
            $senha === '' ||
            $confirmarSenha === ''
        ) {
            echo 'Preencha todos os campos.';
            return;
        }

        // VERIFICA O TAMANHO DOS CAMPOS
        if (strlen($nome) > 70) {
            echo 'O nome deve ter no máximo 70 caracteres.';
            return;
        }

        if (strlen($email) > 100) {
            echo 'O e-mail deve ter no máximo 100 caracteres.';
            return;
        }

        // VERIFICA SE O E-MAIL É VÁLIDO
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo 'Digite um e-mail válido.';
            return;
        }

        // VERIFICA SE AS SENHAS SÃO IGUAIS
        if ($senha !== $confirmarSenha) {
            echo 'As senhas não coincidem.';
            return;
        }

        try {
            // CRIA O MODEL
            $model = new Usuario();

            // VERIFICA SE O E-MAIL JÁ ESTÁ CADASTRADO
            if ($model->buscarPorEmail($email)) {
                echo 'Este e-mail já está cadastrado.';
                return;
            }

            // CADASTRA O USUÁRIO
            $resultado = $model->cadastrar(
                $nome,
                $email,
                $senha
            );

            // VERIFICA SE O CADASTRO FOI REALIZADO
            if ($resultado) {
                $_SESSION['mensagem_login'] =
                    'Cadastro realizado com sucesso! Faça login para continuar.';

                header('Location: ' . BASE_URL . '/login');
                exit;
            }

            echo 'Não foi possível realizar o cadastro. Tente novamente.';

        } catch (PDOException $e) {
            error_log('Erro no banco ao cadastrar usuário: ' . $e->getMessage());

            // TRATA POSSÍVEL DUPLICIDADE DE E-MAIL
            if ($e->getCode() === '23000') {
                echo 'Este e-mail já está cadastrado.';
                return;
            }

            echo 'Ocorreu um erro ao realizar o cadastro. Tente novamente.';

        } catch (Throwable $e) {
            error_log('Erro ao cadastrar usuário: ' . $e->getMessage());

            echo 'Ocorreu um erro ao realizar o cadastro. Tente novamente.';
        }
    }
}

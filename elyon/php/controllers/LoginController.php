
<?php

require_once __DIR__ . '/../models/Usuario.php';

class LoginController
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

    // PÁGINA DE LOGIN
    public function index()
    {
        $this->iniciarSessao();
        $this->gerarTokenCsrf();

        require __DIR__ . '/../views/login/index.php';
    }

    // PROCESSA O LOGIN
    public function entrar()
    {
        $this->iniciarSessao();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // VALIDA O TOKEN CSRF
        if (!$this->validarTokenCsrf()) {
            http_response_code(403);
            exit('Requisição inválida. Atualize a página e tente novamente.');
        }

        $emailRecebido = $_POST['email'] ?? '';
        $senha = $_POST['senha'] ?? '';

        $email = is_string($emailRecebido)
            ? trim($emailRecebido)
            : '';

        if (
            $email === '' ||
            !is_string($senha) ||
            $senha === ''
        ) {
            $_SESSION['mensagem_erro_login'] =
                'Preencha o e-mail e a senha.';

            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // BUSCA E AUTENTICA O USUÁRIO
        try {
            $model = new Usuario();
            $usuario = $model->login($email, $senha);
        } catch (Throwable $e) {
            error_log('Erro ao realizar login: ' . $e->getMessage());

            $_SESSION['mensagem_erro_login'] =
                'Não foi possível realizar o login. Tente novamente.';

            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // LOGIN INVÁLIDO
        if (!$usuario) {
            $_SESSION['mensagem_erro_login'] =
                'E-mail ou senha incorretos.';

            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // REGENERA O ID DA SESSÃO
        session_regenerate_id(true);

        // RENOVA O TOKEN CSRF
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));

        // SALVA OS DADOS NA SESSÃO
        $_SESSION['usuario_id'] = $usuario['Idusuario'];
        $_SESSION['usuario_nome'] = $usuario['Nome'];
        $_SESSION['usuario_email'] = $usuario['Email'];

        // RECUPERA O DESTINO ANTERIOR
        $destino = $_SESSION['redirecionar_apos_login'] ?? null;

        unset($_SESSION['redirecionar_apos_login']);

        // REDIRECIONA PARA O DESTINO OU HOME
        if (
            is_string($destino) &&
            strpos($destino, BASE_URL . '/') === 0
        ) {
            header('Location: ' . $destino);
            exit;
        }

        header('Location: ' . BASE_URL . '/');
        exit;
    }

    // LOGOUT
    public function logout()
    {
        $this->iniciarSessao();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        // VALIDA O TOKEN CSRF
        if (!$this->validarTokenCsrf()) {
            http_response_code(403);
            exit('Requisição inválida.');
        }

        // LIMPA OS DADOS DA SESSÃO
        $_SESSION = [];

        // REMOVE O COOKIE DA SESSÃO
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();

            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }

        session_destroy();

        header('Location: ' . BASE_URL . '/');
        exit;
    }
}

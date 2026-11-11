<?php

require_once __DIR__ . '/../models/Usuario.php';

class LoginController
{
    // Abre a página de login
    public function index()
    {
        require_once __DIR__ . '/../views/login/index.php';
    }

    // Processa o login
    public function entrar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /elyon/index.php?url=login');
            exit;
        }

        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';

        // Verifica os campos
        if ($email === '' || $senha === '') {
            echo "Preencha o e-mail e a senha.";
            return;
        }

        // Busca o usuário
        $model = new Usuario();

        $usuario = $model->login($email, $senha);

        // Login inválido
        if (!$usuario) {
            echo "E-mail ou senha incorretos.";
            return;
        }

        // Inicia a sessão
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Salva os dados na sessão
        $_SESSION['usuario_id'] = $usuario['Idusuario'];
        $_SESSION['usuario_nome'] = $usuario['Nome'];
        $_SESSION['usuario_email'] = $usuario['Email'];

        // Redireciona para a Home
        header('Location: /elyon/');
        exit;
    }

    // Logout
    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $_SESSION = [];

        session_destroy();

        header('Location: /elyon/');
        exit;
    }
}
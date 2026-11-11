<?php

require_once __DIR__ . '/../models/Usuario.php';

class CadastroController
{
    // Abre a página de cadastro
    public function index()
    {
        require_once __DIR__ . '/../views/cadastro/index.php';
    }

    // Processa o cadastro
    public function cadastrar()
    {
        // Verifica se o formulário foi enviado por POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /elyon/index.php?url=cadastro');
            exit;
        }

        // Recebe os dados do formulário
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';
        $confirmarSenha = $_POST['confirmar_senha'] ?? '';

        // Verifica campos obrigatórios
        if ($nome === '' || $email === '' || $senha === '' || $confirmarSenha === '') {
            echo "Preencha todos os campos.";
            return;
        }

        // Verifica se o e-mail é válido
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "Digite um e-mail válido.";
            return;
        }

        // Verifica se as senhas são iguais
        if ($senha !== $confirmarSenha) {
            echo "As senhas não coincidem.";
            return;
        }

        // Cria o model
        $model = new Usuario();

        // Verifica se o e-mail já está cadastrado
        if ($model->buscarPorEmail($email)) {
            echo "Este e-mail já está cadastrado.";
            return;
        }

        // Cadastra o usuário
        $resultado = $model->cadastrar(
            $nome,
            $email,
            $senha
        );

        // Se cadastrou corretamente, vai para o login
        if ($resultado) {
            header('Location: /elyon/index.php?url=login');
            exit;
        }

        // Caso aconteça algum erro
        echo "Erro ao realizar o cadastro.";
    }
}
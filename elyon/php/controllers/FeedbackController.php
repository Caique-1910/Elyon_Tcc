<?php

require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . '/../models/Feedback.php';

class FeedbackController
{
    // Abre a página de feedback
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Só permite acesso para usuários logados
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /elyon/login');
            exit;
        }

        // Busca os produtos
        $model = new Produto();

        $produtos = $model->listar();

        require_once __DIR__ . '/../views/feedback/index.php';
    }


    // Salva o feedback
    public function salvar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verifica se está logado
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: /elyon/login');
            exit;
        }

        $idusuario = $_SESSION['usuario_id'];

        $idproduto = $_POST['idproduto'] ?? '';
        $estrela = $_POST['estrela'] ?? '';
        $comentario = trim($_POST['comentario'] ?? '');


        // Verifica os campos
        if ($idproduto === '' || $estrela === '' || $comentario === '') {

            $erro = "Preencha todos os campos.";

            $model = new Produto();
            $produtos = $model->listar();

            require_once __DIR__ . '/../views/feedback/index.php';
            return;
        }


        // Converte para número
        $idproduto = (int) $idproduto;
        $estrela = (int) $estrela;


        // Verifica estrelas
        if ($estrela < 1 || $estrela > 5) {

            $erro = "A avaliação deve ser entre 1 e 5 estrelas.";

            $model = new Produto();
            $produtos = $model->listar();

            require_once __DIR__ . '/../views/feedback/index.php';
            return;
        }


        // Cria o Model
        $model = new Feedback();


        // Cadastra no banco
        $resultado = $model->cadastrar(
            $idusuario,
            $idproduto,
            $comentario,
            $estrela
        );


        // Se cadastrou
        if ($resultado) {

            header(
                'Location: /elyon/compra?id='
                . $idproduto
                . '&feedback=sucesso'
            );

            exit;
        }


        // Se deu erro
        $erro = "Erro ao cadastrar o feedback.";

        $modelProduto = new Produto();
        $produtos = $modelProduto->listar();

        require_once __DIR__ . '/../views/feedback/index.php';
    }
}

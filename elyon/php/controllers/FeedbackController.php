
<?php

require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . '/../models/Feedback.php';

class FeedbackController
{
    // ABRE A PÁGINA DE FEEDBACK
    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // SÓ PERMITE ACESSO PARA USUÁRIOS LOGADOS
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // BUSCA OS PRODUTOS
        $model = new Produto();

        $produtos = $model->listar();

        require_once __DIR__ . '/../views/feedback/index.php';
    }

    // SALVA O FEEDBACK
    public function salvar()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // VERIFICA SE ESTÁ LOGADO
        if (!isset($_SESSION['usuario_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $idusuario = $_SESSION['usuario_id'];

        $idproduto = $_POST['idproduto'] ?? '';
        $estrela = $_POST['estrela'] ?? '';
        $comentario = trim($_POST['comentario'] ?? '');

        // VERIFICA OS CAMPOS
        if ($idproduto === '' || $estrela === '' || $comentario === '') {

            $erro = "Preencha todos os campos.";

            $model = new Produto();
            $produtos = $model->listar();

            require_once __DIR__ . '/../views/feedback/index.php';
            return;
        }

        // CONVERTE PARA NÚMERO
        $idproduto = (int) $idproduto;
        $estrela = (int) $estrela;

        // VERIFICA ESTRELAS
        if ($estrela < 1 || $estrela > 5) {

            $erro = "A avaliação deve ser entre 1 e 5 estrelas.";

            $model = new Produto();
            $produtos = $model->listar();

            require_once __DIR__ . '/../views/feedback/index.php';
            return;
        }

        // CRIA O MODEL
        $model = new Feedback();

        // CADASTRA NO BANCO
        $resultado = $model->cadastrar(
            $idusuario,
            $idproduto,
            $comentario,
            $estrela
        );

        // SE CADASTROU
        if ($resultado) {

            header(
                'Location: ' . BASE_URL . '/compra?id='
                . $idproduto
                . '&feedback=sucesso'
            );

            exit;
        }

        // SE DEU ERRO
        $erro = "Erro ao cadastrar o feedback.";

        $modelProduto = new Produto();
        $produtos = $modelProduto->listar();

        require_once __DIR__ . '/../views/feedback/index.php';
    }
}


<?php

require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . '/../models/Feedback.php';

class CompraController
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

    // INTERROMPE REQUISIÇÕES COM TOKEN INVÁLIDO
    private function exigirTokenCsrf(): void
    {
        if (!$this->validarTokenCsrf()) {
            http_response_code(403);
            exit('Requisição inválida ou expirada.');
        }
    }

    // GERA UM TOKEN DE CONFIRMAÇÃO DO PEDIDO
    private function gerarTokenConfirmacao(): void
    {
        $_SESSION['token_confirmacao'] = bin2hex(random_bytes(32));
    }

    // DETALHES DO PRODUTO
    public function index()
    {
        $this->iniciarSessao();
        $this->gerarTokenCsrf();

        $idproduto = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

        if (!$idproduto || $idproduto < 1) {
            echo 'Produto não encontrado.';
            return;
        }

        try {
            $produtoModel = new Produto();
            $produto = $produtoModel->buscarPorId($idproduto);

            if (!$produto) {
                echo 'Produto não encontrado.';
                return;
            }

            $feedbackModel = new Feedback();
            $feedbacks = $feedbackModel->listarPorProduto($idproduto);

            require __DIR__ . '/../views/compra/index.php';

        } catch (Throwable $e) {
            error_log('Erro ao carregar produto: ' . $e->getMessage());
            echo 'Não foi possível carregar este produto.';
        }
    }

    // ADICIONAR AO CARRINHO
    public function adicionarAoCarrinho()
    {
        $this->iniciarSessao();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/');
            exit;
        }

        $this->exigirTokenCsrf();

        $idproduto = filter_input(INPUT_POST, 'idproduto', FILTER_VALIDATE_INT);
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);
        $acao = $_POST['acao'] ?? 'comprar';

        if (!in_array($acao, ['comprar', 'carrinho'], true)) {
            $acao = 'comprar';
        }

        if (
            !$idproduto || $idproduto < 1 ||
            !$quantidade || $quantidade < 1
        ) {
            $_SESSION['mensagem_carrinho'] =
                'Produto ou quantidade inválidos.';

            header('Location: ' . BASE_URL . '/carrinho');
            exit;
        }

        try {
            $produtoModel = new Produto();
            $produto = $produtoModel->buscarPorId($idproduto);

            if (!$produto) {
                $_SESSION['mensagem_carrinho'] =
                    'Produto não encontrado.';

                header('Location: ' . BASE_URL . '/carrinho');
                exit;
            }

            if (
                !isset($_SESSION['carrinho']) ||
                !is_array($_SESSION['carrinho'])
            ) {
                $_SESSION['carrinho'] = [];
            }

            // VERIFICA SE O PRODUTO JÁ EXISTE NO CARRINHO
            if (
                isset($_SESSION['carrinho'][$idproduto]) &&
                is_array($_SESSION['carrinho'][$idproduto])
            ) {
                $quantidadeAtual = filter_var(
                    $_SESSION['carrinho'][$idproduto]['quantidade'] ?? null,
                    FILTER_VALIDATE_INT
                );

                if (!$quantidadeAtual || $quantidadeAtual < 1) {
                    $quantidadeAtual = 0;
                }

                $_SESSION['carrinho'][$idproduto] = [
                    'id' => (int) $produto['Idproduto'],
                    'nome' => $produto['Nome'],
                    'preco' => (float) $produto['Preco'],
                    'imagem' => $produto['Imagem'],
                    'quantidade' => $quantidadeAtual + $quantidade
                ];

            } else {
                $_SESSION['carrinho'][$idproduto] = [
                    'id' => (int) $produto['Idproduto'],
                    'nome' => $produto['Nome'],
                    'preco' => (float) $produto['Preco'],
                    'imagem' => $produto['Imagem'],
                    'quantidade' => $quantidade
                ];
            }

            // EXIGE LOGIN PARA CONTINUAR A COMPRA
            if (empty($_SESSION['usuario_id'])) {
                $_SESSION['mensagem_login'] =
                    'Faça login para continuar sua compra.';

                $_SESSION['redirecionar_apos_login'] =
                    $acao === 'comprar'
                        ? BASE_URL . '/finalizacao'
                        : BASE_URL . '/carrinho';

                header('Location: ' . BASE_URL . '/login');
                exit;
            }

            // DEFINE O DESTINO DE ACORDO COM O BOTÃO CLICADO
            if ($acao === 'carrinho') {
                header('Location: ' . BASE_URL . '/carrinho');
            } else {
                header('Location: ' . BASE_URL . '/finalizacao');
            }

            exit;

        } catch (Throwable $e) {
            error_log('Erro ao adicionar produto ao carrinho: ' . $e->getMessage());

            $_SESSION['mensagem_carrinho'] =
                'Não foi possível adicionar o produto ao carrinho.';

            header('Location: ' . BASE_URL . '/carrinho');
            exit;
        }
    }

    // CARRINHO
    public function carrinho()
    {
        $this->iniciarSessao();
        $this->gerarTokenCsrf();

        // APLICAÇÃO DE CUPOM
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->exigirTokenCsrf();

            if (!isset($_POST['cupom'])) {
                header('Location: ' . BASE_URL . '/carrinho');
                exit;
            }

            $codigoRecebido = $_POST['cupom'];

            $codigo = is_string($codigoRecebido)
                ? strtoupper(trim($codigoRecebido))
                : '';

            if ($codigo === '') {
                unset($_SESSION['cupom']);

                $_SESSION['mensagem_cupom'] =
                    'Digite um código de cupom.';

            } else {
                try {
                    $db = new Database();
                    $conexao = $db->conectar();

                    $promocao = $this->buscarCupom($conexao, $codigo);

                    if (!$this->cupomValido($promocao)) {
                        unset($_SESSION['cupom']);

                        $_SESSION['mensagem_cupom'] =
                            'Cupom inválido, expirado ou indisponível.';

                    } else {
                        $_SESSION['cupom'] = [
                            'Codigo' => $promocao['Codigo'],
                            'Valordesconto' => (float) $promocao['Valordesconto']
                        ];

                        $_SESSION['mensagem_cupom'] =
                            'Cupom aplicado com sucesso!';
                    }

                } catch (Throwable $e) {
                    error_log('Erro ao validar cupom: ' . $e->getMessage());

                    $_SESSION['mensagem_cupom'] =
                        'Não foi possível validar o cupom.';
                }
            }

            header('Location: ' . BASE_URL . '/carrinho');
            exit;
        }

        $carrinho = $_SESSION['carrinho'] ?? [];

        if (!is_array($carrinho)) {
            $carrinho = [];
            $_SESSION['carrinho'] = [];
        }

        $cupomAplicado = $_SESSION['cupom'] ?? null;

        $mensagemCupom = $_SESSION['mensagem_cupom'] ?? '';
        unset($_SESSION['mensagem_cupom']);

        $mensagemCarrinho = $_SESSION['mensagem_carrinho'] ?? '';
        unset($_SESSION['mensagem_carrinho']);

        require __DIR__ . '/../views/carrinho/index.php';
    }

    // ATUALIZAR QUANTIDADE DO CARRINHO
    public function atualizarCarrinho()
    {
        $this->iniciarSessao();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/carrinho');
            exit;
        }

        $this->exigirTokenCsrf();

        $idproduto = filter_input(INPUT_POST, 'idproduto', FILTER_VALIDATE_INT);
        $quantidade = filter_input(INPUT_POST, 'quantidade', FILTER_VALIDATE_INT);

        if (
            !$idproduto || $idproduto < 1 ||
            !isset($_SESSION['carrinho']) ||
            !is_array($_SESSION['carrinho']) ||
            !isset($_SESSION['carrinho'][$idproduto])
        ) {
            $_SESSION['mensagem_carrinho'] =
                'Produto não encontrado no carrinho.';

            header('Location: ' . BASE_URL . '/carrinho');
            exit;
        }

        if (!$quantidade || $quantidade < 1) {
            $_SESSION['mensagem_carrinho'] =
                'Informe uma quantidade válida.';

            header('Location: ' . BASE_URL . '/carrinho');
            exit;
        }

        $_SESSION['carrinho'][$idproduto]['quantidade'] = $quantidade;

        $_SESSION['mensagem_carrinho'] =
            'Quantidade atualizada com sucesso!';

        header('Location: ' . BASE_URL . '/carrinho');
        exit;
    }

    // REMOVER PRODUTO DO CARRINHO
    public function removerDoCarrinho()
    {
        $this->iniciarSessao();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/carrinho');
            exit;
        }

        $this->exigirTokenCsrf();

        $idproduto = filter_input(INPUT_POST, 'idproduto', FILTER_VALIDATE_INT);

        if (
            !$idproduto || $idproduto < 1 ||
            !isset($_SESSION['carrinho']) ||
            !is_array($_SESSION['carrinho']) ||
            !isset($_SESSION['carrinho'][$idproduto])
        ) {
            $_SESSION['mensagem_carrinho'] =
                'Produto não encontrado no carrinho.';

            header('Location: ' . BASE_URL . '/carrinho');
            exit;
        }

        unset($_SESSION['carrinho'][$idproduto]);

        $_SESSION['mensagem_carrinho'] =
            'Produto removido do carrinho!';

        if (empty($_SESSION['carrinho'])) {
            unset($_SESSION['cupom']);
        }

        header('Location: ' . BASE_URL . '/carrinho');
        exit;
    }

    // PÁGINA DE FINALIZAÇÃO
    public function finalizacao()
    {
        $this->iniciarSessao();

        if (empty($_SESSION['usuario_id'])) {
            $_SESSION['mensagem_login'] =
                'Faça login para continuar sua compra.';

            $_SESSION['redirecionar_apos_login'] =
                BASE_URL . '/finalizacao';

            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        $compraConcluida =
            isset($_GET['sucesso']) &&
            $_GET['sucesso'] === '1' &&
            isset($_SESSION['pedido_total']) &&
            isset($_SESSION['pedido_subtotal']) &&
            isset($_SESSION['pedido_desconto']) &&
            isset($_SESSION['pedido_frete']);

        if ($compraConcluida) {
            $carrinho = [];
            $cupomAplicado = null;

            require __DIR__ . '/../views/finalizacao/index.php';

            unset(
                $_SESSION['pedido_total'],
                $_SESSION['pedido_subtotal'],
                $_SESSION['pedido_desconto'],
                $_SESSION['pedido_frete']
            );

            return;
        }

        if (isset($_GET['sucesso'])) {
            header('Location: ' . BASE_URL . '/carrinho');
            exit;
        }

        $carrinho = $_SESSION['carrinho'] ?? [];

        if (!is_array($carrinho) || empty($carrinho)) {
            header('Location: ' . BASE_URL . '/carrinho');
            exit;
        }

        $cupomAplicado = $_SESSION['cupom'] ?? null;

        if (empty($_SESSION['token_confirmacao'])) {
            $this->gerarTokenConfirmacao();
        }

        $mensagemFinalizacao = $_SESSION['mensagem_finalizacao'] ?? '';
        unset($_SESSION['mensagem_finalizacao']);

        require __DIR__ . '/../views/finalizacao/index.php';
    }

    // CONFIRMAR PEDIDO
    public function confirmarPedido()
    {
        $this->iniciarSessao();

        if (empty($_SESSION['usuario_id'])) {
            $_SESSION['mensagem_login'] =
                'Faça login para continuar sua compra.';

            $_SESSION['redirecionar_apos_login'] =
                BASE_URL . '/finalizacao';

            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASE_URL . '/finalizacao');
            exit;
        }

        // VALIDA O TOKEN EXCLUSIVO DE CONFIRMAÇÃO
        $tokenRecebido = $_POST['token_confirmacao'] ?? '';
        $tokenSessao = $_SESSION['token_confirmacao'] ?? '';

        if (
            !is_string($tokenRecebido) ||
            !is_string($tokenSessao) ||
            $tokenSessao === '' ||
            !hash_equals($tokenSessao, $tokenRecebido)
        ) {
            // INVALIDA O TOKEN ANTERIOR E GERA UM NOVO
            unset($_SESSION['token_confirmacao']);
            $this->gerarTokenConfirmacao();

            $_SESSION['mensagem_finalizacao'] =
                'Esta confirmação já foi utilizada ou expirou. Tente novamente.';

            header('Location: ' . BASE_URL . '/finalizacao');
            exit;
        }

        // INVALIDA O TOKEN PARA EVITAR REENVIO
        unset($_SESSION['token_confirmacao']);

        $carrinho = $_SESSION['carrinho'] ?? [];

        if (!is_array($carrinho) || empty($carrinho)) {
            header('Location: ' . BASE_URL . '/carrinho');
            exit;
        }

        $pagamentosPermitidos = [
            'pix' => 'PIX',
            'cartao' => 'Cartão',
            'boleto' => 'Boleto'
        ];

        $valoresFrete = [
            'normal' => 10.00,
            'expresso' => 20.00
        ];

        $pagamento = $_POST['pagamento'] ?? '';
        $frete = $_POST['frete'] ?? '';

        if (
            !is_string($pagamento) ||
            !is_string($frete) ||
            !isset($pagamentosPermitidos[$pagamento]) ||
            !isset($valoresFrete[$frete])
        ) {
            $this->gerarTokenConfirmacao();

            $_SESSION['mensagem_finalizacao'] =
                'Selecione uma forma de pagamento e um frete válidos.';

            header('Location: ' . BASE_URL . '/finalizacao');
            exit;
        }

        try {
            $idusuario = filter_var(
                $_SESSION['usuario_id'],
                FILTER_VALIDATE_INT
            );

            if (!$idusuario || $idusuario < 1) {
                throw new Exception('Usuário inválido.');
            }

            $db = new Database();
            $conexao = $db->conectar();

            // CONFERE A FORMA DE PAGAMENTO
            $stmt = $conexao->prepare(
                "SELECT Idfpag
                 FROM formapagamento
                 WHERE Formapag = :forma AND Ativo = 1
                 LIMIT 1"
            );

            $stmt->execute([
                ':forma' => $pagamentosPermitidos[$pagamento]
            ]);

            $formaPagamento = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!$formaPagamento) {
                throw new Exception('Forma de pagamento indisponível.');
            }

            $idFormaPagamento = (int) $formaPagamento['Idfpag'];

            // REVALIDA O CUPOM
            $percentualDesconto = 0;

            if (!empty($_SESSION['cupom']['Codigo'])) {
                $codigoCupom = $_SESSION['cupom']['Codigo'];

                if (!is_string($codigoCupom)) {
                    throw new Exception('Código de cupom inválido.');
                }

                $promocao = $this->buscarCupom(
                    $conexao,
                    $codigoCupom
                );

                if (!$this->cupomValido($promocao)) {
                    unset($_SESSION['cupom']);

                    throw new Exception(
                        'O cupom expirou ou não está mais disponível.'
                    );
                }

                $percentualDesconto =
                    (float) $promocao['Valordesconto'];
            }

            // BUSCA OS PREÇOS ATUAIS DOS PRODUTOS
            $stmtProduto = $conexao->prepare(
                "SELECT Idproduto, Preco
                 FROM produto
                 WHERE Idproduto = :id"
            );

            $itens = [];
            $subtotalGeral = 0;

            foreach ($carrinho as $item) {
                if (!is_array($item)) {
                    throw new Exception('Item inválido no carrinho.');
                }

                $idproduto = filter_var(
                    $item['id'] ?? null,
                    FILTER_VALIDATE_INT
                );

                $quantidade = filter_var(
                    $item['quantidade'] ?? null,
                    FILTER_VALIDATE_INT
                );

                if (
                    !$idproduto || $idproduto < 1 ||
                    !$quantidade || $quantidade < 1
                ) {
                    throw new Exception('Item inválido no carrinho.');
                }

                $stmtProduto->execute([
                    ':id' => $idproduto
                ]);

                $produto = $stmtProduto->fetch(PDO::FETCH_ASSOC);

                if (!$produto) {
                    throw new Exception('Produto não encontrado.');
                }

                // VALIDA O PREÇO RETORNADO PELO BANCO
                if (
                    !isset($produto['Preco']) ||
                    !is_numeric($produto['Preco']) ||
                    (float) $produto['Preco'] < 0
                ) {
                    throw new Exception('Preço do produto inválido.');
                }

                $subtotal = round(
                    (float) $produto['Preco'] * $quantidade,
                    2
                );

                $itens[] = [
                    'idproduto' => $idproduto,
                    'quantidade' => $quantidade,
                    'subtotal' => $subtotal
                ];

                $subtotalGeral += $subtotal;
            }

            if (empty($itens)) {
                throw new Exception('O carrinho está vazio.');
            }

            $subtotalGeral = round($subtotalGeral, 2);

            $descontoGeral = round(
                $subtotalGeral * $percentualDesconto / 100,
                2
            );

            // CALCULA FRETE E TOTAL
            $valorFrete = $valoresFrete[$frete];

            $totalProdutos = round(
                $subtotalGeral - $descontoGeral,
                2
            );

            $totalFinal = round(
                $totalProdutos + $valorFrete,
                2
            );

            // INICIA A TRANSAÇÃO
            $conexao->beginTransaction();

            $stmtPedido = $conexao->prepare(
                "INSERT INTO pedido
                    (Idusuario, Idproduto, Quantidade, Dataentrega, Valor)
                 VALUES
                    (:usuario, :produto, :quantidade, NULL, :valor)"
            );

            $stmtPagamento = $conexao->prepare(
                "INSERT INTO pagamento
                    (Idpedido, Idfpag, Idusuario, Valor)
                 VALUES
                    (:pedido, :forma, :usuario, :valor)"
            );

            // DISTRIBUI O DESCONTO ENTRE OS ITENS
            $descontoRestante = $descontoGeral;
            $quantidadeItens = count($itens);

            foreach ($itens as $indice => $item) {
                if ($indice === $quantidadeItens - 1) {
                    $descontoItem = $descontoRestante;

                } else {
                    $descontoItem = round(
                        $item['subtotal'] * $percentualDesconto / 100,
                        2
                    );

                    $descontoRestante = round(
                        $descontoRestante - $descontoItem,
                        2
                    );
                }

                $valorItem = round(
                    $item['subtotal'] - $descontoItem,
                    2
                );

                if ($valorItem < 0) {
                    throw new Exception('Erro no cálculo do desconto.');
                }

                $stmtPedido->execute([
                    ':usuario' => $idusuario,
                    ':produto' => $item['idproduto'],
                    ':quantidade' => $item['quantidade'],
                    ':valor' => $valorItem
                ]);

                $idpedido = (int) $conexao->lastInsertId();

                $stmtPagamento->execute([
                    ':pedido' => $idpedido,
                    ':forma' => $idFormaPagamento,
                    ':usuario' => $idusuario,
                    ':valor' => $valorItem
                ]);
            }

            // CONFIRMA A TRANSAÇÃO
            $conexao->commit();

            // LIMPA O CARRINHO E O CUPOM
            unset(
                $_SESSION['carrinho'],
                $_SESSION['cupom']
            );

            // DADOS TEMPORÁRIOS PARA A TELA DE SUCESSO
            $_SESSION['pedido_total'] = $totalFinal;
            $_SESSION['pedido_subtotal'] = $subtotalGeral;
            $_SESSION['pedido_desconto'] = $descontoGeral;
            $_SESSION['pedido_frete'] = $valorFrete;

            header('Location: ' . BASE_URL . '/finalizacao?sucesso=1');
            exit;

        } catch (Throwable $e) {
            if (
                isset($conexao) &&
                $conexao instanceof PDO &&
                $conexao->inTransaction()
            ) {
                $conexao->rollBack();
            }

            error_log('Erro ao confirmar pedido: ' . $e->getMessage());

            // PERMITE UMA NOVA TENTATIVA
            $this->gerarTokenConfirmacao();

            $_SESSION['mensagem_finalizacao'] =
                'Não foi possível finalizar a compra. Tente novamente.';

            header('Location: ' . BASE_URL . '/finalizacao');
            exit;
        }
    }

    // BUSCAR CUPOM NO BANCO
    private function buscarCupom(PDO $conexao, string $codigo)
    {
        $sql = "SELECT Codigo, Valordesconto, Datainicio,
                       Datafim, Ativo
                FROM promocoes
                WHERE Codigo = :codigo
                LIMIT 1";

        $stmt = $conexao->prepare($sql);
        $stmt->execute([':codigo' => $codigo]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // VALIDAR CUPOM
    private function cupomValido($promocao): bool
    {
        if (!$promocao) {
            return false;
        }

        $hoje = date('Y-m-d');
        $desconto = (float) $promocao['Valordesconto'];

        return
            (int) $promocao['Ativo'] === 1 &&
            $hoje >= $promocao['Datainicio'] &&
            $hoje <= $promocao['Datafim'] &&
            $desconto > 0 &&
            $desconto <= 100;
    }
}


<?php

require_once __DIR__ . '/../models/Produto.php';
require_once __DIR__ . '/../models/Feedback.php';

class CompraController
{
    public function index()
    {
        $idproduto = $_GET['id'] ?? null;

        if (!$idproduto) {
            echo 'Produto não encontrado.';
            return;
        }

        $produtoModel = new Produto();
        $produto = $produtoModel->buscarPorId($idproduto);

        if (!$produto) {
            echo 'Produto não encontrado.';
            return;
        }

        $feedbackModel = new Feedback();
        $feedbacks = $feedbackModel->listarPorProduto($idproduto);

        require_once __DIR__ . '/../views/compra/index.php';
    }

    public function adicionarAoCarrinho()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /elyon/');
            exit;
        }

        $idproduto = filter_input(
            INPUT_POST,
            'idproduto',
            FILTER_VALIDATE_INT
        );

        $quantidade = filter_input(
            INPUT_POST,
            'quantidade',
            FILTER_VALIDATE_INT
        );

        if (!$idproduto || $idproduto < 1) {
            header('Location: /elyon/');
            exit;
        }

        if (!$quantidade || $quantidade < 1) {
            $quantidade = 1;
        }

        $produtoModel = new Produto();
        $produto = $produtoModel->buscarPorId($idproduto);

        if (!$produto) {
            header('Location: /elyon/');
            exit;
        }

        $id = (int) $produto['Idproduto'];

        if (
            !isset($_SESSION['carrinho']) ||
            !is_array($_SESSION['carrinho'])
        ) {
            $_SESSION['carrinho'] = [];
        }

        if (isset($_SESSION['carrinho'][$id])) {
            $_SESSION['carrinho'][$id]['quantidade'] += $quantidade;
        } else {
            $_SESSION['carrinho'][$id] = [
                'idproduto' => $id,
                'nome' => $produto['Nome'],
                'preco' => (float) $produto['Preco'],
                'imagem' => $produto['Imagem'] ?? '',
                'quantidade' => $quantidade
            ];
        }

        header('Location: /elyon/carrinho');
        exit;
    }

    public function carrinho()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Aplicar cupom
        if (
            $_SERVER['REQUEST_METHOD'] === 'POST' &&
            isset($_POST['cupom'])
        ) {
            $codigo = strtoupper(trim((string) $_POST['cupom']));

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
                            'Valordesconto' =>
                                (float) $promocao['Valordesconto']
                        ];

                        $_SESSION['mensagem_cupom'] =
                            'Cupom aplicado com sucesso!';
                    }
                } catch (Throwable $e) {
                    error_log(
                        'Erro ao validar cupom: ' . $e->getMessage()
                    );

                    $_SESSION['mensagem_cupom'] =
                        'Não foi possível validar o cupom.';
                }
            }

            header('Location: /elyon/carrinho');
            exit;
        }

        $carrinho = $_SESSION['carrinho'] ?? [];
        $cupomAplicado = $_SESSION['cupom'] ?? null;

        $mensagemCupom = $_SESSION['mensagem_cupom'] ?? '';
        unset($_SESSION['mensagem_cupom']);

        require_once __DIR__ . '/../views/carrinho/index.php';
    }

    public function finalizacao()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['usuario_id'])) {
            header('Location: /elyon/login');
            exit;
        }

        $carrinho = $_SESSION['carrinho'] ?? [];

        if (empty($carrinho)) {
            header('Location: /elyon/carrinho');
            exit;
        }

        require_once __DIR__ . '/../views/finalizacao/index.php';
    }

    public function confirmarPedido()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['usuario_id'])) {
            header('Location: /elyon/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /elyon/finalizacao');
            exit;
        }

        $carrinho = $_SESSION['carrinho'] ?? [];

        if (empty($carrinho) || !is_array($carrinho)) {
            header('Location: /elyon/carrinho');
            exit;
        }

        $pagamentosPermitidos = [
            'pix' => 'PIX',
            'cartao' => 'Cartão',
            'boleto' => 'Boleto'
        ];

        $fretesPermitidos = ['normal', 'expresso'];

        $pagamento = $_POST['pagamento'] ?? '';
        $frete = $_POST['frete'] ?? '';

        if (
            !isset($pagamentosPermitidos[$pagamento]) ||
            !in_array($frete, $fretesPermitidos, true)
        ) {
            echo 'Selecione uma forma de pagamento e um frete válidos.';
            return;
        }

        try {
            $idusuario = (int) $_SESSION['usuario_id'];

            $db = new Database();
            $conexao = $db->conectar();

            // Confere a forma de pagamento
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
                throw new Exception(
                    'Forma de pagamento indisponível. Confira os registros da tabela formapagamento.'
                );
            }

            $idFormaPagamento = (int) $formaPagamento['Idfpag'];

            // Revalida o cupom no banco
            $percentualDesconto = 0;

            if (!empty($_SESSION['cupom']['Codigo'])) {
                $promocao = $this->buscarCupom(
                    $conexao,
                    $_SESSION['cupom']['Codigo']
                );

                if (!$this->cupomValido($promocao)) {
                    unset($_SESSION['cupom']);

                    throw new Exception(
                        'O cupom expirou ou não está mais disponível. Aplique-o novamente no carrinho.'
                    );
                }

                $percentualDesconto =
                    (float) $promocao['Valordesconto'];
            }

            // Busca os preços atuais dos produtos no banco
            $stmtProduto = $conexao->prepare(
                "SELECT Idproduto, Preco
                 FROM produto
                 WHERE Idproduto = :id"
            );

            $itens = [];
            $subtotalGeral = 0;

            foreach ($carrinho as $item) {
                $idproduto = filter_var(
                    $item['idproduto'] ?? null,
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

                $stmtProduto->execute([':id' => $idproduto]);
                $produto = $stmtProduto->fetch(PDO::FETCH_ASSOC);

                if (!$produto) {
                    throw new Exception('Produto não encontrado.');
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

            $subtotalGeral = round($subtotalGeral, 2);

            $descontoGeral = round(
                $subtotalGeral * $percentualDesconto / 100,
                2
            );

            $totalFinal = round(
                $subtotalGeral - $descontoGeral,
                2
            );

            // Distribui o desconto pelos itens para que
            // a soma dos pedidos corresponda ao total final.
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

            $descontoRestante = $descontoGeral;
            $quantidadeItens = count($itens);

            foreach ($itens as $indice => $item) {
                if ($indice === $quantidadeItens - 1) {
                    // Ajuste de arredondamento no último item
                    $descontoItem = $descontoRestante;
                } else {
                    $descontoItem = round(
                        $item['subtotal'] *
                        $percentualDesconto / 100,
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

            $conexao->commit();

            unset($_SESSION['carrinho']);
            unset($_SESSION['cupom']);

            $_SESSION['pedido_total'] = $totalFinal;
            $_SESSION['pedido_subtotal'] = $subtotalGeral;
            $_SESSION['pedido_desconto'] = $descontoGeral;

            header('Location: /elyon/finalizacao?sucesso=1');
            exit;

        } catch (Throwable $e) {
            if (isset($conexao) && $conexao->inTransaction()) {
                $conexao->rollBack();
            }

            error_log(
                'Erro ao confirmar pedido: ' . $e->getMessage()
            );

            http_response_code(500);

            echo 'Não foi possível finalizar a compra. ';
            echo htmlspecialchars(
                $e->getMessage(),
                ENT_QUOTES,
                'UTF-8'
            );
        }
    }

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

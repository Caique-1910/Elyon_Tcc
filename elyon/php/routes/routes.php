<?php

require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/SobreController.php';
require_once __DIR__ . '/../controllers/ContatoController.php';
require_once __DIR__ . '/../controllers/FeedbackController.php';
require_once __DIR__ . '/../controllers/LoginController.php';
require_once __DIR__ . '/../controllers/CadastroController.php';
require_once __DIR__ . '/../controllers/CompraController.php';

$controller = new HomeController();

$url = $_GET['url'] ?? '';

$url = trim($url, '/');

switch ($url) {

    // HOME
    case '':
        $controller->index();
        break;

    // CATEGORIAS
    case 'masculino':
        $controller->masculino();
        break;

    case 'feminino':
        $controller->feminino();
        break;

    case 'skincare':
        $controller->skincare();
        break;

    case 'maquiagem':
        $controller->maquiagem();
        break;

    case 'cabelos':
        $controller->cabelos();
        break;

    // SOBRE
    case 'sobre':
        $controller = new SobreController();
        $controller->index();
        break;

    // CONTATO
    case 'contato':
        $controller = new ContatoController();
        $controller->index();
        break;

    case 'feedback':
    $controller = new FeedbackController();
    $controller->index();
    break;

// SALVAR FEEDBACK
case 'feedback/salvar':
    $controller = new FeedbackController();
    $controller->salvar();
    break;

    // LOGIN
    case 'login':
        $controller = new LoginController();
        $controller->index();
        break;

    // PROCESSAR LOGIN
    case 'login/salvar':
        $controller = new LoginController();
        $controller->entrar();
        break;

    // CADASTRO
    case 'cadastro':
        $controller = new CadastroController();
        $controller->index();
        break;

    // PROCESSAR CADASTRO
    case 'cadastro/salvar':
        $controller = new CadastroController();
        $controller->cadastrar();
        break;

    // LOGOUT
    case 'logout':
        $controller = new LoginController();
        $controller->logout();
        break;

    // COMPRA / DETALHES DO PRODUTO
    case 'compra':
        $controller = new CompraController();
        $controller->index();
        break;

    
    // CARRINHO
    case 'carrinho':
        $controller = new CompraController();
        $controller->carrinho();
        break;
    
    
case 'compra/adicionar':
    $controller = new CompraController();
    $controller->adicionarAoCarrinho();
    break;

    
    // PÁGINA DE FINALIZAÇÃO
    case 'finalizacao':
        $controller = new CompraController();
        $controller->finalizacao();
        break;

    // CONFIRMAR PEDIDO
    case 'finalizacao/confirmar':
        $controller = new CompraController();
        $controller->confirmarPedido();
        break;


    // ROTA NÃO ENCONTRADA
    default:
        echo "Página não encontrada.";
        break;
}
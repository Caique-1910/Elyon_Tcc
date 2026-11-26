
<?php

/**
 * ======================================================
 * ROTAS DO PROJETO ELYON
 * ======================================================
 */

// Controllers
require_once __DIR__ . '/../controllers/HomeController.php';
require_once __DIR__ . '/../controllers/SobreController.php';
require_once __DIR__ . '/../controllers/ContatoController.php';
require_once __DIR__ . '/../controllers/FeedbackController.php';
require_once __DIR__ . '/../controllers/LoginController.php';
require_once __DIR__ . '/../controllers/CadastroController.php';
require_once __DIR__ . '/../controllers/CompraController.php';
require_once __DIR__ . '/../controllers/TermosController.php';
require_once __DIR__ . '/../controllers/PrivacidadeController.php';

// URL solicitada
$url = $_GET['url'] ?? '';

// Garante que a URL seja uma string
if (!is_string($url)) {
    http_response_code(400);
    exit('Requisição inválida.');
}

// Normaliza a URL
$url = trim($url, '/');

// Evita caracteres de controle na URL
if (preg_match('/[\x00-\x1F\x7F]/', $url)) {
    http_response_code(400);
    exit('Requisição inválida.');
}

// ======================================================
// DEFINIÇÃO DAS ROTAS
// ======================================================

switch ($url) {

    // HOME
    case '':
        $controller = new HomeController();
        $controller->index();
        break;

    // CATEGORIAS
    case 'masculino':
        $controller = new HomeController();
        $controller->masculino();
        break;

    case 'feminino':
        $controller = new HomeController();
        $controller->feminino();
        break;

    case 'skincare':
        $controller = new HomeController();
        $controller->skincare();
        break;

    case 'maquiagem':
        $controller = new HomeController();
        $controller->maquiagem();
        break;

    case 'cabelos':
        $controller = new HomeController();
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

    // FEEDBACK
    case 'feedback':
        $controller = new FeedbackController();
        $controller->index();
        break;

    case 'feedback/salvar':
        $controller = new FeedbackController();
        $controller->salvar();
        break;

    // LOGIN
    case 'login':
        $controller = new LoginController();
        $controller->index();
        break;

    case 'login/salvar':
        $controller = new LoginController();
        $controller->entrar();
        break;

    // CADASTRO
    case 'cadastro':
        $controller = new CadastroController();
        $controller->index();
        break;

    case 'cadastro/salvar':
        $controller = new CadastroController();
        $controller->cadastrar();
        break;

    // LOGOUT
    case 'logout':
        $controller = new LoginController();
        $controller->logout();
        break;
        
    // COMPRA
    case 'compra':
        $controller = new CompraController();
        $controller->index();
        break;

    case 'compra/adicionar':
        $controller = new CompraController();
        $controller->adicionarAoCarrinho();
        break;

    // CARRINHO
    case 'carrinho':
        $controller = new CompraController();
        $controller->carrinho();
        break;

    case 'carrinho/atualizar':
        $controller = new CompraController();
        $controller->atualizarCarrinho();
        break;

    case 'carrinho/remover':
        $controller = new CompraController();
        $controller->removerDoCarrinho();
        break;

    // FINALIZAÇÃO
    case 'finalizacao':
        $controller = new CompraController();
        $controller->finalizacao();
        break;

    case 'finalizacao/confirmar':
        $controller = new CompraController();
        $controller->confirmarPedido();
        break;

    // PÁGINAS INSTITUCIONAIS
    case 'termos':
        $controller = new TermosController();
        $controller->index();
        break;

    case 'privacidade':
        $controller = new PrivacidadeController();
        $controller->index();
        break;

    // ROTA NÃO ENCONTRADA
    default:
        http_response_code(404);
        echo 'Página não encontrada.';
        break;
}

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Elyon Perfumaria</title>

    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/global.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/paginas-legais.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/header.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/footer.css">
  
</head>

<body>
<?php
require_once __DIR__ . '/../../../includes/header.php';
?>

<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/paginas-legais.css">

<main class="pagina-legal">
    <section class="legal-banner">
        <span class="legal-etiqueta">ELYON PERFUMARIA</span>
        <h1>Política de Privacidade</h1>
        <p>Saiba como seus dados pessoais são tratados em nossa plataforma.</p>
    </section>

    <article class="legal-conteudo">
        <p class="legal-atualizacao">
            Última atualização: novembro de 2026
        </p>

        <p>
            A Elyon Perfumaria valoriza a privacidade e a segurança
            das informações de seus usuários. Esta Política de Privacidade
            explica quais dados podem ser coletados, por que são utilizados
            e quais são os direitos dos titulares, conforme a Lei Geral
            de Proteção de Dados Pessoais (Lei nº 13.709/2018 — LGPD).
        </p>

        <h2>1. Quais dados coletamos?</h2>
        <p>Durante a utilização da plataforma, podemos tratar os seguintes dados:</p>
        <ul>
            <li><strong>Dados de cadastro:</strong> nome e endereço de e-mail;</li>
            <li><strong>Dados de acesso:</strong> informações necessárias
                para autenticação e manutenção da sessão;</li>
            <li><strong>Dados de pedidos:</strong> produtos, quantidades,
                valores e forma de pagamento selecionada;</li>
            <li><strong>Dados de avaliações:</strong> comentários e notas
                enviados sobre os produtos;</li>
            <li><strong>Dados do carrinho:</strong> produtos e quantidades
                adicionados durante a navegação.</li>
        </ul>

        <h2>2. Para que utilizamos os dados?</h2>
        <p>Os dados pessoais podem ser utilizados para:</p>
        <ul>
            <li>Permitir o cadastro e o acesso à conta;</li>
            <li>Identificar o usuário durante a utilização do sistema;</li>
            <li>Registrar e organizar pedidos;</li>
            <li>Disponibilizar as funcionalidades do carrinho e da finalização;</li>
            <li>Permitir o envio de avaliações e comentários;</li>
            <li>Prestar atendimento e responder às solicitações dos usuários;</li>
            <li>Manter a segurança e o funcionamento da plataforma.</li>
        </ul>

        <h2>3. Como protegemos as informações?</h2>
        <p>
            A plataforma utiliza medidas técnicas para proteger as
            informações armazenadas. As senhas dos usuários são armazenadas
            por meio de funções de hash, não sendo registradas como texto
            simples no banco de dados.
        </p>
        <p>
            Também são utilizadas consultas preparadas no acesso ao banco
            de dados para reduzir riscos relacionados à manipulação
            indevida de comandos SQL.
        </p>
        <p>
            Apesar dos cuidados adotados, nenhum sistema é completamente
            livre de riscos. Por isso, trabalhamos para preservar a
            confidencialidade e a integridade das informações.
        </p>

        <h2>4. Compartilhamento de dados</h2>
        <p>
            Os dados poderão ser compartilhados quando necessário para
            o funcionamento da plataforma, para atender obrigações legais
            ou mediante outras hipóteses permitidas pela legislação.
        </p>
        <p>
            A plataforma não deve compartilhar dados pessoais para
            finalidades incompatíveis com aquelas informadas nesta política.
        </p>

        <h2>5. Armazenamento e conservação</h2>
        <p>
            Os dados são armazenados no banco de dados utilizado pela
            plataforma. O período de conservação depende da finalidade
            do tratamento e das obrigações legais aplicáveis.
        </p>
        <p>
            As informações poderão ser mantidas pelo período necessário
            para cumprir obrigações legais, resolver solicitações ou
            proteger direitos, observadas as hipóteses previstas na LGPD.
        </p>

        <h2>6. Cookies e sessões</h2>
        <p>
            A plataforma utiliza sessões para manter o usuário autenticado
            e permitir o funcionamento de recursos como o carrinho de compras.
            Essas informações são necessárias para a navegação e a utilização
            de determinadas funcionalidades.
        </p>

        <h2>7. Direitos do titular dos dados</h2>
        <p>
            Nos termos da LGPD, o titular pode solicitar, observadas
            as condições legais:
        </p>
        <ul>
            <li>Confirmação da existência de tratamento de dados;</li>
            <li>Acesso aos dados pessoais;</li>
            <li>Correção de informações incompletas ou desatualizadas;</li>
            <li>Anonimização, bloqueio ou eliminação de dados desnecessários
                ou tratados em desconformidade com a lei;</li>
            <li>Informações sobre compartilhamento de dados;</li>
            <li>Eliminação dos dados tratados com consentimento, quando
                aplicável e ressalvadas as hipóteses legais de conservação;</li>
            <li>Demais direitos previstos na legislação aplicável.</li>
        </ul>

        <h2>8. Segurança da conta</h2>
        <p>
            O usuário deve manter sua senha em sigilo e evitar compartilhá-la.
            Caso suspeite de acesso indevido à sua conta, recomendamos
            entrar em contato com a equipe responsável pela plataforma.
        </p>

        <h2>9. Alterações nesta política</h2>
        <p>
            Esta Política de Privacidade poderá ser atualizada para refletir
            mudanças nos procedimentos da plataforma ou na legislação.
            A versão mais recente estará disponível nesta página.
        </p>

        <h2>10. Contato sobre privacidade</h2>
        <p>
            Para dúvidas ou solicitações relacionadas ao tratamento
            de dados pessoais, entre em contato:
        </p>
        <p>
            <strong>E-mail:</strong>
            <a href="mailto:elyon@gmail.com">elyon@gmail.com</a>
        </p>
    </article>
</main>

<?php
require_once __DIR__ . '/../../../includes/footer.php';
?>
</body>
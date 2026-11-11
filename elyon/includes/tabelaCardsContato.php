
<?php


$cardsContato = [
    [
        'titulo' => 'Pedidos',
        'descricao' => 'Precisa de ajuda com seu pedido? Aqui você pode esclarecer dúvidas sobre a realização de compras, consultar informações sobre o andamento do seu pedido e receber orientações caso tenha ocorrido algum problema durante a confirmação ou o processamento da compra. Nossa equipe está preparada para ajudar você a ter uma experiência de compra simples, segura e tranquila.'
    ],
    [
        'titulo' => 'Pagamento',
        'descricao' => 'Na Elyon Perfumaria, queremos que sua compra seja prática e segura. Nesta seção, você pode tirar dúvidas sobre as formas de pagamento disponíveis, entender como funciona a confirmação da transação e buscar orientações caso seu pagamento tenha sido recusado, esteja pendente ou apresente alguma inconsistência. Nosso objetivo é ajudar você a concluir sua compra com tranquilidade.'
    ],
    [
        'titulo' => 'Entregas',
        'descricao' => 'Quer saber quando seu perfume chegará? Aqui você encontra orientações sobre os prazos de entrega, o acompanhamento do envio e as possíveis situações que podem causar atrasos. Se seu pedido estiver demorando mais do que o esperado ou houver alguma dificuldade no recebimento, entre em contato com nossa equipe para receber as informações e o suporte necessários.'
    ],
    [
        'titulo' => 'Trocas',
        'descricao' => 'Se você recebeu um produto diferente do solicitado ou precisa verificar a possibilidade de realizar uma troca, esta seção é para você. Aqui explicamos como solicitar atendimento, quais informações podem ser necessárias e como funciona a análise de cada caso. As solicitações são avaliadas conforme as condições da compra e a política de trocas aplicável.'
    ],
    [
        'titulo' => 'Lojas',
        'descricao' => 'Deseja conhecer melhor a Elyon Perfumaria ou saber onde encontrar nossos produtos? Entre em contato para consultar informações sobre nossas unidades, endereços e formas de atendimento presencial, quando disponíveis. Nossa equipe poderá orientar você sobre os canais de atendimento e ajudar a encontrar a melhor maneira de conhecer nossos produtos.'
    ],
    [
        'titulo' => 'Reembolso',
        'descricao' => 'Se você cancelou uma compra ou possui uma solicitação de devolução, nossa equipe pode orientar você sobre o processo de reembolso. Nesta seção, você pode esclarecer dúvidas sobre as etapas da solicitação, o acompanhamento do pedido de reembolso e os prazos aplicáveis. O processamento depende da análise do caso e das condições da compra e do meio de pagamento utilizado.'
    ],
    [
        'titulo' => 'Consultoria',
        'descricao' => 'Está em dúvida sobre qual fragrância combina mais com você? Nossa consultoria pode ajudar na escolha de perfumes de acordo com suas preferências, ocasiões de uso e características olfativas que você mais aprecia. Você também pode buscar orientações sobre notas cítricas, florais, amadeiradas e orientais para encontrar opções que correspondam ao seu estilo e à experiência que deseja.'
    ],
    [
        'titulo' => 'CashBack',
        'descricao' => 'Quer entender como aproveitar os benefícios de cashback? Aqui você pode esclarecer dúvidas sobre as regras de participação, as condições para receber benefícios e como consultar as informações relacionadas às suas compras elegíveis. A disponibilidade, o valor e a utilização do cashback dependem das regras da campanha ou do programa vigente na Elyon Perfumaria.'
    ],
    [
        'titulo' => 'Promoções',
        'descricao' => 'Fique por dentro das oportunidades para encontrar seus produtos favoritos. Nesta seção, você pode esclarecer dúvidas sobre descontos, campanhas promocionais, cupons e condições especiais de compra. Nossa equipe poderá orientar você sobre a validade das ofertas, os produtos participantes e as regras necessárias para aproveitar cada promoção, conforme os termos divulgados.'
    ]
];


?>

<div class="div_dos_cards_contato">

    <?php foreach ($cardsContato as $card): ?>

        <?php require __DIR__ . '/cardContato.php'; ?>

    <?php endforeach; ?>

</div>

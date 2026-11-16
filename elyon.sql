-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 28/10/2026 às 18:37
-- Versão do servidor: 10.4.32-MariaDB
-- Versão do PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `elyon`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `feedback`
--

CREATE TABLE `feedback` (
  `Idfeedback` int(11) NOT NULL,
  `Idusuario` int(11) NOT NULL,
  `Idproduto` int(11) NOT NULL,
  `Comentario` varchar(300) NOT NULL,
  `Estrela` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `feedback`
--

INSERT INTO `feedback` (`Idfeedback`, `Idusuario`, `Idproduto`, `Comentario`, `Estrela`) VALUES
(1, 1, 1, 'Uma experiencia muito agradável', 5),
(2, 1, 2, 'Uma das melhores experiencias da vida', 4);

-- --------------------------------------------------------

--
-- Estrutura para tabela `formapagamento`
--

CREATE TABLE `formapagamento` (
  `Idfpag` int(11) NOT NULL,
  `Formapag` varchar(40) NOT NULL,
  `Ativo` tinyint(1) NOT NULL DEFAULT 1,
  `Codigonf` varchar(60) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `formapagamento`
--

INSERT INTO `formapagamento` (`Idfpag`, `Formapag`, `Ativo`, `Codigonf`) VALUES
(1, 'PIX', 1, NULL),
(2, 'Cartão', 1, NULL),
(3, 'Boleto', 1, NULL);

-- --------------------------------------------------------

--
-- Estrutura para tabela `marca`
--

CREATE TABLE `marca` (
  `Idmarca` int(11) NOT NULL,
  `Nome` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `marca`
--

INSERT INTO `marca` (`Idmarca`, `Nome`) VALUES
(1, 'Natura'),
(2, 'O Boticário'),
(3, 'Eudora'),
(4, 'Avon'),
(5, 'L\'Occitane');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamento`
--

CREATE TABLE `pagamento` (
  `Idpag` int(11) NOT NULL,
  `Idpedido` int(11) NOT NULL,
  `Idfpag` int(11) NOT NULL,
  `Idusuario` int(11) NOT NULL,
  `Valor` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pagamento`
--

INSERT INTO `pagamento` (`Idpag`, `Idpedido`, `Idfpag`, `Idusuario`, `Valor`) VALUES
(1, 1, 1, 3, 379.80),
(2, 2, 1, 3, 229.90),
(3, 3, 2, 3, 359.60);

-- --------------------------------------------------------

--
-- Estrutura para tabela `pedido`
--

CREATE TABLE `pedido` (
  `Idpedido` int(11) NOT NULL,
  `Idusuario` int(11) NOT NULL,
  `Idproduto` int(11) NOT NULL,
  `Quantidade` int(11) NOT NULL,
  `Dataentrega` date DEFAULT NULL,
  `Valor` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `pedido`
--

INSERT INTO `pedido` (`Idpedido`, `Idusuario`, `Idproduto`, `Quantidade`, `Dataentrega`, `Valor`) VALUES
(1, 3, 2, 2, NULL, 379.80),
(2, 3, 8, 1, NULL, 229.90),
(3, 3, 9, 4, NULL, 359.60);

-- --------------------------------------------------------

--
-- Estrutura para tabela `produto`
--

CREATE TABLE `produto` (
  `Idproduto` int(11) NOT NULL,
  `Nome` varchar(70) NOT NULL,
  `Preco` decimal(10,2) NOT NULL,
  `Marcaid` int(11) NOT NULL,
  `Tipoprodutoid` int(11) NOT NULL,
  `Descricao` varchar(300) DEFAULT NULL,
  `Imagem` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `produto`
--

INSERT INTO `produto` (`Idproduto`, `Nome`, `Preco`, `Marcaid`, `Tipoprodutoid`, `Descricao`, `Imagem`) VALUES
(1, 'Natura Homem', 300.00, 1, 8, 'Perfume masculino com fragrância marcante e sofisticada.', 'assets/imgs/natura.webp'),
(2, 'Kaiak', 189.90, 1, 9, 'Fragrância masculina refrescante e ideal para o dia a dia.', 'assets/imgs/kaiak.webp'),
(3, 'Malbec', 219.90, 2, 8, 'Perfume masculino com fragrância intensa e sofisticada.', 'assets/imgs/malbec.jpg'),
(4, 'Quasar', 159.90, 2, 9, 'Fragrância masculina fresca e versátil.', 'assets/imgs/quasar.jpg'),
(5, 'Essencial', 249.90, 1, 8, 'Perfume feminino elegante com fragrância envolvente.', 'assets/imgs/essencial.jpg'),
(6, 'Egeo Dolce', 199.90, 2, 8, 'Fragrância feminina doce e divertida.', 'assets/imgs/egeo dolce.webp'),
(7, 'Lily', 289.90, 2, 9, 'Fragrância feminina sofisticada e delicada.', 'assets/imgs/lily.webp'),
(8, 'Eudora Rouge', 229.90, 3, 9, 'Perfume feminino marcante com fragrância sofisticada.', 'assets/imgs/eudora rouge.webp'),
(9, 'Body Splash Tododia', 89.90, 1, 9, 'Body splash com fragrância leve e refrescante.', 'assets/imgs/body tododia.webp'),
(10, 'Body Splash Eudora', 99.90, 3, 9, 'Fragrância corporal leve para uso diário.', 'assets/imgs/body eudora.webp'),
(11, 'Hidratante Facial Natura', 79.90, 1, 5, 'Hidratante facial para auxiliar na hidratação da pele.', 'assets/imgs/hidratante facial eudora.webp'),
(12, 'Sabonete Facial Eudora', 49.90, 3, 5, 'Sabonete facial desenvolvido para limpeza da pele.', 'assets/imgs/sabonete_facial_eudora.jpg'),
(13, 'Creme Hidratante L\'Occitane', 129.90, 5, 5, 'Creme hidratante para deixar a pele macia e hidratada.', 'assets/imgs/hidratante_loccitane.jpg'),
(14, 'Batom Eudora', 39.90, 3, 6, 'Batom com acabamento sofisticado e confortável.', 'assets/imgs/batom eudora.webp'),
(15, 'Base Natura', 69.90, 1, 6, 'Base para uniformizar a aparência da pele.', 'assets/imgs/base neutra.jpg'),
(16, 'Mascara de Cilios Avon', 45.90, 4, 6, 'Mascara para destacar e definir os cilios.', 'assets/imgs/mascara cilios avon.webp'),
(17, 'Shampoo Natura', 54.90, 1, 7, 'Shampoo para limpeza e cuidado dos cabelos.', 'assets/imgs/shampoo natura.webp'),
(18, 'Condicionador Natura', 59.90, 1, 7, 'Condicionador para hidratacao e cuidado dos fios.', 'assets/imgs/condicionador natura.webp'),
(19, 'Mascara Capilar Eudora', 74.90, 3, 7, 'Mascara capilar para auxiliar na hidratacao dos fios.', 'assets/imgs/mascara eudora.jpg');

-- --------------------------------------------------------

--
-- Estrutura para tabela `promocoes`
--

CREATE TABLE `promocoes` (
  `Idpromocao` int(11) NOT NULL,
  `Valoratual` decimal(10,2) NOT NULL,
  `Valordesconto` decimal(10,2) NOT NULL,
  `Datainicio` date NOT NULL,
  `Datafim` date NOT NULL,
  `Ativo` tinyint(1) NOT NULL DEFAULT 1,
  `Codigo` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `promocoes`
--

INSERT INTO `promocoes` (`Idpromocao`, `Valoratual`, `Valordesconto`, `Datainicio`, `Datafim`, `Ativo`, `Codigo`) VALUES
(1, 189.90, 10.00, '2026-01-01', '2027-12-31', 1, 'ELYON10');

-- --------------------------------------------------------

--
-- Estrutura para tabela `tipoproduto`
--

CREATE TABLE `tipoproduto` (
  `Idtipoproduto` int(11) NOT NULL,
  `Nome` varchar(70) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `tipoproduto`
--

INSERT INTO `tipoproduto` (`Idtipoproduto`, `Nome`) VALUES
(5, 'Skincare'),
(6, 'Maquiagem'),
(7, 'Cabelos'),
(8, 'Masculino'),
(9, 'Feminino');

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuario`
--

CREATE TABLE `usuario` (
  `Idusuario` int(11) NOT NULL,
  `Nome` varchar(70) NOT NULL,
  `Email` varchar(100) NOT NULL,
  `Senha` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `usuario`
--

INSERT INTO `usuario` (`Idusuario`, `Nome`, `Email`, `Senha`) VALUES
(1, 'ewcknjeghcd', 'eeeee@rmail.com', '$2y$10$WuANBA/eHfvTiFPfwW8R2eTi/8.pnPvhLMCliZ.RGuP79LDyKCPZS'),
(2, 'Caique Lima', 'arriba@gmail.com', '$2y$10$7QsxGhXfmWCbdCwtSgmYBOddgbCNo3RimtsXjE1PFF4qQC5gw50S6'),
(3, 'asnduis', 'lima@gmail.com', '$2y$10$5y87bVOsZ/6/dL1Qib79x.GdodkkGRwMiO8k9vN8jtQ/YMez4Z2Ma');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`Idfeedback`),
  ADD KEY `FK_FEEDBACK_USUARIO` (`Idusuario`),
  ADD KEY `FK_FEEDBACK_PRODUTO` (`Idproduto`);

--
-- Índices de tabela `formapagamento`
--
ALTER TABLE `formapagamento`
  ADD PRIMARY KEY (`Idfpag`);

--
-- Índices de tabela `marca`
--
ALTER TABLE `marca`
  ADD PRIMARY KEY (`Idmarca`);

--
-- Índices de tabela `pagamento`
--
ALTER TABLE `pagamento`
  ADD PRIMARY KEY (`Idpag`),
  ADD KEY `FK_PAGAMENTO_PEDIDO` (`Idpedido`),
  ADD KEY `FK_PAGAMENTO_FORMAPAGAMENTO` (`Idfpag`),
  ADD KEY `FK_PAGAMENTO_USUARIO` (`Idusuario`);

--
-- Índices de tabela `pedido`
--
ALTER TABLE `pedido`
  ADD PRIMARY KEY (`Idpedido`),
  ADD KEY `FK_PEDIDO_USUARIO` (`Idusuario`),
  ADD KEY `FK_PEDIDO_PRODUTO` (`Idproduto`);

--
-- Índices de tabela `produto`
--
ALTER TABLE `produto`
  ADD PRIMARY KEY (`Idproduto`),
  ADD KEY `FK_PRODUTO_MARCA` (`Marcaid`),
  ADD KEY `FK_PRODUTO_TIPOPRODUTO` (`Tipoprodutoid`);

--
-- Índices de tabela `promocoes`
--
ALTER TABLE `promocoes`
  ADD PRIMARY KEY (`Idpromocao`),
  ADD UNIQUE KEY `Codigo` (`Codigo`);

--
-- Índices de tabela `tipoproduto`
--
ALTER TABLE `tipoproduto`
  ADD PRIMARY KEY (`Idtipoproduto`);

--
-- Índices de tabela `usuario`
--
ALTER TABLE `usuario`
  ADD PRIMARY KEY (`Idusuario`),
  ADD UNIQUE KEY `Email` (`Email`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `feedback`
--
ALTER TABLE `feedback`
  MODIFY `Idfeedback` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT de tabela `formapagamento`
--
ALTER TABLE `formapagamento`
  MODIFY `Idfpag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `marca`
--
ALTER TABLE `marca`
  MODIFY `Idmarca` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT de tabela `pagamento`
--
ALTER TABLE `pagamento`
  MODIFY `Idpag` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `pedido`
--
ALTER TABLE `pedido`
  MODIFY `Idpedido` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de tabela `produto`
--
ALTER TABLE `produto`
  MODIFY `Idproduto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT de tabela `promocoes`
--
ALTER TABLE `promocoes`
  MODIFY `Idpromocao` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT de tabela `tipoproduto`
--
ALTER TABLE `tipoproduto`
  MODIFY `Idtipoproduto` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT de tabela `usuario`
--
ALTER TABLE `usuario`
  MODIFY `Idusuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `FK_FEEDBACK_PRODUTO` FOREIGN KEY (`Idproduto`) REFERENCES `produto` (`Idproduto`),
  ADD CONSTRAINT `FK_FEEDBACK_USUARIO` FOREIGN KEY (`Idusuario`) REFERENCES `usuario` (`Idusuario`);

--
-- Restrições para tabelas `pagamento`
--
ALTER TABLE `pagamento`
  ADD CONSTRAINT `FK_PAGAMENTO_FORMAPAGAMENTO` FOREIGN KEY (`Idfpag`) REFERENCES `formapagamento` (`Idfpag`),
  ADD CONSTRAINT `FK_PAGAMENTO_PEDIDO` FOREIGN KEY (`Idpedido`) REFERENCES `pedido` (`Idpedido`),
  ADD CONSTRAINT `FK_PAGAMENTO_USUARIO` FOREIGN KEY (`Idusuario`) REFERENCES `usuario` (`Idusuario`);

--
-- Restrições para tabelas `pedido`
--
ALTER TABLE `pedido`
  ADD CONSTRAINT `FK_PEDIDO_PRODUTO` FOREIGN KEY (`Idproduto`) REFERENCES `produto` (`Idproduto`),
  ADD CONSTRAINT `FK_PEDIDO_USUARIO` FOREIGN KEY (`Idusuario`) REFERENCES `usuario` (`Idusuario`);

--
-- Restrições para tabelas `produto`
--
ALTER TABLE `produto`
  ADD CONSTRAINT `FK_PRODUTO_MARCA` FOREIGN KEY (`Marcaid`) REFERENCES `marca` (`Idmarca`),
  ADD CONSTRAINT `FK_PRODUTO_TIPOPRODUTO` FOREIGN KEY (`Tipoprodutoid`) REFERENCES `tipoproduto` (`Idtipoproduto`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

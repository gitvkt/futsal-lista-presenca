-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 28/07/2026 às 05:12
-- Versão do servidor: 8.4.7
-- Versão do PHP: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `futsal`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `configuracoes`
--

DROP TABLE IF EXISTS `configuracoes`;
CREATE TABLE IF NOT EXISTS `configuracoes` (
  `chave` varchar(50) NOT NULL,
  `valor` text,
  PRIMARY KEY (`chave`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `configuracoes`
--

INSERT INTO `configuracoes` (`chave`, `valor`) VALUES
('chave_pix', 'SUA_CHAVE_PIX'),
('custo_quadra', '200'),
('saldo_acumulado', '0'),
('valor_quadra', '100'),
('whatsapp', '5500000000000');

-- --------------------------------------------------------

--
-- Estrutura para tabela `jogadores`
--

DROP TABLE IF EXISTS `jogadores`;
CREATE TABLE IF NOT EXISTS `jogadores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `valor_pago` decimal(10,2) DEFAULT '0.00',
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=115 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `jogadores`
--

INSERT INTO `jogadores` (`id`, `nome`, `valor_pago`, `criado_em`) VALUES
(103, 'Felipão', 20.00, '2026-07-28 04:35:43'),
(104, 'Lyncon', 20.00, '2026-07-28 04:35:47'),
(105, 'Eric', 20.00, '2026-07-28 04:35:50'),
(106, 'Deivid', 20.00, '2026-07-28 04:35:58'),
(107, 'Aleilson', 20.00, '2026-07-28 04:36:02'),
(108, 'Yan', 20.00, '2026-07-28 04:36:05'),
(109, 'Pedro', 20.00, '2026-07-28 04:36:08'),
(110, 'Paulo', 20.00, '2026-07-28 04:36:12'),
(111, 'Chrystian', 20.00, '2026-07-28 04:36:16'),
(112, 'Nathalya', 20.00, '2026-07-28 04:36:20'),
(113, 'Ueverton', 0.00, '2026-07-28 04:36:24'),
(114, 'Gustavo', 10.00, '2026-07-28 04:36:34');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pagamentos_quadra`
--

DROP TABLE IF EXISTS `pagamentos_quadra`;
CREATE TABLE IF NOT EXISTS `pagamentos_quadra` (
  `id` int NOT NULL AUTO_INCREMENT,
  `valor` decimal(10,2) NOT NULL,
  `descricao` varchar(255) DEFAULT NULL,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `pagamentos_quadra`
--

INSERT INTO `pagamentos_quadra` (`id`, `valor`, `descricao`, `criado_em`) VALUES
(15, 50.00, 'Pagamento Quadra', '2026-07-28 04:36:54'),
(16, 50.00, 'Pagamento Quadra', '2026-07-28 04:36:58');

-- --------------------------------------------------------

--
-- Estrutura para tabela `partidas`
--

DROP TABLE IF EXISTS `partidas`;
CREATE TABLE IF NOT EXISTS `partidas` (
  `id` int NOT NULL AUTO_INCREMENT,
  `adversario` varchar(100) NOT NULL,
  `data` date NOT NULL,
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `partidas`
--

INSERT INTO `partidas` (`id`, `adversario`, `data`, `criado_em`) VALUES
(1, 'teste', '2026-07-30', '2026-07-26 18:09:45');

-- --------------------------------------------------------

--
-- Estrutura para tabela `pendencias`
--

DROP TABLE IF EXISTS `pendencias`;
CREATE TABLE IF NOT EXISTS `pendencias` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `valor_devido` decimal(10,2) DEFAULT '0.00',
  `criado_em` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `usuarios`
--

DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` int NOT NULL AUTO_INCREMENT,
  `usuario` varchar(50) NOT NULL,
  `senha` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `usuario` (`usuario`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `usuarios`
--

INSERT INTO `usuarios` (`id`, `usuario`, `senha`) VALUES
(5, 'admin', '$2y$10$nU5yiFnzb0ra7sKFrUnNmOmTiMZ.bb6ks1dN3FGu9Z1bXmZiR8UcO');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

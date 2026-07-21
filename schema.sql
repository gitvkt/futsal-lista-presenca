CREATE DATABASE IF NOT EXISTS `app_futsal`;
USE `app_futsal`;

-- Tabela de Jogadores
CREATE TABLE IF NOT EXISTS `jogadores` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `nome` VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Tabela de Usuários Admin
CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT AUTO_INCREMENT PRIMARY KEY,
  `usuario` VARCHAR(50) NOT NULL UNIQUE,
  `senha` VARCHAR(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Usuário Admin padrão (Senha: 123@Mudar)
INSERT INTO `usuarios` (`usuario`, `senha`) 
VALUES ('admin', '$2y$10$wN2J0eM1oHkBvH2p9WlYGuI7V/J8x4O1lR1eXpQzS9.p2Q6A5Vw2i');

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Tempo de geração: 01/10/2025 às 18:15
-- Versão do servidor: 8.3.0
-- Versão do PHP: 8.2.18

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Banco de dados: `adm_login`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `admins`
--

DROP TABLE IF EXISTS `admins`;
CREATE TABLE IF NOT EXISTS `admins` (
  `id` int NOT NULL AUTO_INCREMENT,
  `nome` varchar(100) NOT NULL,
  `cpf` varchar(14) NOT NULL,
  `email` varchar(150) NOT NULL,
  `senha` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `cpf` (`cpf`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Despejando dados para a tabela `admins`
--

INSERT INTO `admins` (`id`, `nome`, `cpf`, `email`, `senha`) VALUES
(2, 'Lincoln Silva Vieira', '50702462837', 'silvavieiralincoln@gmail.com', '$2y$10$ZZBwpNZb6YrjjticgI624eP1sA.0wCTgHH3YgwYerTW7mvX6Pbmxe'),
(3, 'Vinicius', '123456789', 'vinicius@gmail.com', '$2y$10$.B0yvk4Roi6WVGSjeeM1IOposwP/mcVdn4JC/WkXpXaS6/EqB2hhe'),
(4, 'Paulo', '987654321', '', '$2y$10$j.1dJFZCq2MIxwBtk4n3k.DlUkK1cEk1Ts7AqVJh5nLOWQ0vMhl9W');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

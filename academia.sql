-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 04/12/2025 às 03:01
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
-- Banco de dados: `academia`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `alunos`
--

CREATE TABLE `alunos` (
  `cpf` varchar(11) NOT NULL,
  `nome` varchar(100) NOT NULL,
  `plano` varchar(10) NOT NULL,
  `idade` int(3) NOT NULL,
  `email` varchar(100) NOT NULL,
  `telefone` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `alunos`
--

INSERT INTO `alunos` (`cpf`, `nome`, `plano`, `idade`, `email`, `telefone`) VALUES
('12414168124', 'lucas henrique', 'Titanium', 18, 'guiwidguig@gmail.com', '83957671623'),
('31232131313', 'juan peixoto', 'Silver', 21, 'fffwidguig@gmail.com', '83957671622');

-- --------------------------------------------------------

--
-- Estrutura para tabela `treinos`
--

CREATE TABLE `treinos` (
  `cpf_aluno` varchar(11) NOT NULL,
  `dia_semana` varchar(20) NOT NULL,
  `treino` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `treinos`
--

INSERT INTO `treinos` (`cpf_aluno`, `dia_semana`, `treino`) VALUES
('12414168124', 'Segunda', 'COSTAS: Puxada Frente, Remada Baixa, Remada Curvada'),
('12414168124', 'Sexta', 'COSTAS: Puxada Frente, Remada Curvada, Serrote'),
('12414168124', 'Terça', 'PERNA: Leg Press, Extensora, Panturrilha');

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `alunos`
--
ALTER TABLE `alunos`
  ADD PRIMARY KEY (`cpf`);

--
-- Índices de tabela `treinos`
--
ALTER TABLE `treinos`
  ADD UNIQUE KEY `unique_treino_dia` (`cpf_aluno`,`dia_semana`);

--
-- Restrições para tabelas despejadas
--

--
-- Restrições para tabelas `treinos`
--
ALTER TABLE `treinos`
  ADD CONSTRAINT `treinos_ibfk_1` FOREIGN KEY (`cpf_aluno`) REFERENCES `alunos` (`cpf`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

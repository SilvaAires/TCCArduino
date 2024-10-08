-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Tempo de geração: 14/08/2024 às 16:03
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
-- Banco de dados: `irrigacaoesp`
--

-- --------------------------------------------------------

--
-- Estrutura para tabela `anotacaodados`
--

CREATE TABLE `anotacaodados` (
  `idAnotacao` int(11) NOT NULL,
  `fkDdado` int(11) NOT NULL,
  `fkUser` int(11) NOT NULL,
  `Descricao` varchar(150) NOT NULL,
  `DataHora` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Imagem` varchar(150) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `dadosdosesp`
--

CREATE TABLE `dadosdosesp` (
  `IdDado` int(11) NOT NULL,
  `IdenEsp` varchar(100) NOT NULL,
  `TempDoAr` double NOT NULL,
  `UmidDoAr` double NOT NULL,
  `PorUmidSolo` int(11) NOT NULL,
  `UmidSolo` double NOT NULL,
  `DataCaptura` date NOT NULL DEFAULT current_timestamp(),
  `HoraCaptura` time NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Despejando dados para a tabela `dadosdosesp`
--

INSERT INTO `dadosdosesp` (`IdDado`, `IdenEsp`, `TempDoAr`, `UmidDoAr`, `PorUmidSolo`, `UmidSolo`, `DataCaptura`, `HoraCaptura`) VALUES
(33, '1', 21.9, 95.1, 100, 4095, '2024-07-26', '10:44:10'),
(34, '1', 21.9, 94.8, 100, 4095, '2024-07-26', '10:44:14'),
(35, '1', 21.9, 94.6, 100, 4095, '2024-07-26', '10:44:18'),
(36, '1', 21.9, 94.3, 100, 4095, '2024-07-26', '10:44:23'),
(37, '1', 21.9, 94.2, 100, 4095, '2024-07-26', '10:44:25'),
(38, '1', 21.9, 93.9, 100, 4095, '2024-07-26', '10:44:28'),
(39, '1', 21.9, 93.7, 100, 4095, '2024-07-26', '10:44:30'),
(40, '1', 21.9, 93.1, 100, 4095, '2024-07-26', '10:44:45'),
(41, '1', 21.9, 93, 100, 4095, '2024-07-26', '10:44:49'),
(42, '1', 30, 65, 90, 4095, '2024-01-01', '00:00:00'),
(43, '1', 25, 70, 95, 4095, '2024-01-03', '12:00:00'),
(44, '1', 28, 75, 92, 4095, '2024-02-02', '09:53:13'),
(45, '1', 24, 73, 93, 4095, '2024-02-06', '10:53:13'),
(46, '1', 30, 70, 90, 4095, '2024-01-05', '09:53:13'),
(47, '1', 29, 72, 91, 4095, '2024-01-15', '10:53:13'),
(48, '1', 28, 75, 92, 4095, '2024-02-02', '09:53:13'),
(49, '1', 24, 73, 93, 4095, '2024-02-06', '10:53:13'),
(50, '1', 27, 71, 88, 4095, '2024-03-03', '09:53:13'),
(51, '1', 26, 74, 89, 4095, '2024-03-12', '10:53:13'),
(52, '1', 25, 69, 87, 4095, '2024-04-08', '09:53:13'),
(53, '1', 23, 68, 85, 4095, '2024-04-19', '10:53:13'),
(54, '1', 29, 66, 86, 4095, '2024-05-04', '09:53:13'),
(55, '1', 28, 67, 84, 4095, '2024-05-15', '10:53:13'),
(56, '1', 31, 75, 92, 4095, '2024-06-01', '09:53:13'),
(57, '1', 30, 72, 91, 4095, '2024-06-22', '10:53:13'),
(58, '1', 27, 68, 89, 4095, '2024-07-05', '09:53:13'),
(59, '1', 26, 69, 90, 4095, '2024-07-18', '10:53:13'),
(60, '1', 28, 74, 88, 4095, '2024-08-06', '09:53:13'),
(61, '1', 27, 73, 87, 4095, '2024-08-21', '10:53:13'),
(62, '1', 26, 71, 86, 4095, '2024-09-07', '09:53:13'),
(63, '1', 25, 72, 85, 4095, '2024-09-23', '10:53:13'),
(64, '1', 28, 70, 91, 4095, '2024-10-03', '09:53:13'),
(65, '1', 27, 72, 92, 4095, '2024-10-19', '10:53:13'),
(66, '1', 29, 69, 90, 4095, '2024-11-09', '09:53:13'),
(67, '1', 28, 68, 89, 4095, '2024-11-25', '10:53:13'),
(68, '1', 30, 73, 93, 4095, '2024-12-05', '09:53:13'),
(69, '1', 31, 72, 94, 4095, '2024-12-20', '10:53:13');

-- --------------------------------------------------------

--
-- Estrutura para tabela `registrologin`
--

CREATE TABLE `registrologin` (
  `idRegistro` int(11) NOT NULL,
  `fkUser` int(11) NOT NULL,
  `DataHoraLogin` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Estrutura para tabela `user`
--

CREATE TABLE `user` (
  `idUser` int(11) NOT NULL,
  `usuario` varchar(40) NOT NULL,
  `senha` varchar(150) NOT NULL,
  `cargo` varchar(50) NOT NULL,
  `criacao` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `email` varchar(150) NOT NULL,
  `telefone` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Índices para tabelas despejadas
--

--
-- Índices de tabela `anotacaodados`
--
ALTER TABLE `anotacaodados`
  ADD PRIMARY KEY (`idAnotacao`);

--
-- Índices de tabela `dadosdosesp`
--
ALTER TABLE `dadosdosesp`
  ADD PRIMARY KEY (`IdDado`);

--
-- Índices de tabela `registrologin`
--
ALTER TABLE `registrologin`
  ADD PRIMARY KEY (`idRegistro`);

--
-- Índices de tabela `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`idUser`);

--
-- AUTO_INCREMENT para tabelas despejadas
--

--
-- AUTO_INCREMENT de tabela `anotacaodados`
--
ALTER TABLE `anotacaodados`
  MODIFY `idAnotacao` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `dadosdosesp`
--
ALTER TABLE `dadosdosesp`
  MODIFY `IdDado` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT de tabela `registrologin`
--
ALTER TABLE `registrologin`
  MODIFY `idRegistro` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de tabela `user`
--
ALTER TABLE `user`
  MODIFY `idUser` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

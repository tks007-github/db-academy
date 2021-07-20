-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 
-- サーバのバージョン： 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `player_management`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `belong`
--

CREATE TABLE `belong` (
  `belong_code` char(1) NOT NULL,
  `belong_name` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `belong`
--

INSERT INTO `belong` (`belong_code`, `belong_name`) VALUES
('A', '新川高校'),
('B', 'D.B.アカデミー');

-- --------------------------------------------------------

--
-- テーブルの構造 `mst_password`
--

CREATE TABLE `mst_password` (
  `id` int(11) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `mst_password`
--

INSERT INTO `mst_password` (`id`, `password`) VALUES
(1, 'aaa');

-- --------------------------------------------------------

--
-- テーブルの構造 `new_id`
--

CREATE TABLE `new_id` (
  `belong_code` char(1) NOT NULL,
  `new_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `new_id`
--

INSERT INTO `new_id` (`belong_code`, `new_id`) VALUES
('A', 2),
('B', 2);

-- --------------------------------------------------------

--
-- テーブルの構造 `phisical_info`
--

CREATE TABLE `phisical_info` (
  `id` int(11) NOT NULL,
  `player_code` char(5) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `height` double NOT NULL,
  `weight` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `phisical_info`
--

INSERT INTO `phisical_info` (`id`, `player_code`, `date`, `height`, `weight`) VALUES
(1, 'A0001', '2021-07-18 15:00:00', 171.5, 60.5),
(2, 'B0001', '2021-07-18 15:00:00', 163, 48.7),
(3, 'A0001', '2021-07-19 15:00:00', 171.5, 61),
(4, 'B0001', '2021-07-19 15:00:00', 163, 48.6),
(5, 'A0001', '2021-07-20 15:00:00', 172, 61),
(6, 'B0001', '2021-07-20 15:00:00', 163, 48.5);

-- --------------------------------------------------------

--
-- テーブルの構造 `phisical_test`
--

CREATE TABLE `phisical_test` (
  `id` int(11) NOT NULL,
  `player_code` char(5) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `50m` double NOT NULL,
  `sidestep` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `phisical_test`
--

INSERT INTO `phisical_test` (`id`, `player_code`, `date`, `50m`, `sidestep`) VALUES
(1, 'A0001', '2021-06-01 15:00:00', 6.8, 50),
(2, 'B0001', '2021-06-01 15:00:00', 7.5, 40),
(3, 'B0001', '2021-07-06 15:00:00', 7.5, 42),
(4, 'A0001', '2021-07-06 15:00:00', 6.9, 53);

-- --------------------------------------------------------

--
-- テーブルの構造 `player`
--

CREATE TABLE `player` (
  `player_code` char(5) NOT NULL,
  `player_name` varchar(60) NOT NULL,
  `player_password` varchar(255) NOT NULL,
  `belong_code` char(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `player`
--

INSERT INTO `player` (`player_code`, `player_name`, `player_password`, `belong_code`) VALUES
('A0001', '山田太郎', 'aaa', 'A'),
('B0001', '鈴木一郎', 'bbb', 'B');

-- --------------------------------------------------------

--
-- テーブルの構造 `questionnaire`
--

CREATE TABLE `questionnaire` (
  `id` int(11) NOT NULL,
  `player_code` char(5) NOT NULL,
  `injury` text NOT NULL,
  `allergies` text NOT NULL,
  `sick` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `questionnaire`
--

INSERT INTO `questionnaire` (`id`, `player_code`, `injury`, `allergies`, `sick`) VALUES
(1, 'A0001', '', 'そばアレルギー', '喘息'),
(2, 'B0001', '右腕骨折', '', '');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `belong`
--
ALTER TABLE `belong`
  ADD PRIMARY KEY (`belong_code`);

--
-- Indexes for table `mst_password`
--
ALTER TABLE `mst_password`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `new_id`
--
ALTER TABLE `new_id`
  ADD PRIMARY KEY (`belong_code`);

--
-- Indexes for table `phisical_info`
--
ALTER TABLE `phisical_info`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `phisical_test`
--
ALTER TABLE `phisical_test`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`player_code`);

--
-- Indexes for table `questionnaire`
--
ALTER TABLE `questionnaire`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `phisical_info`
--
ALTER TABLE `phisical_info`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `phisical_test`
--
ALTER TABLE `phisical_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `questionnaire`
--
ALTER TABLE `questionnaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

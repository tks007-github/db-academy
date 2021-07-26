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
-- テーブルの構造 `manager`
--

CREATE TABLE `manager` (
  `manager_code` char(5) NOT NULL,
  `manager_name` varchar(60) NOT NULL,
  `manager_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `manager`
--

INSERT INTO `manager` (`manager_code`, `manager_name`, `manager_password`) VALUES
('M1', '管理者', 'aaa');

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
  `date` date NOT NULL,
  `height` double NOT NULL,
  `weight` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `phisical_info`
--

INSERT INTO `phisical_info` (`id`, `player_code`, `date`, `height`, `weight`) VALUES
(1, 'A1', '2021-07-07', 171.5, 60.5),
(3, 'A1', '2021-07-14', 171.5, 60),
(5, 'A1', '2021-07-21', 171.5, 61);

-- --------------------------------------------------------

--
-- テーブルの構造 `phisical_test`
--

CREATE TABLE `phisical_test` (
  `id` int(11) NOT NULL,
  `player_code` char(5) NOT NULL,
  `date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `test1` double NOT NULL,
  `test2` double NOT NULL,
  `test3` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `phisical_test`
--

INSERT INTO `phisical_test` (`id`, `player_code`, `date`, `test1`, `test2`, `test3`) VALUES
(1, 'A0001', '2021-06-01 15:00:00', 6.8, 50, 0),
(2, 'B0001', '2021-06-01 15:00:00', 7.5, 40, 0),
(3, 'B0001', '2021-07-06 15:00:00', 7.5, 42, 0),
(4, 'A0001', '2021-07-06 15:00:00', 6.9, 53, 0);

-- --------------------------------------------------------

--
-- テーブルの構造 `phisical_test_item`
--

CREATE TABLE `phisical_test_item` (
  `test_code` varchar(20) NOT NULL,
  `test_value` varchar(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `phisical_test_item`
--

INSERT INTO `phisical_test_item` (`test_code`, `test_value`) VALUES
('test1', '50m走'),
('test2', 'サイドステップ');

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
('A1', '山田太郎', 'aaa', 'A'),
('B1', '鈴木一郎', 'bbb', 'B');

-- --------------------------------------------------------

--
-- テーブルの構造 `questionnaire`
--

CREATE TABLE `questionnaire` (
  `id` int(11) NOT NULL,
  `player_code` char(5) NOT NULL,
  `item_code` int(11) NOT NULL,
  `num` int(11) NOT NULL,
  `name` varchar(60) NOT NULL,
  `status_code` int(11) NOT NULL,
  `year` int(11) NOT NULL,
  `month` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `questionnaire`
--

INSERT INTO `questionnaire` (`id`, `player_code`, `item_code`, `num`, `name`, `status_code`, `year`, `month`) VALUES
(1, 'A1', 1, 1, '右腕骨折', 1, 2019, 4),
(2, 'A1', 1, 2, '左肩脱臼', 2, 2021, 6),
(3, 'A1', 2, 1, 'なし', 0, 0, 0),
(4, 'A1', 2, 2, 'なし', 0, 0, 0),
(5, 'A1', 3, 1, '喘息', 2, 2020, 11),
(6, 'A1', 3, 2, 'なし', 0, 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `belong`
--
ALTER TABLE `belong`
  ADD PRIMARY KEY (`belong_code`);

--
-- Indexes for table `manager`
--
ALTER TABLE `manager`
  ADD PRIMARY KEY (`manager_code`);

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
-- Indexes for table `phisical_test_item`
--
ALTER TABLE `phisical_test_item`
  ADD PRIMARY KEY (`test_code`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `phisical_test`
--
ALTER TABLE `phisical_test`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `questionnaire`
--
ALTER TABLE `questionnaire`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

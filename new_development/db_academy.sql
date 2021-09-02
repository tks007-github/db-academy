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
-- Database: `db_academy`
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
-- テーブルの構造 `coach`
--

CREATE TABLE `coach` (
  `coach_code` char(5) NOT NULL,
  `coach_name` varchar(60) NOT NULL,
  `coach_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `coach`
--

INSERT INTO `coach` (`coach_code`, `coach_name`, `coach_password`) VALUES
('C0001', '管理者', '9df62e693988eb4e1e1444ece0578579');

-- --------------------------------------------------------

--
-- テーブルの構造 `mst_password`
--

CREATE TABLE `mst_password` (
  `mst_code` int(11) NOT NULL,
  `mst_password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `mst_password`
--

INSERT INTO `mst_password` (`mst_code`, `mst_password`) VALUES
(1, 'f561aaf6ef0bf14d4208bb46a4ccb3ad');

-- --------------------------------------------------------

--
-- テーブルの構造 `new_coach_code`
--

CREATE TABLE `new_coach_code` (
  `new_coach_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `new_coach_code`
--

INSERT INTO `new_coach_code` (`new_coach_code`) VALUES
(2);

-- --------------------------------------------------------

--
-- テーブルの構造 `new_player_code`
--

CREATE TABLE `new_player_code` (
  `belong_code` char(1) NOT NULL,
  `new_player_code` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `new_player_code`
--

INSERT INTO `new_player_code` (`belong_code`, `new_player_code`) VALUES
('A', 1),
('B', 1);

-- --------------------------------------------------------

--
-- テーブルの構造 `phisical_info`
--

CREATE TABLE `phisical_info` (
  `phisical_info_code` int(11) NOT NULL,
  `player_code` char(5) NOT NULL,
  `date` date NOT NULL,
  `height` double NOT NULL,
  `weight` double NOT NULL,
  `body_fat` double NOT NULL,
  `muscle_mass` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `phisical_test`
--

CREATE TABLE `phisical_test` (
  `phisical_test_code` int(11) NOT NULL,
  `belong_code` char(1) NOT NULL,
  `date` date NOT NULL,
  `10m走` tinyint(1) NOT NULL,
  `20m走` tinyint(1) NOT NULL,
  `30m走` tinyint(1) NOT NULL,
  `50m走` tinyint(1) NOT NULL,
  `1500m走` tinyint(1) NOT NULL,
  `プロアジリティ` tinyint(1) NOT NULL,
  `立ち幅跳び` tinyint(1) NOT NULL,
  `メディシンボール投げ` tinyint(1) NOT NULL,
  `垂直飛び` tinyint(1) NOT NULL,
  `背筋力` tinyint(1) NOT NULL,
  `握力` tinyint(1) NOT NULL,
  `サイドステップ` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- テーブルの構造 `phisical_test_record`
--

CREATE TABLE `phisical_test_record` (
  `phisical_test_record_code` int(11) NOT NULL,
  `player_code` char(5) NOT NULL,
  `date` date NOT NULL,
  `10m走` double NOT NULL,
  `20m走` double NOT NULL,
  `30m走` double NOT NULL,
  `50m走` double NOT NULL,
  `1500m走_min` double NOT NULL,
  `1500m走_sec` int(11) NOT NULL,
  `プロアジリティ` double NOT NULL,
  `立ち幅跳び` int(11) NOT NULL,
  `メディシンボール投げ` double NOT NULL,
  `垂直飛び` int(11) NOT NULL,
  `背筋力` int(11) NOT NULL,
  `握力` int(11) NOT NULL,
  `サイドステップ` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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

-- --------------------------------------------------------

--
-- テーブルの構造 `questionnaire`
--

CREATE TABLE `questionnaire` (
  `questionnaire_code` int(11) NOT NULL,
  `player_code` char(5) NOT NULL,
  `injury1_name` varchar(60) NOT NULL,
  `injury1_status` char(3) NOT NULL,
  `injury1_year` int(11) NOT NULL,
  `injury1_month` int(11) NOT NULL,
  `injury2_name` varchar(60) NOT NULL,
  `injury2_status` char(3) NOT NULL,
  `injury2_year` int(11) NOT NULL,
  `injury2_month` int(11) NOT NULL,
  `injury3_name` varchar(60) NOT NULL,
  `injury3_status` char(3) NOT NULL,
  `injury3_year` int(11) NOT NULL,
  `injury3_month` int(11) NOT NULL,
  `injury4_name` varchar(60) NOT NULL,
  `injury4_status` char(3) NOT NULL,
  `injury4_year` int(11) NOT NULL,
  `injury4_month` int(11) NOT NULL,
  `injury5_name` varchar(60) NOT NULL,
  `injury5_status` char(3) NOT NULL,
  `injury5_year` int(11) NOT NULL,
  `injury5_month` int(11) NOT NULL,
  `injury6_name` varchar(60) NOT NULL,
  `injury6_status` char(3) NOT NULL,
  `injury6_year` int(11) NOT NULL,
  `injury6_month` int(11) NOT NULL,
  `injury7_name` varchar(60) NOT NULL,
  `injury7_status` char(3) NOT NULL,
  `injury7_year` int(11) NOT NULL,
  `injury7_month` int(11) NOT NULL,
  `injury8_name` varchar(60) NOT NULL,
  `injury8_status` char(3) NOT NULL,
  `injury8_year` int(11) NOT NULL,
  `injury8_month` int(11) NOT NULL,
  `injury9_name` varchar(60) NOT NULL,
  `injury9_status` char(3) NOT NULL,
  `injury9_year` int(11) NOT NULL,
  `injury9_month` int(11) NOT NULL,
  `injury10_name` varchar(60) NOT NULL,
  `injury10_status` char(3) NOT NULL,
  `injury10_year` int(11) NOT NULL,
  `injury10_month` int(11) NOT NULL,
  `allergy1_name` varchar(60) NOT NULL,
  `allergy1_status` char(3) NOT NULL,
  `allergy1_year` int(11) NOT NULL,
  `allergy1_month` int(11) NOT NULL,
  `allergy2_name` varchar(60) NOT NULL,
  `allergy2_status` char(3) NOT NULL,
  `allergy2_year` int(11) NOT NULL,
  `allergy2_month` int(11) NOT NULL,
  `allergy3_name` varchar(60) NOT NULL,
  `allergy3_status` char(3) NOT NULL,
  `allergy3_year` int(11) NOT NULL,
  `allergy3_month` int(11) NOT NULL,
  `allergy4_name` varchar(60) NOT NULL,
  `allergy4_status` char(3) NOT NULL,
  `allergy4_year` int(11) NOT NULL,
  `allergy4_month` int(11) NOT NULL,
  `allergy5_name` varchar(60) NOT NULL,
  `allergy5_status` char(3) NOT NULL,
  `allergy5_year` int(11) NOT NULL,
  `allergy5_month` int(11) NOT NULL,
  `sick1_name` varchar(60) NOT NULL,
  `sick1_status` char(3) NOT NULL,
  `sick1_year` int(11) NOT NULL,
  `sick1_month` int(11) NOT NULL,
  `sick2_name` varchar(60) NOT NULL,
  `sick2_status` char(3) NOT NULL,
  `sick2_year` int(11) NOT NULL,
  `sick2_month` int(11) NOT NULL,
  `sick3_name` varchar(60) NOT NULL,
  `sick3_status` char(3) NOT NULL,
  `sick3_year` int(11) NOT NULL,
  `sick3_month` int(11) NOT NULL,
  `sick4_name` varchar(60) NOT NULL,
  `sick4_status` char(3) NOT NULL,
  `sick4_year` int(11) NOT NULL,
  `sick4_month` int(11) NOT NULL,
  `sick5_name` varchar(60) NOT NULL,
  `sick5_status` char(3) NOT NULL,
  `sick5_year` int(11) NOT NULL,
  `sick5_month` int(11) NOT NULL,
  `note` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `belong`
--
ALTER TABLE `belong`
  ADD PRIMARY KEY (`belong_code`);

--
-- Indexes for table `coach`
--
ALTER TABLE `coach`
  ADD PRIMARY KEY (`coach_code`);

--
-- Indexes for table `mst_password`
--
ALTER TABLE `mst_password`
  ADD PRIMARY KEY (`mst_code`);

--
-- Indexes for table `new_player_code`
--
ALTER TABLE `new_player_code`
  ADD PRIMARY KEY (`belong_code`);

--
-- Indexes for table `phisical_info`
--
ALTER TABLE `phisical_info`
  ADD PRIMARY KEY (`phisical_info_code`);

--
-- Indexes for table `phisical_test`
--
ALTER TABLE `phisical_test`
  ADD PRIMARY KEY (`phisical_test_code`);

--
-- Indexes for table `phisical_test_record`
--
ALTER TABLE `phisical_test_record`
  ADD PRIMARY KEY (`phisical_test_record_code`);

--
-- Indexes for table `player`
--
ALTER TABLE `player`
  ADD PRIMARY KEY (`player_code`);

--
-- Indexes for table `questionnaire`
--
ALTER TABLE `questionnaire`
  ADD PRIMARY KEY (`questionnaire_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `mst_password`
--
ALTER TABLE `mst_password`
  MODIFY `mst_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `phisical_info`
--
ALTER TABLE `phisical_info`
  MODIFY `phisical_info_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `phisical_test`
--
ALTER TABLE `phisical_test`
  MODIFY `phisical_test_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `phisical_test_record`
--
ALTER TABLE `phisical_test_record`
  MODIFY `phisical_test_record_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `questionnaire`
--
ALTER TABLE `questionnaire`
  MODIFY `questionnaire_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

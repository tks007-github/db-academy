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
('A', 2),
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

--
-- テーブルのデータのダンプ `phisical_info`
--

INSERT INTO `phisical_info` (`phisical_info_code`, `player_code`, `date`, `height`, `weight`, `body_fat`, `muscle_mass`) VALUES
(10, 'A0001', '2020-04-01', 170, 60, 15, 45),
(11, 'A0001', '2020-05-06', 170, 60, 15, 45),
(12, 'A0001', '2020-06-03', 170, 60, 15, 45),
(13, 'A0001', '2020-07-01', 170, 60, 15, 45),
(14, 'A0001', '2020-08-05', 170, 60, 15, 45),
(15, 'A0001', '2020-09-02', 170, 60, 15, 45),
(16, 'A0001', '2020-10-07', 170, 60, 15, 45),
(17, 'A0001', '2020-11-04', 170, 60, 15, 45),
(18, 'A0001', '2020-12-02', 170, 60, 15, 45),
(19, 'A0001', '2021-01-06', 170, 60, 15, 45),
(20, 'A0001', '2021-02-03', 170, 60, 15, 45),
(21, 'A0001', '2021-03-03', 170, 60, 15, 45),
(22, 'A0001', '2021-04-07', 175, 65, 18, 50),
(23, 'A0001', '2021-05-05', 175, 65, 18, 50),
(24, 'A0001', '2021-06-02', 175, 65, 18, 50),
(25, 'A0001', '2021-07-07', 175, 65, 18, 50),
(26, 'A0001', '2021-08-04', 175, 65, 18, 50);

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

--
-- テーブルのデータのダンプ `phisical_test`
--

INSERT INTO `phisical_test` (`phisical_test_code`, `belong_code`, `date`, `10m走`, `20m走`, `30m走`, `50m走`, `1500m走`, `プロアジリティ`, `立ち幅跳び`, `メディシンボール投げ`, `垂直飛び`, `背筋力`, `握力`, `サイドステップ`) VALUES
(15, 'A', '2021-08-04', 1, 1, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0),
(16, 'A', '2021-07-07', 0, 0, 0, 0, 0, 1, 1, 1, 1, 1, 1, 1),
(17, 'A', '2021-06-02', 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1);

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

--
-- テーブルのデータのダンプ `phisical_test_record`
--

INSERT INTO `phisical_test_record` (`phisical_test_record_code`, `player_code`, `date`, `10m走`, `20m走`, `30m走`, `50m走`, `1500m走_min`, `1500m走_sec`, `プロアジリティ`, `立ち幅跳び`, `メディシンボール投げ`, `垂直飛び`, `背筋力`, `握力`, `サイドステップ`) VALUES
(4, 'A0001', '2021-06-02', 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3, 3),
(5, 'A0001', '2021-08-04', 7, 7, 7, 7, 7, 7, 0, 0, 0, 0, 0, 0, 0),
(6, 'A0001', '2021-07-07', 0, 0, 0, 0, 0, 0, 5, 5, 5, 5, 5, 5, 5);

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
('A0001', '山田太郎', '47bce5c74f589f4867dbd57e9ca9f808', 'A');

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
-- テーブルのデータのダンプ `questionnaire`
--

INSERT INTO `questionnaire` (`questionnaire_code`, `player_code`, `injury1_name`, `injury1_status`, `injury1_year`, `injury1_month`, `injury2_name`, `injury2_status`, `injury2_year`, `injury2_month`, `injury3_name`, `injury3_status`, `injury3_year`, `injury3_month`, `injury4_name`, `injury4_status`, `injury4_year`, `injury4_month`, `injury5_name`, `injury5_status`, `injury5_year`, `injury5_month`, `injury6_name`, `injury6_status`, `injury6_year`, `injury6_month`, `injury7_name`, `injury7_status`, `injury7_year`, `injury7_month`, `injury8_name`, `injury8_status`, `injury8_year`, `injury8_month`, `injury9_name`, `injury9_status`, `injury9_year`, `injury9_month`, `injury10_name`, `injury10_status`, `injury10_year`, `injury10_month`, `allergy1_name`, `allergy1_status`, `allergy1_year`, `allergy1_month`, `allergy2_name`, `allergy2_status`, `allergy2_year`, `allergy2_month`, `allergy3_name`, `allergy3_status`, `allergy3_year`, `allergy3_month`, `allergy4_name`, `allergy4_status`, `allergy4_year`, `allergy4_month`, `allergy5_name`, `allergy5_status`, `allergy5_year`, `allergy5_month`, `sick1_name`, `sick1_status`, `sick1_year`, `sick1_month`, `sick2_name`, `sick2_status`, `sick2_year`, `sick2_month`, `sick3_name`, `sick3_status`, `sick3_year`, `sick3_month`, `sick4_name`, `sick4_status`, `sick4_year`, `sick4_month`, `sick5_name`, `sick5_status`, `sick5_year`, `sick5_month`, `note`) VALUES
(7, 'A0001', '右腕骨折', '治療済', 2014, 3, '', '', 0, 0, '', '', 0, 0, '', '', 0, 0, '', '', 0, 0, '', '', 0, 0, '', '', 0, 0, '', '', 0, 0, '', '', 0, 0, '', '', 0, 0, '', '', 0, 0, '', '', 0, 0, '', '', 0, 0, '', '', 0, 0, '', '', 0, 0, '', '', 0, 0, '', '', 0, 0, '', '', 0, 0, '', '', 0, 0, '', '', 0, 0, '');

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
  MODIFY `phisical_info_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=27;

--
-- AUTO_INCREMENT for table `phisical_test`
--
ALTER TABLE `phisical_test`
  MODIFY `phisical_test_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `phisical_test_record`
--
ALTER TABLE `phisical_test_record`
  MODIFY `phisical_test_record_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `questionnaire`
--
ALTER TABLE `questionnaire`
  MODIFY `questionnaire_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

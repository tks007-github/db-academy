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
-- Indexes for table `questionnaire`
--
ALTER TABLE `questionnaire`
  ADD PRIMARY KEY (`questionnaire_code`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `questionnaire`
--
ALTER TABLE `questionnaire`
  MODIFY `questionnaire_code` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

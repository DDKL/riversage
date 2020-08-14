-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 11, 2020 at 12:34 AM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.2.32

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `Knowledge Base`
--

-- --------------------------------------------------------

--
-- Table structure for table `Diagnostics`
--

CREATE TABLE `KB_Diagnostics` (
	`id` int unsigned not null primary key auto_increment,
  `Title` varchar(255) NOT NULL,
  `Text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Diagnostics`
--

INSERT INTO `KB_Diagnostics` (`Title`, `Text`) VALUES
('', ''),
('Status report of your health.', 'Riversage\'s goal is to prevent and treat disease within a caring community. Understanding your medical history and lifestyle habits will help us develop a diagnostic and treatment plan personalized to you.');

-- --------------------------------------------------------

--
-- Table structure for table `Nutrients`
--

CREATE TABLE `KB_Nutrients` (
	`id` int unsigned not null primary key auto_increment,
  `Title` varchar(255) NOT NULL,
  `Text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Nutrients`
--

INSERT INTO `KB_Nutrients` (`Title`, `Text`) VALUES
('', ''),
('Key ingredients to vitalize you.', 'Find your key nutrients on this page to give your body fuel and energy required to fight off viruses, bacteria, diabetes, weight gain, and more.');

-- --------------------------------------------------------

--
-- Table structure for table `IX`
--

CREATE TABLE `KB_IX` (
  `id` int(1) NOT NULL,
  `Category` varchar(2) NOT NULL,
  `What` text NOT NULL,
  `Why` text NOT NULL,
  `Extra` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `IX`
--

INSERT INTO `KB_IX` (`id`, `Category`, `What`, `Why`, `Extra`) VALUES
(2, 'R2', 'R2, when taken with R1, provides superior nutrients support for the most common biological imbalances through prevention, management, and reversal.', 'Traditionally, we visit our doctors when we feel sick or to have an illness treated. Sometimes, these treatments can cost up to $10,000. But what if it was possible to prevent these illnesses from taking over our bodies and our wallets? In fact, it is possible - we have discovered 10 underlying biological imbalances that contribute to illnesses. When one of these imbalances spin out of control, diseases become severe enough for you to consider visiting the hospital to have it treated. Use our surveys and our consultation services and diagnostics to determine which imbalance needs to be addressed before it\'s too late. Our R2 framework is designed with detail to provide you products that will aid in this journey.', 'What are the imbalances? (show imbalances)'),
(3, 'R3', 'R3, to be taken with R1 and R2, fulfills health goals which attribute to superior biological function. It also provides nutrients support and levers of actions to address health conditions.', 'These supplements contains a unique blend of ingredients that work together that help your body to build collagen and repair in building joint pain, help with muscle recovery and strengthening of corrective tissue.', ''),
(1, 'R1', 'R1 is your recommended daily allowance. Your age and your gender determine which products best fill the nutritional gap to maintain optimal health and fight off harmful antigens.', 'Maintains general wellbeing of the body, giving it the foundation it needs to survive and thrive. Without this, your body will lack the basic nutrients needs to support itself on a daily basis, enabling harmful foreign agents to easily penetrate through your body\'s weakened defense barrier. However, with R1, the nutrients found in this set of products will replenish and reinforce your body with the defense it needs to survive.', 'What products are offered? (products shown)'),
(4, 'R4', 'R4 is the most popular, efficient, and effective offering in RiverSage. Taken with R1, R2, and R3, R4 offers a completely personalized roadmap of nutrients support for diseases treatment and health conditions.', 'Some people will come in with a disease state such as diabetes and need supplements that target that area and supports the clinical manifestations of that disease.', '');

-- --------------------------------------------------------

--
-- Table structure for table `Roadmap`
--

CREATE TABLE `KB_Roadmap` (
	`id` int unsigned not null primary key auto_increment,
  `Title` varchar(255) NOT NULL,
  `Text` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `Roadmap`
--

INSERT INTO `KB_Roadmap` (`Title`, `Text`) VALUES
('Begin a new chapter in your life.', 'In our clinic located in Anaheim, we also provide further diagnosis with the support of our advanced technologies, such as the Menla Scan or EvoX in order to measure and identify biochemical imbalances your body may be dealing with.');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

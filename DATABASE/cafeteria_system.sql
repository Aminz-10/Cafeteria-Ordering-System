-- phpMyAdmin SQL Dump
-- version 3.2.4
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 09, 2021 at 12:38 PM
-- Server version: 5.1.41
-- PHP Version: 5.3.1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `cafeteria_system`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `a_id` varchar(14) NOT NULL,
  `a_name` varchar(50) NOT NULL,
  `a_phone` varchar(12) NOT NULL,
  `a_pass` varchar(12) NOT NULL,
  `a_categoryid` int(10) NOT NULL,
  PRIMARY KEY (`a_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`a_id`, `a_name`, `a_phone`, `a_pass`, `a_categoryid`) VALUES
('PertamaPuo', 'Gerai Pertama', '0174436191', '@Admin123', 1),
('KeduaPuo', 'Gerai Kedua', '0171136191', '@Admin123', 2),
('ketigaPuo', 'Gerai Ketiga', '0171136699', '@Admin123', 3);

-- --------------------------------------------------------

--
-- Table structure for table `cafeteria`
--

CREATE TABLE IF NOT EXISTS `cafeteria` (
  `menu_id` varchar(10) NOT NULL,
  `categoryid` int(10) NOT NULL,
  `menu_photo` varchar(300) NOT NULL,
  `menu_name` varchar(30) NOT NULL,
  `menu_price` decimal(5,2) NOT NULL,
  `menu_status` int(10) NOT NULL DEFAULT '1',
  PRIMARY KEY (`menu_id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `cafeteria`
--

INSERT INTO `cafeteria` (`menu_id`, `categoryid`, `menu_photo`, `menu_name`, `menu_price`, `menu_status`) VALUES
('ABU01', 1, 'upload/nasiayam.png', 'Nasi ayam', '6.50', 1),
('ABU02', 1, 'upload/nasilemak.PNG', 'Nasi Lemak', '2.50', 1),
('ABU03', 1, 'upload/roticanai.PNG', 'Roti Canai', '1.50', 1),
('ABU05', 1, 'upload/bihunsoto.jpg', 'Bihun Soto', '4.00', 1),
('ABU04', 1, 'upload/bihungoreng.png', 'Bihun Goreng', '3.50', 1),
('ABU06', 1, 'upload/char.png', 'Char Kuew Teow', '3.50', 1),
('ABU07', 1, 'upload/ChickenChop.png', 'Chicken Chop', '5.00', 1),
('ABU08', 1, 'upload/kalori-bubur-daging.jpg', 'Kalori Bubur Daging', '5.00', 1),
('ABU09', 1, 'upload/KueyTeowKungfu.png', 'Kuey Teow Kungfu', '4.00', 1),
('ABU10', 1, 'upload/KueyTeowLadna.png', 'Kuey Teow Ladna', '4.50', 1),
('DH01', 2, 'upload/MacaroniCarbonara.png', 'Macaroni Carbonara', '5.00', 1),
('DH02', 2, 'upload/MakaroniCheeseGoreng.png', 'Makaroni Cheese Goreng', '4.00', 1),
('DH03', 2, 'upload/MeeBandung.png', 'Mee Bandung', '3.50', 1),
('DH04', 2, 'upload/meegorengmamak.png', 'Mee Goreng Mamak', '3.50', 1),
('DH05', 2, 'upload/MeeSupDaging.png', 'Mee Sup Daging', '5.00', 1),
('DH06', 2, 'upload/MihunGorengTomyam.png', 'Mihun Goreng Tomyam', '5.00', 1),
('DH07', 2, 'upload/nasibriyani.png', 'Nasi Briyani', '5.50', 1),
('DH08', 2, 'upload/nasidagang.png', 'Nasi Dagang', '6.00', 1),
('DH09', 2, 'upload/NasiGorengCina.png', 'Nasi Goreng Cina', '4.00', 1),
('DH10', 2, 'upload/NasiGorengPattaya.png', 'Nasi Goreng Pattaya', '5.50', 1),
('GB01', 3, 'upload/NasiGorengSardin.png', 'Nasi Goreng Sardin', '4.50', 1),
('GB02', 3, 'upload/NasiGorengSeafoodSpecial.png', 'Nasi Goreng Seafood Special', '6.50', 1),
('GB03', 3, 'upload/NasiGorengThai.png', 'Nasi Goreng Thai', '4.50', 1),
('GB04', 3, 'upload/nasikandar.png', 'Nasi kandar', '6.00', 1),
('GB05', 3, 'upload/SpagettiGoreng.png', 'Spagetti Goreng', '4.00', 1),
('GB06', 3, 'upload/SpagettiBolognese.png', 'Spagetti Bolognese', '4.50', 1),
('GB07', 3, 'upload/SpagettiAglioOlio.png', 'Spagetti Aglio Olio', '4.50', 1),
('GB08', 3, 'upload/ResepiNasiGorengHawaii.png', 'Resepi Nasi Goreng Hawaii', '5.50', 1),
('GB09', 3, 'upload/PenangCharKueyTeow.png', 'Penang Char Kuey Teow', '4.00', 1),
('GB10', 3, 'upload/ChickenChop.png', 'Chicken Chop', '5.50', 1);

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE IF NOT EXISTS `category` (
  `categoryid` int(10) NOT NULL,
  `gerai` varchar(100) NOT NULL,
  PRIMARY KEY (`categoryid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryid`, `gerai`) VALUES
(1, 'GERAIÂ SENTOSA'),
(2, 'GERAIÂ SERI'),
(3, 'GERAIÂ SELERA');

-- --------------------------------------------------------

--
-- Table structure for table `customer`
--

CREATE TABLE IF NOT EXISTS `customer` (
  `s_matric` varchar(12) NOT NULL,
  `s_name` varchar(50) NOT NULL,
  `s_email` text NOT NULL,
  `s_phone` varchar(12) NOT NULL,
  `s_bilik` varchar(100) NOT NULL,
  `s_year` year(4) NOT NULL,
  `s_pass` varchar(14) NOT NULL,
  PRIMARY KEY (`s_matric`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customer`
--

INSERT INTO `customer` (`s_matric`, `s_name`, `s_email`, `s_phone`, `s_bilik`, `s_year`, `s_pass`) VALUES
('01DDT19F1080', 'Mohamad Amirul Amin', 'aamirul242@gmail.com', '158-30534', 'M-A1-3', 2020, '@Amin123');

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE IF NOT EXISTS `feedback` (
  `no` int(100) NOT NULL AUTO_INCREMENT,
  `s_matric` varchar(14) NOT NULL,
  `categoryid` int(5) NOT NULL,
  `s_feed` varchar(300) NOT NULL,
  PRIMARY KEY (`no`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`no`, `s_matric`, `categoryid`, `s_feed`) VALUES
(1, '01DDT19F1080', 1, 'mantap');

-- --------------------------------------------------------

--
-- Table structure for table `ordering`
--

CREATE TABLE IF NOT EXISTS `ordering` (
  `order_no` int(2) NOT NULL AUTO_INCREMENT,
  `s_matric` varchar(12) NOT NULL,
  `menu_id` varchar(10) NOT NULL,
  `quantity` int(100) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `order_status` varchar(100) NOT NULL DEFAULT 'NEW.jpg',
  `order_note` varchar(30) DEFAULT NULL,
  `order_price` decimal(10,2) DEFAULT NULL,
  PRIMARY KEY (`order_no`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=46 ;

--
-- Dumping data for table `ordering`
--

INSERT INTO `ordering` (`order_no`, `s_matric`, `menu_id`, `quantity`, `date`, `time`, `order_status`, `order_note`, `order_price`) VALUES
(45, '01DDT19F1080', 'ABU10', 2, '2021-09-02', '06:56:00', 'NEW.jpg', 'tiada', '9.00'),
(44, '01DDT19F1080', 'ABU10', 1, '2021-09-02', '04:31:00', 'FINISHED.jpg', 'tiada', '4.50'),
(43, '01DDT19F1080', 'ABU05', 1, '2021-09-02', '08:15:00', 'NEW.jpg', 'tiada', '4.00'),
(42, '01DDT19F1080', 'ABU10', 1, '2021-09-02', '07:41:00', 'NEW.jpg', 'tiada', '4.50'),
(41, '01DDT19F1080', 'ABU08', 1, '2021-09-02', '12:38:00', 'NEW.jpg', 'kari bnyk kit', '5.00'),
(40, '01DDT19F1080', 'ABU07', 1, '2021-09-01', '02:55:00', 'TAKEN.png', 'tiada', '5.00'),
(39, '01DDT19F1080', 'ABU03', 1, '2021-09-01', '02:55:00', 'NEW.jpg', 'tiada', '1.50'),
(38, '01DDT19F1080', 'ABU01', 1, '2021-09-01', '02:54:00', 'FINISHED.jpg', 'tiada', '6.50'),
(37, '01DDT19F1080', 'ABU01', 2, '2021-08-30', '08:18:00', 'TAKEN.png', 'TIADA', '13.00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

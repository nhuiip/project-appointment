-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 30, 2019 at 06:55 PM
-- Server version: 10.3.16-MariaDB
-- PHP Version: 7.2.20

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `appointment_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `tb_student`
--

CREATE TABLE `tb_student` (
  `std_id` int(11) NOT NULL,
  `position_id` int(5) NOT NULL DEFAULT 4 COMMENT 'Default = 4',
  `sub_id` int(11) NOT NULL,
  `std_img` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'รูปโปรไฟล์',
  `std_number` varchar(15) COLLATE utf8_unicode_ci NOT NULL COMMENT 'รหัสนักศึกษา',
  `std_title` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'คำนำหน้า',
  `std_fname` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ชื่อ',
  `std_lname` varchar(100) COLLATE utf8_unicode_ci NOT NULL COMMENT 'นามสกุล',
  `std_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `std_emailchang` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `std_pass` text COLLATE utf8_unicode_ci NOT NULL,
  `std_tel` varchar(10) COLLATE utf8_unicode_ci NOT NULL COMMENT 'เบอร์โทรเก็บแค่เลข 10 ตัว',
  `std_checkmail` int(1) NOT NULL COMMENT '0: ยังไม่ยืนยันอีเมล, 1: ยืนยันอีเมลแล้ว',
  `std_status` int(1) NOT NULL COMMENT '0: ยังไม่จบ, 1: จบแล้ว',
  `std_lastlogin` datetime NOT NULL,
  `std_create_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `std_create_date` datetime NOT NULL,
  `std_lastedit_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `std_lastedit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ตารางนักศึกษา';

--
-- Dumping data for table `tb_student`
--

INSERT INTO `tb_student` (`std_id`, `position_id`, `sub_id`, `std_img`, `std_number`, `std_title`, `std_fname`, `std_lname`, `std_email`, `std_emailchang`, `std_pass`, `std_tel`, `std_checkmail`, `std_status`, `std_lastlogin`, `std_create_name`, `std_create_date`, `std_lastedit_name`, `std_lastedit_date`) VALUES
(1, 4, 1, '2571031441142.png', '2571031441142', 'นางสาว', 'นภัสสร', 'ศรีจันทร์', 'yui.napassorn.s1@gmail.com', '', '7c0309b1b16d7152918be17e3c57c5be', '0950189167', 1, 0, '2019-09-30 23:39:38', 'system', '2019-09-19 00:00:00', 'นภัสสร1 ศรีจันทร์', '2019-09-30 23:43:54'),
(3, 4, 1, '2571031441150.png', '2571031441150', 'นางสาว', 'ปรีดารัตน์', 'จุทอง', 'test2@gmail.com', '', '7c0309b1b16d7152918be17e3c57c5be', '0950189167', 0, 0, '2019-09-22 17:06:58', 'system', '2019-09-19 00:00:00', 'นภัสสร ศรีจันทร์', '2019-09-28 14:28:36'),
(10, 4, 1, '2571031441150.png', '2571031441148', 'นาย', 'ประติมากร', 'ทองเพ็ชร', 'test2@gmail.com', '', '7c0309b1b16d7152918be17e3c57c5be', '0950189167', 0, 0, '2019-09-22 17:06:58', 'system', '2019-09-19 00:00:00', 'นภัสสร ศรีจันทร์', '2019-09-28 14:28:36'),
(11, 4, 1, '2571031441150.png', '2571031441138', 'นางสาว', 'กัณฐิกา', 'ศิริบรรณพิทักษ์', 'test3@gmail.com', '', '7c0309b1b16d7152918be17e3c57c5be', '0950189167', 0, 0, '2019-09-22 17:06:58', 'system', '2019-09-19 00:00:00', 'นภัสสร ศรีจันทร์', '2019-09-28 14:28:36');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_student`
--
ALTER TABLE `tb_student`
  ADD PRIMARY KEY (`std_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_student`
--
ALTER TABLE `tb_student`
  MODIFY `std_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

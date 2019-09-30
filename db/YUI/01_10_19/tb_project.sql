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
-- Table structure for table `tb_project`
--

CREATE TABLE `tb_project` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `use_id` int(5) NOT NULL COMMENT 'ไอดีอาจารย์ที่ปรึกษา',
  `std_id` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ไอดีนักศึกษาเก็บค่าเป็น array',
  `project_status` int(1) NOT NULL COMMENT '1:ยังไม่สอบโปรเจคหนึ่ง, 2: ผ่านโปรเจคหนึ่ง, 3: สอบโปรเจคสองแล้วติดแก้ไข, 4: สอบโปรเจคสองผ่าน, 0: ยกเลิกโปรเจค',
  `project_filecov` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_filecer` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_fileabs` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_fileack` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_filetbc` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_filechone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_filechtwo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_filechthree` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_filechfour` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_filechfive` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_fileref` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_fileappone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_fileapptwo` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_filebio` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_create_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_create_date` datetime NOT NULL,
  `project_lastedit_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `project_lastedit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ตารางโปรเจค';

--
-- Dumping data for table `tb_project`
--

INSERT INTO `tb_project` (`project_id`, `project_name`, `use_id`, `std_id`, `project_status`, `project_filecov`, `project_filecer`, `project_fileabs`, `project_fileack`, `project_filetbc`, `project_filechone`, `project_filechtwo`, `project_filechthree`, `project_filechfour`, `project_filechfive`, `project_fileref`, `project_fileappone`, `project_fileapptwo`, `project_filebio`, `project_create_name`, `project_create_date`, `project_lastedit_name`, `project_lastedit_date`) VALUES
(1, 'OTOP MALL', 11, '1,3', 0, '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'นภัสสร ศรีจันทร์', '2019-09-30 20:05:27', 'นภัสสร ศรีจันทร์', '2019-09-30 20:05:41'),
(2, 'ระบบจองคิวสอบโปรเจคออนไลน์', 4, '1,3', 1, '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'นภัสสร ศรีจันทร์', '2019-09-30 20:06:03', 'นภัสสร ศรีจันทร์', '2019-09-30 20:06:03'),
(3, 'ระบบบริหารจัดการร้านค้า', 4, '10', 3, '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'นภัสสร ศรีจันทร์', '2019-09-30 20:06:03', 'นภัสสร ศรีจันทร์', '2019-09-30 20:06:03'),
(5, 'แอพกายภาพบำบัด', 4, '11', 2, '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'นภัสสร ศรีจันทร์', '2019-09-30 20:06:03', 'นภัสสร ศรีจันทร์', '2019-09-30 20:06:03');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_project`
--
ALTER TABLE `tb_project`
  ADD PRIMARY KEY (`project_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_project`
--
ALTER TABLE `tb_project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 30, 2019 at 07:02 PM
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
-- Table structure for table `tb_user`
--

CREATE TABLE `tb_user` (
  `use_id` int(5) NOT NULL,
  `use_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `use_email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `use_pass` text COLLATE utf8_unicode_ci NOT NULL,
  `position_id` int(5) NOT NULL,
  `use_lastlogin` datetime NOT NULL,
  `use_create_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `use_create_date` datetime NOT NULL,
  `use_lastedit_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `use_lastedit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ตารางผู้ใช้ (ผู้ดูแลระบบและอาจารย์)';

--
-- Dumping data for table `tb_user`
--

INSERT INTO `tb_user` (`use_id`, `use_name`, `use_email`, `use_pass`, `position_id`, `use_lastlogin`, `use_create_name`, `use_create_date`, `use_lastedit_name`, `use_lastedit_date`) VALUES
(2, 'Napassorn', 'yui.napassorns@gmail.com', '7c0309b1b16d7152918be17e3c57c5be', 3, '2019-09-30 23:54:09', 'System', '2019-09-04 16:06:38', 'System', '2019-09-16 15:46:32'),
(3, 'Preedarat', 'preedarat.jut@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e', 1, '2019-09-04 16:06:38', 'System', '2019-09-04 16:10:43', 'System', '2019-09-04 16:10:43'),
(4, 'วิลาวรรณ  สุขชนะ', 'vilavan@itrmutr.com', 'b4210a7b49431a59c508046f3f19bd56', 2, '0000-00-00 00:00:00', 'System', '2019-09-04 16:39:16', 'System', '2019-09-04 16:39:16'),
(5, 'พิสิฐ พรพงศ์เตชวาณิช', 'phisit@itrmutr.com', 'c549823d4063f3779ca55b7c18ffa4fe', 3, '0000-00-00 00:00:00', 'System', '2019-09-04 20:08:13', 'System', '2019-09-04 20:08:13'),
(6, 'นภารัตน์ ชูไพร', 'napharat@itrmutr.com', 'eaa44e5b234ee526d6d20ef43d38d84b', 3, '0000-00-00 00:00:00', 'System', '2019-09-16 16:20:00', 'System', '2019-09-16 16:20:00'),
(7, 'คมศัลล์ ศรีวิสุทธิ์', 'komsan@itrmutr.com', '3e6c0c6043ac8ba5178f53d953497f7d', 3, '0000-00-00 00:00:00', 'System', '2019-09-16 16:24:54', 'System', '2019-09-16 16:24:54'),
(8, 'สมพร พึ่งสม', 'samaporn@itrmutr.com', 'ab4af557cac224b3f00645189a4893d0', 3, '0000-00-00 00:00:00', 'System', '2019-09-16 16:26:01', 'System', '2019-09-16 16:26:01'),
(9, 'นพศักดิ์ ตันติสัตยานนท์', 'noppasak@itrmutr.com', '58c413d3eab1b7efe765dd3d2d6c510f', 3, '0000-00-00 00:00:00', 'System', '2019-09-16 17:03:33', 'System', '2019-09-16 17:03:33'),
(10, 'เอกรินทร์ วิจิตต์พันธ์', 'ekkarin@itrmutr.com', '6312089867929d6c4ea871b782a4e0dc', 3, '0000-00-00 00:00:00', 'System', '2019-09-16 17:06:05', 'System', '2019-09-16 17:06:05'),
(11, 'วิศรุต  สื่อสุวรรณ', 'wisarut@itrmutr.com', 'd41d8cd98f00b204e9800998ecf8427e', 3, '0000-00-00 00:00:00', 'System', '2019-09-16 17:12:50', 'System', '2019-09-16 17:14:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`use_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `use_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Sep 19, 2019 at 04:20 PM
-- Server version: 10.3.15-MariaDB
-- PHP Version: 7.1.30

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
-- Table structure for table `tb_attached`
--

CREATE TABLE `tb_attached` (
  `att_id` int(11) NOT NULL,
  `att_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ชื่อเอกสารที่แสดงในระบบ',
  `att_filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ชื่อไฟล์',
  `sub_id` int(5) NOT NULL COMMENT 'ไอดีวิชา',
  `att_create_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `att_create_date` datetime NOT NULL,
  `att_lastedit_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `att_lastedit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ตารางเอกสารประจำวิชา';

-- --------------------------------------------------------

--
-- Table structure for table `tb_detailmeet`
--

CREATE TABLE `tb_detailmeet` (
  `dmeet_id` int(11) NOT NULL,
  `meet_id` int(11) NOT NULL COMMENT 'ไอดีนัดหมาย',
  `dmeet_status` int(1) NOT NULL COMMENT 'สถานนะนัดหมาย 0:ไม่สำเร็จ, 1:สำเร็จ',
  `dmeet_field` varchar(25) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ชื่อ sec เวล่ที่ต้องอัพเดต',
  `dmeet_time` int(11) NOT NULL COMMENT 'เวลานัดหมาย'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ตารางรายละเอียดนัดหมาย';

-- --------------------------------------------------------

--
-- Table structure for table `tb_holiday`
--

CREATE TABLE `tb_holiday` (
  `hol_id` int(11) NOT NULL,
  `hol_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'วันหยุด',
  `hol_date` date NOT NULL COMMENT 'วันที่หยุด',
  `set_id` int(11) NOT NULL COMMENT 'ไอดีตั้งค่าระบบ',
  `hol_create_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hol_create_date` datetime NOT NULL,
  `hol_lastedit_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `hol_lastedit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ตารางวันหยุด';

--
-- Dumping data for table `tb_holiday`
--

INSERT INTO `tb_holiday` (`hol_id`, `hol_name`, `hol_date`, `set_id`, `hol_create_name`, `hol_create_date`, `hol_lastedit_name`, `hol_lastedit_date`) VALUES
(1, 'testholiday', '2019-09-13', 5, 'System', '2019-09-11 12:02:29', 'System', '2019-09-11 14:46:52'),
(2, 'testholiday2', '2019-09-16', 5, 'System', '2019-09-11 14:47:17', 'System', '2019-09-11 14:47:17'),
(3, 'testholiday3', '2019-09-23', 5, 'System', '2019-09-11 14:47:29', 'System', '2019-09-11 14:47:29'),
(4, 'testholiday4', '2019-09-24', 5, 'System', '2019-09-11 14:47:49', 'System', '2019-09-11 14:47:49'),
(5, 'testholiday5', '2019-09-27', 5, 'System', '2019-09-11 14:48:09', 'System', '2019-09-11 14:48:09'),
(6, 'testholiday6', '2019-09-30', 5, 'System', '2019-09-14 10:06:36', 'System', '2019-09-14 10:06:36');

-- --------------------------------------------------------

--
-- Table structure for table `tb_meet`
--

CREATE TABLE `tb_meet` (
  `meet_id` int(11) NOT NULL,
  `meet_status` int(1) NOT NULL COMMENT 'สถานนะนัดหมาย 0:ไม่สำเร็จ, 1:สำเร็จ',
  `meet_create_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meet_create_date` datetime NOT NULL,
  `meet_lastedit_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `meet_lastedit_date` datetime NOT NULL,
  `set_id` int(11) NOT NULL COMMENT 'ไอดีตั้งค่าระบบ',
  `project_id` int(11) NOT NULL COMMENT 'ไอดีโปรเจค'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ตารางนัดหมาย';

-- --------------------------------------------------------

--
-- Table structure for table `tb_position`
--

CREATE TABLE `tb_position` (
  `position_id` int(5) NOT NULL,
  `position_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ตารางสิทธิ์การเข้าใช้';

--
-- Dumping data for table `tb_position`
--

INSERT INTO `tb_position` (`position_id`, `position_name`) VALUES
(1, 'ผู้ดูแลระบบ'),
(2, 'หัวหน้าสาขา'),
(3, 'อาจารย์ผู้สอน'),
(4, 'นักศึกษา');

-- --------------------------------------------------------

--
-- Table structure for table `tb_project`
--

CREATE TABLE `tb_project` (
  `project_id` int(11) NOT NULL,
  `project_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `use_id` int(5) NOT NULL COMMENT 'ไอดีอาจารย์ที่ปรึกษา',
  `std_id` int(11) NOT NULL COMMENT 'ไอดีนักศึกษาเก็บค่าเป็น array',
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

-- --------------------------------------------------------

--
-- Table structure for table `tb_section`
--

CREATE TABLE `tb_section` (
  `sec_id` int(11) NOT NULL,
  `sec_date` date NOT NULL COMMENT 'วันที่นัด',
  `sec_one` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'format array : 9.00, 9.00, 0, sec_one | 0: ไม่ว่าง, 1: ว่าง',
  `sec_two` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'format array : 10.00, 10.30, 0, sec_two | 0: ไม่ว่าง, 1: ว่าง',
  `sec_three` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'format array : 11.00, 12.00, 0, sec_three | 0: ไม่ว่าง, 1: ว่าง	',
  `sec_four` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'format array : 13.00, 13.00, 0, sec_four | 0: ไม่ว่าง, 1: ว่าง	',
  `sec_five` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'format array : 14.00, 14.30, 0, sec_five | 0: ไม่ว่าง, 1: ว่าง',
  `sec_six` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'format array : 15.00, 16.00, 0, sec_six | 0: ไม่ว่าง, 1: ว่าง	',
  `use_id` int(5) NOT NULL COMMENT 'ไอดีอาจารย์',
  `set_id` int(11) NOT NULL COMMENT 'ไอดีตั้งค่าระบบปัจจุบัน',
  `sec_create_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sec_create_date` datetime NOT NULL,
  `sec_lastedit_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sec_lastedit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ตารางวันเวลา';

--
-- Dumping data for table `tb_section`
--

INSERT INTO `tb_section` (`sec_id`, `sec_date`, `sec_one`, `sec_two`, `sec_three`, `sec_four`, `sec_five`, `sec_six`, `use_id`, `set_id`, `sec_create_name`, `sec_create_date`, `sec_lastedit_name`, `sec_lastedit_date`) VALUES
(1, '2019-09-10', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 4, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(2, '2019-09-11', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 4, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(3, '2019-09-12', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 4, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(4, '2019-09-14', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 4, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(5, '2019-09-17', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 4, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(6, '2019-09-18', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 4, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(7, '2019-09-19', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 4, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(8, '2019-09-20', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 4, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(9, '2019-09-21', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 4, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(10, '2019-09-25', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 4, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(11, '2019-09-26', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 4, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(12, '2019-09-28', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 4, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(13, '2019-09-10', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 5, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(14, '2019-09-11', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 5, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(15, '2019-09-12', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 5, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(16, '2019-09-14', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 5, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(17, '2019-09-17', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 5, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(18, '2019-09-18', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 5, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(19, '2019-09-19', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 5, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(20, '2019-09-20', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 5, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(21, '2019-09-21', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 5, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(22, '2019-09-25', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 5, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(23, '2019-09-26', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 5, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(24, '2019-09-28', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 5, 5, 'System', '2019-09-16 15:40:26', 'System', '2019-09-16 15:40:26'),
(25, '2019-09-10', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 6, 5, 'System', '2019-09-16 16:57:27', 'System', '2019-09-16 16:57:27'),
(26, '2019-09-11', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 6, 5, 'System', '2019-09-16 16:57:27', 'System', '2019-09-16 16:57:27'),
(27, '2019-09-12', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 6, 5, 'System', '2019-09-16 16:57:27', 'System', '2019-09-16 16:57:27'),
(28, '2019-09-13', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 6, 5, 'System', '2019-09-16 16:57:27', 'System', '2019-09-16 16:57:27'),
(29, '2019-09-14', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 6, 5, 'System', '2019-09-16 16:57:27', 'System', '2019-09-16 16:57:27'),
(30, '2019-09-16', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 6, 5, 'System', '2019-09-16 16:57:27', 'System', '2019-09-16 16:57:27'),
(31, '2019-09-17', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 6, 5, 'System', '2019-09-16 16:57:27', 'System', '2019-09-16 16:57:27'),
(32, '2019-09-18', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 6, 5, 'System', '2019-09-16 16:57:27', 'System', '2019-09-16 16:57:27'),
(33, '2019-09-19', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 6, 5, 'System', '2019-09-16 16:57:27', 'System', '2019-09-16 16:57:27'),
(34, '2019-09-20', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 6, 5, 'System', '2019-09-16 16:57:27', 'System', '2019-09-16 16:57:27'),
(35, '2019-09-21', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 6, 5, 'System', '2019-09-16 16:57:27', 'System', '2019-09-16 16:57:27'),
(36, '2019-09-23', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 6, 5, 'System', '2019-09-16 16:57:27', 'System', '2019-09-16 16:57:27'),
(37, '2019-09-24', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 6, 5, 'System', '2019-09-16 16:57:27', 'System', '2019-09-16 16:57:27'),
(38, '2019-09-25', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 6, 5, 'System', '2019-09-16 16:57:27', 'System', '2019-09-16 16:57:27'),
(39, '2019-09-26', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 6, 5, 'System', '2019-09-16 16:57:27', 'System', '2019-09-16 16:57:27'),
(40, '2019-09-27', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 6, 5, 'System', '2019-09-16 16:57:27', 'System', '2019-09-16 16:57:27'),
(41, '2019-09-28', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 6, 5, 'System', '2019-09-16 16:57:27', 'System', '2019-09-16 16:57:27'),
(42, '2019-09-10', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 7, 5, 'System', '2019-09-16 16:57:34', 'System', '2019-09-16 16:57:34'),
(43, '2019-09-11', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 7, 5, 'System', '2019-09-16 16:57:34', 'System', '2019-09-16 16:57:34'),
(44, '2019-09-12', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 7, 5, 'System', '2019-09-16 16:57:34', 'System', '2019-09-16 16:57:34'),
(45, '2019-09-13', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 7, 5, 'System', '2019-09-16 16:57:34', 'System', '2019-09-16 16:57:34'),
(46, '2019-09-14', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 7, 5, 'System', '2019-09-16 16:57:34', 'System', '2019-09-16 16:57:34'),
(47, '2019-09-16', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 7, 5, 'System', '2019-09-16 16:57:34', 'System', '2019-09-16 16:57:34'),
(48, '2019-09-17', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 7, 5, 'System', '2019-09-16 16:57:34', 'System', '2019-09-16 16:57:34'),
(49, '2019-09-18', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 7, 5, 'System', '2019-09-16 16:57:34', 'System', '2019-09-16 16:57:34'),
(50, '2019-09-19', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 7, 5, 'System', '2019-09-16 16:57:34', 'System', '2019-09-16 16:57:34'),
(51, '2019-09-20', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 7, 5, 'System', '2019-09-16 16:57:34', 'System', '2019-09-16 16:57:34'),
(52, '2019-09-21', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 7, 5, 'System', '2019-09-16 16:57:34', 'System', '2019-09-16 16:57:34'),
(53, '2019-09-23', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 7, 5, 'System', '2019-09-16 16:57:34', 'System', '2019-09-16 16:57:34'),
(54, '2019-09-24', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 7, 5, 'System', '2019-09-16 16:57:34', 'System', '2019-09-16 16:57:34'),
(55, '2019-09-25', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 7, 5, 'System', '2019-09-16 16:57:34', 'System', '2019-09-16 16:57:34'),
(56, '2019-09-26', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 7, 5, 'System', '2019-09-16 16:57:34', 'System', '2019-09-16 16:57:34'),
(57, '2019-09-27', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 7, 5, 'System', '2019-09-16 16:57:34', 'System', '2019-09-16 16:57:34'),
(58, '2019-09-28', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 7, 5, 'System', '2019-09-16 16:57:34', 'System', '2019-09-16 16:57:34'),
(59, '2019-09-10', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 8, 5, 'System', '2019-09-16 16:57:38', 'System', '2019-09-16 16:57:38'),
(60, '2019-09-11', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 8, 5, 'System', '2019-09-16 16:57:38', 'System', '2019-09-16 16:57:38'),
(61, '2019-09-12', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 8, 5, 'System', '2019-09-16 16:57:38', 'System', '2019-09-16 16:57:38'),
(62, '2019-09-13', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 8, 5, 'System', '2019-09-16 16:57:38', 'System', '2019-09-16 16:57:38'),
(63, '2019-09-14', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 8, 5, 'System', '2019-09-16 16:57:38', 'System', '2019-09-16 16:57:38'),
(64, '2019-09-16', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 8, 5, 'System', '2019-09-16 16:57:38', 'System', '2019-09-16 16:57:38'),
(65, '2019-09-17', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 8, 5, 'System', '2019-09-16 16:57:38', 'System', '2019-09-16 16:57:38'),
(66, '2019-09-18', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 8, 5, 'System', '2019-09-16 16:57:38', 'System', '2019-09-16 16:57:38'),
(67, '2019-09-19', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 8, 5, 'System', '2019-09-16 16:57:38', 'System', '2019-09-16 16:57:38'),
(68, '2019-09-20', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 8, 5, 'System', '2019-09-16 16:57:38', 'System', '2019-09-16 16:57:38'),
(69, '2019-09-21', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 8, 5, 'System', '2019-09-16 16:57:38', 'System', '2019-09-16 16:57:38'),
(70, '2019-09-23', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 8, 5, 'System', '2019-09-16 16:57:38', 'System', '2019-09-16 16:57:38'),
(71, '2019-09-24', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 8, 5, 'System', '2019-09-16 16:57:38', 'System', '2019-09-16 16:57:38'),
(72, '2019-09-25', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 8, 5, 'System', '2019-09-16 16:57:38', 'System', '2019-09-16 16:57:38'),
(73, '2019-09-26', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 8, 5, 'System', '2019-09-16 16:57:38', 'System', '2019-09-16 16:57:38'),
(74, '2019-09-27', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 8, 5, 'System', '2019-09-16 16:57:38', 'System', '2019-09-16 16:57:38'),
(75, '2019-09-28', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 8, 5, 'System', '2019-09-16 16:57:38', 'System', '2019-09-16 16:57:38'),
(76, '2019-09-10', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 9, 5, 'System', '2019-09-16 17:03:33', 'System', '2019-09-16 17:03:33'),
(77, '2019-09-11', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 9, 5, 'System', '2019-09-16 17:03:33', 'System', '2019-09-16 17:03:33'),
(78, '2019-09-12', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 9, 5, 'System', '2019-09-16 17:03:33', 'System', '2019-09-16 17:03:33'),
(79, '2019-09-13', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 9, 5, 'System', '2019-09-16 17:03:33', 'System', '2019-09-16 17:03:33'),
(80, '2019-09-14', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 9, 5, 'System', '2019-09-16 17:03:33', 'System', '2019-09-16 17:03:33'),
(81, '2019-09-16', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 9, 5, 'System', '2019-09-16 17:03:33', 'System', '2019-09-16 17:03:33'),
(82, '2019-09-17', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 9, 5, 'System', '2019-09-16 17:03:33', 'System', '2019-09-16 17:03:33'),
(83, '2019-09-18', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 9, 5, 'System', '2019-09-16 17:03:33', 'System', '2019-09-16 17:03:33'),
(84, '2019-09-19', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 9, 5, 'System', '2019-09-16 17:03:33', 'System', '2019-09-16 17:03:33'),
(85, '2019-09-20', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 9, 5, 'System', '2019-09-16 17:03:33', 'System', '2019-09-16 17:03:33'),
(86, '2019-09-21', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 9, 5, 'System', '2019-09-16 17:03:33', 'System', '2019-09-16 17:03:33'),
(87, '2019-09-23', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 9, 5, 'System', '2019-09-16 17:03:33', 'System', '2019-09-16 17:03:33'),
(88, '2019-09-24', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 9, 5, 'System', '2019-09-16 17:03:33', 'System', '2019-09-16 17:03:33'),
(89, '2019-09-25', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 9, 5, 'System', '2019-09-16 17:03:33', 'System', '2019-09-16 17:03:33'),
(90, '2019-09-26', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 9, 5, 'System', '2019-09-16 17:03:33', 'System', '2019-09-16 17:03:33'),
(91, '2019-09-27', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 9, 5, 'System', '2019-09-16 17:03:33', 'System', '2019-09-16 17:03:33'),
(92, '2019-09-28', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 9, 5, 'System', '2019-09-16 17:03:33', 'System', '2019-09-16 17:03:33'),
(93, '2019-09-10', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 10, 5, 'System', '2019-09-16 17:06:05', 'System', '2019-09-16 17:06:05'),
(94, '2019-09-11', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 10, 5, 'System', '2019-09-16 17:06:05', 'System', '2019-09-16 17:06:05'),
(95, '2019-09-12', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 10, 5, 'System', '2019-09-16 17:06:05', 'System', '2019-09-16 17:06:05'),
(96, '2019-09-13', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 10, 5, 'System', '2019-09-16 17:06:05', 'System', '2019-09-16 17:06:05'),
(97, '2019-09-14', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 10, 5, 'System', '2019-09-16 17:06:05', 'System', '2019-09-16 17:06:05'),
(98, '2019-09-16', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 10, 5, 'System', '2019-09-16 17:06:05', 'System', '2019-09-16 17:06:05'),
(99, '2019-09-17', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 10, 5, 'System', '2019-09-16 17:06:05', 'System', '2019-09-16 17:06:05'),
(100, '2019-09-18', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 10, 5, 'System', '2019-09-16 17:06:05', 'System', '2019-09-16 17:06:05'),
(101, '2019-09-19', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 10, 5, 'System', '2019-09-16 17:06:05', 'System', '2019-09-16 17:06:05'),
(102, '2019-09-20', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 10, 5, 'System', '2019-09-16 17:06:05', 'System', '2019-09-16 17:06:05'),
(103, '2019-09-21', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 10, 5, 'System', '2019-09-16 17:06:05', 'System', '2019-09-16 17:06:05'),
(104, '2019-09-23', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 10, 5, 'System', '2019-09-16 17:06:05', 'System', '2019-09-16 17:06:05'),
(105, '2019-09-24', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 10, 5, 'System', '2019-09-16 17:06:05', 'System', '2019-09-16 17:06:05'),
(106, '2019-09-25', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 10, 5, 'System', '2019-09-16 17:06:05', 'System', '2019-09-16 17:06:05'),
(107, '2019-09-26', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 10, 5, 'System', '2019-09-16 17:06:05', 'System', '2019-09-16 17:06:05'),
(108, '2019-09-27', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 10, 5, 'System', '2019-09-16 17:06:05', 'System', '2019-09-16 17:06:05'),
(109, '2019-09-28', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 10, 5, 'System', '2019-09-16 17:06:05', 'System', '2019-09-16 17:06:05'),
(110, '2019-09-10', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 11, 5, 'System', '2019-09-16 17:12:50', 'System', '2019-09-16 17:12:50'),
(111, '2019-09-11', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 11, 5, 'System', '2019-09-16 17:12:50', 'System', '2019-09-16 17:12:50'),
(112, '2019-09-12', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 11, 5, 'System', '2019-09-16 17:12:50', 'System', '2019-09-16 17:12:50'),
(113, '2019-09-13', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 11, 5, 'System', '2019-09-16 17:12:50', 'System', '2019-09-16 17:12:50'),
(114, '2019-09-14', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 11, 5, 'System', '2019-09-16 17:12:50', 'System', '2019-09-16 17:12:50'),
(115, '2019-09-16', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 11, 5, 'System', '2019-09-16 17:12:50', 'System', '2019-09-16 17:12:50'),
(116, '2019-09-17', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 11, 5, 'System', '2019-09-16 17:12:50', 'System', '2019-09-16 17:12:50'),
(117, '2019-09-18', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 11, 5, 'System', '2019-09-16 17:12:50', 'System', '2019-09-16 17:12:50'),
(118, '2019-09-19', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 11, 5, 'System', '2019-09-16 17:12:50', 'System', '2019-09-16 17:12:50'),
(119, '2019-09-20', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 11, 5, 'System', '2019-09-16 17:12:50', 'System', '2019-09-16 17:12:50'),
(120, '2019-09-21', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 11, 5, 'System', '2019-09-16 17:12:50', 'System', '2019-09-16 17:12:50'),
(121, '2019-09-23', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 11, 5, 'System', '2019-09-16 17:12:50', 'System', '2019-09-16 17:12:50'),
(122, '2019-09-24', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 11, 5, 'System', '2019-09-16 17:12:50', 'System', '2019-09-16 17:12:50'),
(123, '2019-09-25', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 11, 5, 'System', '2019-09-16 17:12:50', 'System', '2019-09-16 17:12:50'),
(124, '2019-09-26', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 11, 5, 'System', '2019-09-16 17:12:50', 'System', '2019-09-16 17:12:50'),
(125, '2019-09-27', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 11, 5, 'System', '2019-09-16 17:12:50', 'System', '2019-09-16 17:12:50'),
(126, '2019-09-28', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 11, 5, 'System', '2019-09-16 17:12:50', 'System', '2019-09-16 17:12:50'),
(127, '2019-09-10', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 12, 5, 'System', '2019-09-17 16:34:16', 'System', '2019-09-17 16:34:16'),
(128, '2019-09-11', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 12, 5, 'System', '2019-09-17 16:34:16', 'System', '2019-09-17 16:34:16'),
(129, '2019-09-12', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 12, 5, 'System', '2019-09-17 16:34:16', 'System', '2019-09-17 16:34:16'),
(130, '2019-09-13', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 12, 5, 'System', '2019-09-17 16:34:16', 'System', '2019-09-17 16:34:16'),
(131, '2019-09-14', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 12, 5, 'System', '2019-09-17 16:34:16', 'System', '2019-09-17 16:34:16'),
(132, '2019-09-16', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 12, 5, 'System', '2019-09-17 16:34:16', 'System', '2019-09-17 16:34:16'),
(133, '2019-09-17', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 12, 5, 'System', '2019-09-17 16:34:16', 'System', '2019-09-17 16:34:16'),
(134, '2019-09-18', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 12, 5, 'System', '2019-09-17 16:34:16', 'System', '2019-09-17 16:34:16'),
(135, '2019-09-19', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 12, 5, 'System', '2019-09-17 16:34:16', 'System', '2019-09-17 16:34:16'),
(136, '2019-09-20', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 12, 5, 'System', '2019-09-17 16:34:16', 'System', '2019-09-17 16:34:16'),
(137, '2019-09-21', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 12, 5, 'System', '2019-09-17 16:34:16', 'System', '2019-09-17 16:34:16'),
(138, '2019-09-23', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 12, 5, 'System', '2019-09-17 16:34:16', 'System', '2019-09-17 16:34:16'),
(139, '2019-09-24', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 12, 5, 'System', '2019-09-17 16:34:16', 'System', '2019-09-17 16:34:16'),
(140, '2019-09-25', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 12, 5, 'System', '2019-09-17 16:34:16', 'System', '2019-09-17 16:34:16'),
(141, '2019-09-26', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 12, 5, 'System', '2019-09-17 16:34:16', 'System', '2019-09-17 16:34:16'),
(142, '2019-09-27', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 12, 5, 'System', '2019-09-17 16:34:16', 'System', '2019-09-17 16:34:16'),
(143, '2019-09-28', '9.00, 9.00, 1, sec_one', '10.00, 10.30, 1, sec_two', '11.00, 12.00, 1, sec_three', '13.00, 13.00, 1, sec_four', '14.00, 14.30, 1, sec_five', '15.00, 16.00, 1, sec_six', 12, 5, 'System', '2019-09-17 16:34:16', 'System', '2019-09-17 16:34:16');

-- --------------------------------------------------------

--
-- Table structure for table `tb_settings`
--

CREATE TABLE `tb_settings` (
  `set_id` int(11) NOT NULL,
  `set_year` varchar(4) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ปีการศึกษา',
  `set_term` varchar(25) COLLATE utf8_unicode_ci NOT NULL COMMENT 'เทอม',
  `set_open` date NOT NULL COMMENT 'วันที่เริ่มเปิดนัด',
  `set_close` date NOT NULL COMMENT 'วันที่นัดได้วันสุดท้าย',
  `set_option_sat` int(1) NOT NULL COMMENT '0: ไม่นับวันเสาร์, 1: นับวันเสาร์ด้วย ',
  `set_option_sun` int(1) NOT NULL COMMENT '0: ไม่นับวันอาทิตย์, 1: นับวันอาทิตย์ด้วย	',
  `set_status` int(1) NOT NULL COMMENT '0: ไม่ใช้ ,1: อันที่ใช้ปัจจุบัน (มีได้แค่แถวเดียว), 2: สถานะที่เปิดระบบแล้ว',
  `set_create_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `set_create_date` datetime NOT NULL,
  `set_lastedit_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `set_lastedit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='ตารางตั้งค่าระบบ';

--
-- Dumping data for table `tb_settings`
--

INSERT INTO `tb_settings` (`set_id`, `set_year`, `set_term`, `set_open`, `set_close`, `set_option_sat`, `set_option_sun`, `set_status`, `set_create_name`, `set_create_date`, `set_lastedit_name`, `set_lastedit_date`) VALUES
(1, '0000', 'เทอม ', '2019-09-10', '2019-09-30', 1, 0, 0, 'System', '2019-09-10 11:20:51', 'System', '2019-09-10 17:00:14'),
(2, '2562', 'เทอม ', '2019-09-10', '2019-09-30', 1, 1, 0, 'System', '2019-09-10 11:29:09', 'System', '2019-09-10 17:00:17'),
(3, '2222', 'เทอม ', '2019-09-10', '2019-09-30', 1, 0, 0, 'System', '2019-09-10 11:34:44', 'System', '2019-09-11 14:45:36'),
(4, '2562', 'เทอม ', '2019-09-10', '2019-09-30', 1, 0, 0, 'System', '2019-09-10 11:40:06', 'System', '2019-09-11 14:45:39'),
(5, '2562', 'เทอม 1', '2019-09-10', '2019-09-30', 1, 0, 2, 'System', '2019-09-10 11:41:54', 'System', '2019-09-10 16:26:53'),
(6, '2562', 'เทอม 2', '2019-09-01', '2019-09-30', 1, 0, 0, 'System', '2019-09-14 10:31:06', 'System', '2019-09-14 10:31:06');

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

-- --------------------------------------------------------

--
-- Table structure for table `tb_subject`
--

CREATE TABLE `tb_subject` (
  `sub_id` int(11) NOT NULL,
  `sub_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'ชื่อวิชา',
  `sub_code` varchar(255) COLLATE utf8_unicode_ci NOT NULL COMMENT 'รหัสวิชา',
  `use_id` int(5) NOT NULL COMMENT 'ไอดีอาจารย์ผู้สอน',
  `set_id` int(11) NOT NULL COMMENT 'ไอดีตั้งค่าระบบปัจจุบัน',
  `sub_setuse` int(1) NOT NULL COMMENT 'จำนวนอาจารย์ขึ้นสอบ',
  `sub_setless` int(1) NOT NULL COMMENT 'จำนวนอาจารย์ขึ้นสอบอย่างน้อย',
  `sub_type` int(1) NOT NULL COMMENT '1: โครงการหนึ่ง, 2: โครงการสอง',
  `sub_status` int(1) NOT NULL COMMENT '0: ปิดไปแล้ว, 1: ยังเปิดอยู่',
  `sub_create_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sub_create_date` datetime NOT NULL,
  `sub_lastedit_name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `sub_lastedit_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tb_subject`
--

INSERT INTO `tb_subject` (`sub_id`, `sub_name`, `sub_code`, `use_id`, `set_id`, `sub_setuse`, `sub_setless`, `sub_type`, `sub_status`, `sub_create_name`, `sub_create_date`, `sub_lastedit_name`, `sub_lastedit_date`) VALUES
(1, 'โครงงานเทคโนโลยีสารสนเทศ 1', 'IFT 4223', 4, 5, 4, 3, 1, 1, 'System', '2019-09-17 12:52:22', 'System', '2019-09-17 12:52:22'),
(2, 'โครงงานเทคโนโลยีสารสนเทศ 2', 'IFT 4224', 5, 5, 5, 3, 2, 1, 'System', '2019-09-17 12:52:59', 'System', '2019-09-17 13:25:21');

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
(1, 'System', 'sys@itrmutr.com', '61b3151941bb43fad57005524d1a967c', 1, '2019-09-18 14:16:39', 'Support', '2019-09-03 00:00:00', 'System', '2019-09-17 15:58:06'),
(2, 'Napassorn', 'yui.napassorns@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e', 1, '2019-09-04 16:06:38', 'System', '2019-09-04 16:06:38', 'System', '2019-09-16 15:46:32'),
(3, 'Preedarat', 'preedarat.jut@gmail.com', 'd41d8cd98f00b204e9800998ecf8427e', 1, '2019-09-04 16:06:38', 'System', '2019-09-04 16:10:43', 'System', '2019-09-04 16:10:43'),
(4, 'Vilavan Sukc', 'vilavan@itrmutr.com', 'b4210a7b49431a59c508046f3f19bd56', 2, '0000-00-00 00:00:00', 'System', '2019-09-04 16:39:16', 'System', '2019-09-04 16:39:16'),
(5, 'Ake Phisit', 'phisit@itrmutr.com', 'c549823d4063f3779ca55b7c18ffa4fe', 3, '0000-00-00 00:00:00', 'System', '2019-09-04 20:08:13', 'System', '2019-09-04 20:08:13'),
(6, 'Napharat Chooprai', 'napharat@itrmutr.com', 'eaa44e5b234ee526d6d20ef43d38d84b', 3, '0000-00-00 00:00:00', 'System', '2019-09-16 16:20:00', 'System', '2019-09-16 16:20:00'),
(7, 'Komsan Srivisut', 'komsan@itrmutr.com', '3e6c0c6043ac8ba5178f53d953497f7d', 3, '0000-00-00 00:00:00', 'System', '2019-09-16 16:24:54', 'System', '2019-09-16 16:24:54'),
(8, 'Lex Samaporn', 'samaporn@itrmutr.com', 'ab4af557cac224b3f00645189a4893d0', 3, '0000-00-00 00:00:00', 'System', '2019-09-16 16:26:01', 'System', '2019-09-16 16:26:01'),
(9, 'Noppasak', 'noppasak@itrmutr.com', '58c413d3eab1b7efe765dd3d2d6c510f', 3, '0000-00-00 00:00:00', 'System', '2019-09-16 17:03:33', 'System', '2019-09-16 17:03:33'),
(10, 'Ekkarin Wijitphan', 'ekkarin@itrmutr.com', '6312089867929d6c4ea871b782a4e0dc', 3, '0000-00-00 00:00:00', 'System', '2019-09-16 17:06:05', 'System', '2019-09-16 17:06:05'),
(11, 'Wisarut Suesuwan', 'wisarut@itrmutr.com', 'd41d8cd98f00b204e9800998ecf8427e', 3, '0000-00-00 00:00:00', 'System', '2019-09-16 17:12:50', 'System', '2019-09-16 17:14:37');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `tb_attached`
--
ALTER TABLE `tb_attached`
  ADD PRIMARY KEY (`att_id`);

--
-- Indexes for table `tb_detailmeet`
--
ALTER TABLE `tb_detailmeet`
  ADD PRIMARY KEY (`dmeet_id`);

--
-- Indexes for table `tb_holiday`
--
ALTER TABLE `tb_holiday`
  ADD PRIMARY KEY (`hol_id`);

--
-- Indexes for table `tb_meet`
--
ALTER TABLE `tb_meet`
  ADD PRIMARY KEY (`meet_id`);

--
-- Indexes for table `tb_position`
--
ALTER TABLE `tb_position`
  ADD PRIMARY KEY (`position_id`);

--
-- Indexes for table `tb_project`
--
ALTER TABLE `tb_project`
  ADD PRIMARY KEY (`project_id`);

--
-- Indexes for table `tb_section`
--
ALTER TABLE `tb_section`
  ADD PRIMARY KEY (`sec_id`);

--
-- Indexes for table `tb_settings`
--
ALTER TABLE `tb_settings`
  ADD PRIMARY KEY (`set_id`);

--
-- Indexes for table `tb_student`
--
ALTER TABLE `tb_student`
  ADD PRIMARY KEY (`std_id`);

--
-- Indexes for table `tb_subject`
--
ALTER TABLE `tb_subject`
  ADD PRIMARY KEY (`sub_id`);

--
-- Indexes for table `tb_user`
--
ALTER TABLE `tb_user`
  ADD PRIMARY KEY (`use_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tb_attached`
--
ALTER TABLE `tb_attached`
  MODIFY `att_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_detailmeet`
--
ALTER TABLE `tb_detailmeet`
  MODIFY `dmeet_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_holiday`
--
ALTER TABLE `tb_holiday`
  MODIFY `hol_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_meet`
--
ALTER TABLE `tb_meet`
  MODIFY `meet_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_position`
--
ALTER TABLE `tb_position`
  MODIFY `position_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tb_project`
--
ALTER TABLE `tb_project`
  MODIFY `project_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_section`
--
ALTER TABLE `tb_section`
  MODIFY `sec_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=144;

--
-- AUTO_INCREMENT for table `tb_settings`
--
ALTER TABLE `tb_settings`
  MODIFY `set_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `tb_student`
--
ALTER TABLE `tb_student`
  MODIFY `std_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tb_subject`
--
ALTER TABLE `tb_subject`
  MODIFY `sub_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tb_user`
--
ALTER TABLE `tb_user`
  MODIFY `use_id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

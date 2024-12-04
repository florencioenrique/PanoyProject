-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 05, 2024 at 12:26 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `cyberian`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`, `name`) VALUES
(1, 'admin', '$2y$10$KvJeCOWa5Icju8pf/DLkWOQq0CGk3qZmkBhu47WgsGUPGp.7QNBNq', 'Admin');

-- --------------------------------------------------------

--
-- Table structure for table `assigned_course`
--

CREATE TABLE `assigned_course` (
  `id` int(11) NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `faculty_id` bigint(20) NOT NULL,
  `start_time` varchar(255) NOT NULL,
  `end_time` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `assigned_course`
--

INSERT INTO `assigned_course` (`id`, `course_id`, `faculty_id`, `start_time`, `end_time`, `status`) VALUES
(1, 'CAP102', 123, '23:22', '23:22', 'Accepted');

-- --------------------------------------------------------

--
-- Table structure for table `course`
--

CREATE TABLE `course` (
  `id` int(11) NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `course_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `course`
--

INSERT INTO `course` (`id`, `course_id`, `course_name`) VALUES
(4, 'SA101', 'System Administration'),
(5, 'WS101', 'Web System Technologies'),
(6, 'ITE101', 'Seminars And Fieldtrip'),
(7, 'CAP102', 'Capstone'),
(8, 'IAS 102', 'Information Assurance and Security 2'),
(9, 'SIA101', 'System Integration and Architecture'),
(10, 'CC106', 'Application Development'),
(11, 'SIA102', 'System Integration and Architecture 2'),
(12, 'WS102', 'Web System Technologies 2'),
(13, 'IAS101', 'Information Assurance and Security'),
(14, 'IM102', 'IM102'),
(15, 'SP102', 'Social and Professional Issue 2'),
(16, 'SP101', 'Social and Professional Issue'),
(17, 'NET 102', 'NET102'),
(18, 'IM101', 'IM101'),
(19, 'NET101', 'NET101'),
(20, 'MS101', 'MS101'),
(21, 'IPT', 'Integrative Programing and Technology'),
(22, 'CC105', 'Information Management'),
(23, 'PF101', 'PF101'),
(24, 'HC1102', 'Human Computer interaction 2'),
(25, 'HCI101', 'Human Computer interaction'),
(26, 'CC104', 'Data Structure and Algorithm'),
(27, 'PT101', 'Platform Technology'),
(28, 'CC103', 'CC103'),
(29, 'GEC104', 'N/A'),
(30, 'CC101', 'N/A'),
(31, 'CC102', 'N/A'),
(32, 'CP101', 'Computer Programming'),
(33, 'CC107', 'Computer Programming'),
(34, 'G1', 'Games1');

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

CREATE TABLE `enrollments` (
  `id` int(11) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `course_id` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `enrollments`
--

INSERT INTO `enrollments` (`id`, `student_id`, `course_id`, `status`) VALUES
(1, 115073070010, 'CAP102', 'Accepted'),
(2, 115073070010, 'SA101', 'Pending');

-- --------------------------------------------------------

--
-- Table structure for table `faculty`
--

CREATE TABLE `faculty` (
  `id` int(11) NOT NULL,
  `faculty_id` bigint(20) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `sex` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faculty`
--

INSERT INTO `faculty` (`id`, `faculty_id`, `firstname`, `lastname`, `sex`, `username`, `password`) VALUES
(1, 123, 'Florencio', 'Enrique', '', 'florencioenrique27499@gmail.com', '123'),
(2, 456, 'Ambot', 'Kanimo', '', 'ambot@gmail.com', '456'),
(3, 0, 'Secret', 'Secret Man', 'male', 'a@gmail.com', '123'),
(6, 789, 'John Rey', 'Alarcon', 'male', 'johnrey@gmail.com', 'sac'),
(7, 295620205, 'Ian Lexter', 'Dela Torre', 'male', 'ian@sac.edu.ph', 'sac');

-- --------------------------------------------------------

--
-- Table structure for table `post`
--

CREATE TABLE `post` (
  `id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `post` varchar(255) NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `file` varchar(255) DEFAULT NULL,
  `poster` varchar(255) NOT NULL,
  `post_date` varchar(255) NOT NULL,
  `post_time` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `post`
--

INSERT INTO `post` (`id`, `post_id`, `post`, `image`, `file`, `poster`, `post_date`, `post_time`) VALUES
(1, 0, 'Sample Post', NULL, '', '', '2024-12-01', '10:41'),
(23, 0, 'This is the IT Logo', '674bcbe6b4b15.png', '', 'Admin', '2024-12-01', '10:37'),
(24, 0, 'Hi', NULL, '', 'Admin', '2024-12-01', '10:41'),
(25, 0, '', NULL, '674bd1cb9df8e.docx', 'Admin', '2024-12-01', '11:02'),
(26, 0, 'WEW', '674bd265453a1.jpg', '674bd26545ec2.docx', 'Admin', '2024-12-01', '11:04'),
(27, 0, '', NULL, '674bd3b2e9195.docx', 'Admin', '2024-12-01', '11:10'),
(31, 0, '', NULL, '674beb9c67ef4.docx', 'Admin', '2024-12-01', '12:52'),
(33, 0, 'wew', NULL, '', 'Admin', '2024-12-01', '13:03'),
(34, 0, 'wew', NULL, '', 'Admin', '2024-12-01', '13:03'),
(35, 0, 'wew', NULL, NULL, 'Admin', '2024-12-01', '13:03'),
(36, 0, '', '674bef322ea10.jpg', NULL, 'Admin', '2024-12-01', '13:07'),
(38, 0, '', NULL, '674bef9aa68a0.docx', 'Admin', '2024-12-01', '13:08'),
(39, 0, 'Sheesh', '674c1fc3cff28.jpg', NULL, 'Admin', '2024-12-01', '16:01'),
(45, 0, 'Hello Word', '6750102ed8c8b.jpg', NULL, 'Admin', '2024-12-04', '16:16'),
(46, 0, 'Hello Word', NULL, '67501050f17c4.docx', 'Admin', '2024-12-04', '16:17'),
(47, 0, 'Hello Word', NULL, NULL, 'Admin', '2024-12-04', '16:18');

-- --------------------------------------------------------

--
-- Table structure for table `student`
--

CREATE TABLE `student` (
  `id` int(11) NOT NULL,
  `student_id` bigint(20) NOT NULL,
  `firstname` varchar(255) NOT NULL,
  `lastname` varchar(255) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `year` int(11) NOT NULL,
  `sex` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student`
--

INSERT INTO `student` (`id`, `student_id`, `firstname`, `lastname`, `username`, `password`, `year`, `sex`) VALUES
(1, 115073070010, 'Florencio', 'Enrique', 'florencioenrique27499@gmail.com', '1', 4, ''),
(2, 0, 'wew', 'e', 'we@h', 'ewe', 1, 'male'),
(3, 0, '1213', '131', '13@gmail.com', '113', 121, 'female'),
(4, 0, 'Florencio', 'Enrique', 'a@gmail.com', '123', 4, 'male'),
(5, 115073070011, 'Florencio', 'Enrique', 'florencioenrique27499@gmail.com', '115073070011', 4, 'male'),
(7, 12345, 'John', 'Doe', 'johndoe@gmail.com', '12345', 1, 'male'),
(8, 115073070012, 'Ian Lexter', 'Dela Torre', 'ian@gmail.com', '115073070012', 4, 'male'),
(9, 1234567890, 'Florencio', 'Enrique', 'enriqueflorencio@sac.edu.ph', '1234567890', 4, 'male');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `assigned_course`
--
ALTER TABLE `assigned_course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `course`
--
ALTER TABLE `course`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `enrollments`
--
ALTER TABLE `enrollments`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faculty`
--
ALTER TABLE `faculty`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `post`
--
ALTER TABLE `post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `student`
--
ALTER TABLE `student`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `assigned_course`
--
ALTER TABLE `assigned_course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `course`
--
ALTER TABLE `course`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `enrollments`
--
ALTER TABLE `enrollments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `faculty`
--
ALTER TABLE `faculty`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `post`
--
ALTER TABLE `post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `student`
--
ALTER TABLE `student`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

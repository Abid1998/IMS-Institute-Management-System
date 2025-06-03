-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 03, 2025 at 01:13 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `ims`
--

-- --------------------------------------------------------

--
-- Table structure for table `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `studentId` varchar(20) NOT NULL,
  `attendance` varchar(5) NOT NULL,
  `dateOfAttendance` varchar(15) NOT NULL,
  `center_name` varchar(50) NOT NULL,
  `create_by` varchar(20) NOT NULL,
  `createOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `attendance`
--

INSERT INTO `attendance` (`id`, `studentId`, `attendance`, `dateOfAttendance`, `center_name`, `create_by`, `createOn`) VALUES
(1, 'INF-0001', 'A', '17-08-2024', 'Adhartal', '7', '2024-08-17 05:43:59'),
(2, 'INF-0001', 'A', '27-09-2024', 'All', '3', '2024-09-27 10:45:26'),
(3, 'INF-0002', 'P', '02-06-2025', 'Adhartal', '3', '2025-06-02 16:37:05'),
(4, 'INF-0003', 'P', '02-06-2025', 'Adhartal', '3', '2025-06-02 16:40:10');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(11) NOT NULL,
  `course_name` varchar(200) NOT NULL,
  `description` text NOT NULL,
  `createOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `description`, `createOn`) VALUES
(4, '1st', '', '2024-08-05 15:22:11'),
(5, '2nd', '', '2024-08-05 15:22:30'),
(6, '3rd', '', '2024-08-05 15:22:43'),
(7, '4th', '', '2024-08-05 15:22:51'),
(8, '5th', '', '2024-08-05 15:23:00'),
(9, '6th', '', '2024-08-05 15:23:10'),
(10, '7th', '', '2024-08-05 15:23:18'),
(11, '8th', '', '2024-08-05 15:23:25'),
(12, '9th', '', '2024-08-05 15:23:33'),
(13, '10th', '', '2024-08-05 15:23:40'),
(14, '11th (PCM)', 'Physics, Chemistry, Mathematics (PCM), and sometimes Computer Science', '2024-08-05 15:24:18'),
(15, '11th (PCB)', 'Physics, Chemistry, Biology (PCB)', '2024-08-05 15:25:15'),
(16, '11th (Art)', 'History, Geography, Political Science, Psychology, Sociology, Philosophy, Economics, and Languages (like English, Hindi, Sanskrit, etc.)', '2024-08-05 15:28:41'),
(17, '12th (Art)', 'History, Geography, Political Science, Psychology, Sociology, Philosophy, Economics, and Languages (like English, Hindi, Sanskrit, etc.)', '2024-08-05 15:31:20'),
(18, '12th (PCM)', 'Physics, Chemistry, Mathematics (PCM), and sometimes Computer Science', '2024-08-05 15:31:48'),
(19, '12th (PCB)', 'Physics, Chemistry, Biology (PCB)', '2024-08-05 15:32:19');

-- --------------------------------------------------------

--
-- Table structure for table `instalment`
--

CREATE TABLE `instalment` (
  `id` int(11) NOT NULL,
  `total_pay` double NOT NULL,
  `role_number` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `instalment`
--

INSERT INTO `instalment` (`id`, `total_pay`, `role_number`) VALUES
(1, 4000, 'INF-0001'),
(2, 6000, 'INF-0002'),
(3, 1000, 'INF-0003'),
(4, 1000, 'INF-0003'),
(5, 1000, 'INF-0003');

-- --------------------------------------------------------

--
-- Table structure for table `login_logout`
--

CREATE TABLE `login_logout` (
  `id` int(11) NOT NULL,
  `userid` varchar(15) NOT NULL,
  `login` varchar(25) NOT NULL,
  `logout` varchar(25) NOT NULL,
  `location` varchar(160) NOT NULL,
  `createOn` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `login_logout`
--

INSERT INTO `login_logout` (`id`, `userid`, `login`, `logout`, `location`, `createOn`) VALUES
(1, '3', '17-08-2024:11:15:23am', '02-06-2025:10:22:18pm', '28.5832335,77.157852', '2024-08-17 05:45:23'),
(2, '3', '17-08-2024:11:17:39am', '02-06-2025:10:22:18pm', '28.5832335,77.157852', '2024-08-17 05:47:39'),
(3, '8', '17-08-2024:11:18:58am', '', '28.5832335,77.157852', '2024-08-17 05:48:58'),
(4, '3', '27-09-2024:04:15:17pm', '02-06-2025:10:22:18pm', '28.570834,77.1570695', '2024-09-27 10:45:17'),
(5, '3', '27-09-2024:04:20:00pm', '02-06-2025:10:22:18pm', '28.560521,77.1600089', '2024-09-27 10:50:00'),
(6, '3', '02-06-2025:10:05:18pm', '02-06-2025:10:22:18pm', '28.5705768,77.1580993', '2025-06-02 16:35:18'),
(7, '3', '02-06-2025:10:14:35pm', '02-06-2025:10:22:18pm', '28.6359552,77.2079616', '2025-06-02 16:44:35'),
(8, '3', '03-06-2025:04:42:30pm', '', '28.6294016,77.119488', '2025-06-03 11:12:30');

-- --------------------------------------------------------

--
-- Table structure for table `receipt`
--

CREATE TABLE `receipt` (
  `id` int(11) NOT NULL,
  `receipt_id` varchar(15) NOT NULL,
  `amount` decimal(10,2) DEFAULT NULL,
  `comment` text DEFAULT NULL,
  `payment_mode` varchar(50) DEFAULT NULL,
  `pay_date` date DEFAULT NULL,
  `createOn` timestamp NOT NULL DEFAULT current_timestamp(),
  `role_number` varchar(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipt`
--

INSERT INTO `receipt` (`id`, `receipt_id`, `amount`, `comment`, `payment_mode`, `pay_date`, `createOn`, `role_number`) VALUES
(1, 'INF-00001', 4000.00, 'test', 'Cash', '2024-08-17', '2024-08-17 05:44:47', 'INF-0001'),
(2, 'INF-00002', 6000.00, 'test', 'Cash', '2025-06-01', '2025-06-02 16:38:07', 'INF-0002'),
(3, 'INF-00003', 1000.00, 'test', 'Cash', '2025-06-01', '2025-06-02 16:40:42', 'INF-0003'),
(4, 'INF-00004', 1000.00, 'test', 'Online', '2025-06-03', '2025-06-02 16:41:00', 'INF-0003'),
(5, 'INF-00005', 1000.00, 'test', 'Cash', '2025-06-10', '2025-06-02 16:41:21', 'INF-0003');

--
-- Triggers `receipt`
--
DELIMITER $$
CREATE TRIGGER `before_insert_receipt` BEFORE INSERT ON `receipt` FOR EACH ROW BEGIN
    INSERT INTO receipt_ids VALUES (NULL);
    SET NEW.receipt_id = CONCAT('INF-', LPAD(LAST_INSERT_ID(), 5, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `receipt_ids`
--

CREATE TABLE `receipt_ids` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `receipt_ids`
--

INSERT INTO `receipt_ids` (`id`) VALUES
(1),
(2),
(3),
(4),
(5);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `student_id` int(11) NOT NULL,
  `role_number` varchar(50) DEFAULT NULL,
  `first_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(50) DEFAULT NULL,
  `date_of_birth` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `phone` varchar(15) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `course_name` varchar(100) DEFAULT NULL,
  `pincode` varchar(10) DEFAULT NULL,
  `center_name` varchar(120) DEFAULT NULL,
  `instalment` decimal(10,2) DEFAULT NULL,
  `total_amount` decimal(10,2) DEFAULT NULL,
  `profile` text DEFAULT NULL,
  `createBy` int(11) NOT NULL,
  `status` varchar(15) NOT NULL,
  `enrollment_date` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`student_id`, `role_number`, `first_name`, `last_name`, `date_of_birth`, `gender`, `email`, `phone`, `address`, `course_name`, `pincode`, `center_name`, `instalment`, `total_amount`, `profile`, `createBy`, `status`, `enrollment_date`) VALUES
(2, 'INF-0002', 'Mohd', 'Abid', '2025-06-02', 'Male', 'mohdabid310507@gmail.com', '07376510013', 'Teliyabagh Varanasi', '12th (PCM)', '221002', 'Adhartal', 5.00, 5000.00, 'uploads/Mohd_20250602220705.png', 3, 'Active', '02-06-2025'),
(3, 'INF-0003', 'Mohd', 'Sajid', '2025-06-01', 'Male', 'mohdabid310507@gmail.com', '07376510013', 'Teliyabagh Varanasi', '11th (Art)', '221002', 'Adhartal', 1200.00, 10000.00, 'uploads/Mohd_20250602221010.png', 3, 'Active', '02-06-2025');

--
-- Triggers `students`
--
DELIMITER $$
CREATE TRIGGER `firstAttendance` AFTER INSERT ON `students` FOR EACH ROW BEGIN
    DECLARE currentDate DATE;
    SET currentDate = CURDATE();

    INSERT INTO attendance (studentId, attendance, dateOfAttendance, center_name,create_by, createOn)
    VALUES (NEW.role_number, 'A', DATE_FORMAT(currentDate, '%d-%m-%Y'), NEW.center_name,NEW.createBy, NOW());
END
$$
DELIMITER ;
DELIMITER $$
CREATE TRIGGER `studentRoleNumber` BEFORE INSERT ON `students` FOR EACH ROW BEGIN
    INSERT INTO student_uid VALUES (NULL);
    SET NEW.role_number = CONCAT('INF-', LPAD(LAST_INSERT_ID(), 4, '0'));
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `student_uid`
--

CREATE TABLE `student_uid` (
  `student_uid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `student_uid`
--

INSERT INTO `student_uid` (`student_uid`) VALUES
(1),
(2),
(3);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `firstName` varchar(50) DEFAULT NULL,
  `lastName` varchar(50) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `address` text DEFAULT NULL,
  `role` varchar(50) DEFAULT NULL,
  `profile` text DEFAULT NULL,
  `center_name` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `firstName`, `lastName`, `email`, `password`, `address`, `role`, `profile`, `center_name`, `created_at`) VALUES
(3, 'Super', 'Admin', 'superadmin@gmail.com', '$2y$10$xv65clIOKg2zDZDV9/mbVu9A8nVg0JNL7vzdMLMneITX0HsyIfKFm', 'Teliyabagh Varanasi', 'admin', 'uploads/Super_20240817093121.png', 'All', '2024-06-29 11:41:48'),
(7, 'User', 'Adhartal', 'useradhartal@gmail.com', '$2y$10$EDkiKLeYFb0s3DKGR33X4OXm2oumz4elQyxjMqK3f12CQbSasmEIa', '1233 test', 'user', 'uploads/User_20240817093308.png', 'Adhartal', '2024-08-17 04:03:08'),
(8, 'user2', 'Rampur', 'user2@gmail.com', '$2y$10$pvk5OxrYJzoWS4kWPg/A7.fK4nwcXj/dKobZZa94sPkPw4MgjWRIq', 'test', 'user', 'uploads/user2_20240817111849.png', 'Rampur', '2024-08-17 05:48:50');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `instalment`
--
ALTER TABLE `instalment`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_logout`
--
ALTER TABLE `login_logout`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receipt`
--
ALTER TABLE `receipt`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `receipt_ids`
--
ALTER TABLE `receipt_ids`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`student_id`);

--
-- Indexes for table `student_uid`
--
ALTER TABLE `student_uid`
  ADD PRIMARY KEY (`student_uid`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `instalment`
--
ALTER TABLE `instalment`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `login_logout`
--
ALTER TABLE `login_logout`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `receipt`
--
ALTER TABLE `receipt`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `receipt_ids`
--
ALTER TABLE `receipt_ids`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `student_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `student_uid`
--
ALTER TABLE `student_uid`
  MODIFY `student_uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

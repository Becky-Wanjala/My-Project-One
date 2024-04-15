-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Apr 11, 2024 at 02:51 PM
-- Server version: 8.0.33
-- PHP Version: 8.1.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `syftware_lddt`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `id` int NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'myuser', '91dfd9ddb4198affc5c194cd8ce6d338fde470e2');

-- --------------------------------------------------------

--
-- Table structure for table `loanees`
--

CREATE TABLE `loanees` (
  `id` int NOT NULL,
  `id_number` varchar(20) COLLATE utf8mb4_general_ci NOT NULL,
  `full_name` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `amount_in_default` decimal(10,2) NOT NULL,
  `date_of_default` date NOT NULL,
  `gender` enum('male','female') COLLATE utf8mb4_general_ci NOT NULL,
  `loan_status` enum('defaulted','cleared') COLLATE utf8mb4_general_ci DEFAULT 'cleared'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `loanees`
--

INSERT INTO `loanees` (`id`, `id_number`, `full_name`, `amount_in_default`, `date_of_default`, `gender`, `loan_status`) VALUES
(36, '22334455', 'John Doe', 20000.00, '2024-04-10', 'male', 'defaulted'),
(37, '44556677', 'James Peru', 200.00, '2024-04-11', 'male', 'defaulted'),
(39, '35991842', 'maxmillian', 299.00, '2024-04-11', 'male', 'cleared'),
(40, '66778899', 'Wanja Ivy', 200.00, '2024-04-10', 'male', 'cleared');

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int NOT NULL,
  `user_id` int NOT NULL,
  `message` text COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `notifications`
--

INSERT INTO `notifications` (`id`, `user_id`, `message`, `created_at`) VALUES
(44, 36, 'A Loanee with ID number 22334455 is planning to relocate. Location: -1.2713984,36.8377856. Please take action.', '2024-04-10 21:42:41'),
(45, 36, 'A Loanee with ID number 22334455 is planning to relocate. Location: -1.2713984,36.8377856. Please take action.', '2024-04-10 21:46:04'),
(71, 37, 'A Loanee with ID number 44556677 is planning to relocate. Location: -1.277952,36.8377856. Please take action.', '2024-04-11 14:46:07'),
(73, 37, 'A Loanee with ID number 44556677 is planning to relocate. Location: -1.277952,36.8377856. Please take action.', '2024-04-11 14:50:07'),
(74, 40, 'Loan status for ID number 66778899 has been cleared or has no pending or defaulted loan. Location: -1.277952,36.8377856.', '2024-04-11 14:50:13');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `loanees`
--
ALTER TABLE `loanees`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id_number` (`id_number`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `loanees`
--
ALTER TABLE `loanees`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=75;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `notifications`
--
ALTER TABLE `notifications`
  ADD CONSTRAINT `notifications_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `loanees` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

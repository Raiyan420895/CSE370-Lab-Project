-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2026 at 07:32 PM
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
-- Database: `amardatabase`
--

-- --------------------------------------------------------

--
-- Table structure for table `alerts_system`
--

CREATE TABLE `alerts_system` (
  `alert_id` int(11) NOT NULL,
  `sender_id` int(11) DEFAULT NULL,
  `target_id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `alert_type` enum('Offer','Alert','Greeting','Payment') NOT NULL,
  `status` enum('Unread','Read') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `complaints`
--

CREATE TABLE `complaints` (
  `complaint_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `description` text NOT NULL,
  `complaint_status` enum('Open','In-progress','Resolved') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `equipments`
--

CREATE TABLE `equipments` (
  `e_id` int(11) NOT NULL,
  `e_name` varchar(100) NOT NULL,
  `warranty` date NOT NULL,
  `quantity` int(100) NOT NULL,
  `purchase_date` date NOT NULL,
  `managed_by` int(11) NOT NULL,
  `e_status` enum('Working','Under Maintenance') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `members_details`
--

CREATE TABLE `members_details` (
  `user_id` int(11) NOT NULL,
  `bmi` decimal(5,2) NOT NULL,
  `assigned_trainer_id` int(11) DEFAULT NULL,
  `join_date` date DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `members_details`
--

INSERT INTO `members_details` (`user_id`, `bmi`, `assigned_trainer_id`, `join_date`) VALUES
(10000006, 24.50, NULL, '2026-01-02'),
(10000008, 22.34, NULL, '2026-01-02'),
(10000009, 23.00, NULL, '2026-01-02');

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `payment_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `payment_date` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Paid','Pending','Failed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `rating_system`
--

CREATE TABLE `rating_system` (
  `rating_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `target_type` enum('trainer','equipment') NOT NULL,
  `target_id` int(11) NOT NULL,
  `stars` tinyint(1) NOT NULL,
  `comment` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `trainers_details`
--

CREATE TABLE `trainers_details` (
  `user_id` int(11) NOT NULL,
  `availability_status` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `trainers_details`
--

INSERT INTO `trainers_details` (`user_id`, `availability_status`) VALUES
(10000007, '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Table structure for table `trainer_specialization`
--

CREATE TABLE `trainer_specialization` (
  `user_id` int(11) NOT NULL,
  `specialization` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `Contact` varchar(20) NOT NULL,
  `Address` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `Gender` enum('Male','Female','Other') NOT NULL,
  `user_type` enum('admin','trainer','member') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `full_name`, `email`, `Contact`, `Address`, `password_hash`, `Gender`, `user_type`) VALUES
(10000001, 'admin vai', 'admin@gym.com', '01123123123', 'Badda, Dhaka', '$2a$12$lPByDxyDLQFqzaIjUks6B.6jt2MzLEcpDevK9IZkTWMnH61/gFLPi', 'Male', 'admin'),
(10000006, 'Raiyan Khan', 'raiyan.khan@gmail.com', '01843871177', 'Mohammadpur, Dhaka', '$2y$10$1HR/scIX9FKVZuXgzitiwupSKbASIz7DStSiatjmiYb8ol6KYKa9m', 'Male', 'member'),
(10000007, 'Mahdi Rahman', 'mahdi@gym.com', '01422324766', 'Mohakhali, Dhaka', '$2y$10$Tk2Ns.tiUnH29XL64bnZ5epNNr94vrSwqaBXsEa.ZL9x4s5P0clfW', 'Male', 'trainer'),
(10000008, 'Aryan Islam', 'aryan13@gmail.com', '01843488552', 'Dhanmondi, Dhaka', '$2y$10$klYtbShOU.3DALjjc9D5wO0KcJns27VWzWuTUZflc7qKgGynSRmru', 'Male', 'member'),
(10000009, 'Sadman Sakib', 'sadmansakib1534@gmail.com', '01533423555', 'TB Gate, Mohakhali, Dhaka', '$2y$10$qF1uFZ.L4CQl/Vs7kZPYl.cD/Lhdr05IoeB.aeKAcCRGUp02P3L6i', 'Male', 'member');

-- --------------------------------------------------------

--
-- Table structure for table `workout_plans`
--

CREATE TABLE `workout_plans` (
  `plan_id` int(11) NOT NULL,
  `member_id` int(11) NOT NULL,
  `trainer_id` int(11) DEFAULT NULL,
  `exercise_name` varchar(100) NOT NULL,
  `sets` int(11) NOT NULL,
  `reps` int(11) NOT NULL,
  `day_of_week` enum('Mon','Tue','Wed','Thu','Fri','Sat','Sun') NOT NULL,
  `status` enum('Pending','Completed') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `alerts_system`
--
ALTER TABLE `alerts_system`
  ADD PRIMARY KEY (`alert_id`),
  ADD KEY `sender_id` (`sender_id`),
  ADD KEY `target_id` (`target_id`);

--
-- Indexes for table `complaints`
--
ALTER TABLE `complaints`
  ADD PRIMARY KEY (`complaint_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `equipments`
--
ALTER TABLE `equipments`
  ADD PRIMARY KEY (`e_id`),
  ADD KEY `managed_by` (`managed_by`);

--
-- Indexes for table `members_details`
--
ALTER TABLE `members_details`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `fk_trainer_assign` (`assigned_trainer_id`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`payment_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `rating_system`
--
ALTER TABLE `rating_system`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `trainers_details`
--
ALTER TABLE `trainers_details`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `trainer_specialization`
--
ALTER TABLE `trainer_specialization`
  ADD PRIMARY KEY (`user_id`,`specialization`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `workout_plans`
--
ALTER TABLE `workout_plans`
  ADD PRIMARY KEY (`plan_id`),
  ADD KEY `member_id` (`member_id`),
  ADD KEY `trainer_id` (`trainer_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `alerts_system`
--
ALTER TABLE `alerts_system`
  MODIFY `alert_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `complaints`
--
ALTER TABLE `complaints`
  MODIFY `complaint_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `equipments`
--
ALTER TABLE `equipments`
  MODIFY `e_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `payment_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `rating_system`
--
ALTER TABLE `rating_system`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10000010;

--
-- AUTO_INCREMENT for table `workout_plans`
--
ALTER TABLE `workout_plans`
  MODIFY `plan_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `alerts_system`
--
ALTER TABLE `alerts_system`
  ADD CONSTRAINT `fk_alert_sender` FOREIGN KEY (`sender_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_alert_target` FOREIGN KEY (`target_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `complaints`
--
ALTER TABLE `complaints`
  ADD CONSTRAINT `member_complaints_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `equipments`
--
ALTER TABLE `equipments`
  ADD CONSTRAINT `member_usage` FOREIGN KEY (`managed_by`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `members_details`
--
ALTER TABLE `members_details`
  ADD CONSTRAINT `fk_member_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_trainer_assign` FOREIGN KEY (`assigned_trainer_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Constraints for table `payments`
--
ALTER TABLE `payments`
  ADD CONSTRAINT `member_payment_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constraints for table `rating_system`
--
ALTER TABLE `rating_system`
  ADD CONSTRAINT `fk_review_member` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trainers_details`
--
ALTER TABLE `trainers_details`
  ADD CONSTRAINT `fk_trainer_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `trainer_specialization`
--
ALTER TABLE `trainer_specialization`
  ADD CONSTRAINT `fk_specialization_trainer` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `workout_plans`
--
ALTER TABLE `workout_plans`
  ADD CONSTRAINT `fk_workout_member` FOREIGN KEY (`member_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_workout_trainer` FOREIGN KEY (`trainer_id`) REFERENCES `users` (`user_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

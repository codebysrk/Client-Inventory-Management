-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 17, 2024 at 06:24 PM
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
-- Database: `hardik_traders_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `client_inventory`
--

CREATE TABLE `client_inventory` (
  `id` int(11) NOT NULL,
  `client_id` varchar(50) NOT NULL,
  `client_name` varchar(255) NOT NULL,
  `contact_info` varchar(255) DEFAULT NULL,
  `inventory_received` text NOT NULL,
  `inventory_upload` text DEFAULT NULL,
  `received_date` date NOT NULL,
  `reported_issues` text DEFAULT NULL,
  `client_notes` text DEFAULT NULL,
  `assigned_technician` varchar(255) DEFAULT NULL,
  `deadline` date DEFAULT NULL,
  `estimated_amount` decimal(10,2) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `client_inventory`
--

INSERT INTO `client_inventory` (`id`, `client_id`, `client_name`, `contact_info`, `inventory_received`, `inventory_upload`, `received_date`, `reported_issues`, `client_notes`, `assigned_technician`, `deadline`, `estimated_amount`, `status`, `created_at`) VALUES
(14, 'ujqsyd', 'Akash', '888455', 'kjkj', 'uploads/ziyoulang-k13-freewolf-one-hand-gaming-keyboard-8-1000x1000h.jpg', '2024-09-17', 'drfhdrh', 'erherh', 'rohan', '2024-09-19', 554.00, 'completed', '2024-09-17 16:02:36'),
(15, 'kfuWx4', 'shahrukh', '455545', 'keyboard', 'uploads/ziyoulang-k13-freewolf-one-hand-gaming-keyboard-8-1000x1000h.jpg', '2024-09-17', 'uiehgiwreg', 'ewfjweg', 'Rajesh Singh', '2024-09-19', 5545.00, 'completed', '2024-09-17 16:04:21'),
(17, 'C002', 'Neha Sharma', 'neha.sharma@example.in', 'Monitor, Keyboard', 'uploads/istockphoto-144331985-170667a.jpg', '2024-09-02', 'Screen flickering', 'Urgent fix needed', 'Priya Verma', '2024-09-11', 200.00, 'pending', '2024-09-17 16:07:45'),
(18, 'C003', 'Arjun Singh', 'arjun.singh@example.in', 'Printer, Ink', 'uploads/OIP (1).jpeg', '2024-09-03', 'Paper jam', 'Resolve ASAP', 'Vikram Rao', '2024-09-12', 90.00, 'completed', '2024-09-17 16:07:45'),
(22, 'C007', 'Anil Jain', 'anil.jain@example.in', 'Camera', 'uploads/OIP.jpeg', '2024-09-07', 'Lens malfunction', 'Lens repair needed', 'Kavita Das', '2024-09-16', 300.00, 'pending', '2024-09-17 16:07:45');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `client_inventory`
--
ALTER TABLE `client_inventory`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `client_id` (`client_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `client_inventory`
--
ALTER TABLE `client_inventory`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

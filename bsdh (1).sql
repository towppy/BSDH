-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 14, 2025 at 08:20 AM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `bsdh`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `appointment_id` int(11) NOT NULL,
  `patient_id` int(11) DEFAULT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `appointment_date` date NOT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `id_image` varchar(255) DEFAULT NULL,
  `description` enum('Consultation','Dental','Prenatal') NOT NULL,
  `year` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `appointments`
--

INSERT INTO `appointments` (`appointment_id`, `patient_id`, `doctor_id`, `appointment_date`, `status`, `created_at`, `updated_at`, `full_name`, `email`, `id_image`, `description`, `year`) VALUES
(1, NULL, NULL, '2025-03-10', 'approved', '2025-03-08 02:36:11', '2025-03-12 13:08:45', 'aiagarcia', 'curly@gmail.com', 'id_image_67cbad1b3b10b9.31083583.jpg', '', ''),
(2, NULL, NULL, '2025-03-20', 'pending', '2025-03-08 02:37:02', '2025-03-08 02:37:02', 'aiagarcia', 'curly@gmail.com', 'id_image_67cbad4ec412c4.13104812.jpg', '', ''),
(3, NULL, NULL, '2025-03-10', 'pending', '2025-03-08 02:41:34', '2025-03-08 02:41:34', 'Aia Garcia', 'aia.garcia@gmail.com', 'id_image_67cbae5e56fc89.92653340.jpg', '', ''),
(4, NULL, NULL, '2025-03-10', 'pending', '2025-03-08 02:43:54', '2025-03-08 02:43:54', 'sample', 'sample@gmail.com', 'id_image_67cbaeea1b2772.31493401.jpg', '', ''),
(5, NULL, NULL, '2025-03-20', 'pending', '2025-03-08 02:49:43', '2025-03-08 02:49:43', 'aiagarcia', 'curly@gmail.com', 'id_image_67cbb047887048.01418223.jpg', '', ''),
(6, NULL, NULL, '2025-03-19', 'pending', '2025-03-08 04:42:44', '2025-03-08 04:42:44', 'Aia Garcia', 'curly@gmail.com', 'id_image_67cbcac4020135.84935390.jpg', '', ''),
(7, NULL, NULL, '2025-03-11', 'pending', '2025-03-08 12:02:32', '2025-03-08 12:02:32', 'Damien Edwards', 'de@gmail.com', 'id_image_67cc31d8d305d9.43258840.png', '', ''),
(8, NULL, NULL, '2025-03-26', 'pending', '2025-03-09 01:12:03', '2025-03-09 01:12:03', 'Mark Zuckerberg', 'mark@zuck.gmail.com', '../uploads/RobloxScreenShot20250303_094551743.png', '', ''),
(9, NULL, NULL, '2025-03-26', 'pending', '2025-03-09 01:12:58', '2025-03-09 01:12:58', 'Mark Zuckerberg', 'mark@zuck.gmail.com', '../uploads/RobloxScreenShot20250303_094551743.png', '', ''),
(10, NULL, NULL, '2025-03-18', 'pending', '2025-03-09 01:13:08', '2025-03-09 01:13:08', 'Mark Zuckerberg', 'curly@gmail.com', '../uploads/RobloxScreenShot20250303_094605636.png', '', ''),
(11, NULL, NULL, '2025-03-21', 'pending', '2025-03-09 03:05:22', '2025-03-09 03:05:22', 'Jac', 'jacques@gmail.com', '../uploads/RobloxScreenShot20250303_094605636.png', '', ''),
(12, NULL, NULL, '2025-03-21', 'pending', '2025-03-09 03:05:33', '2025-03-09 03:05:33', 'Jac', 'jacques@gmail.com', '../uploads/RobloxScreenShot20250303_094605636.png', '', ''),
(13, NULL, NULL, '2025-03-11', 'pending', '2025-03-09 03:07:36', '2025-03-09 03:07:36', 'Jac', 'jacques@gmail.com', '../uploads/RobloxScreenShot20250303_094605636.png', '', ''),
(18, NULL, NULL, '2025-03-21', 'pending', '2025-03-12 05:16:18', '2025-03-12 05:16:18', 'juan', 'juandelacruz@gmail.com', '../uploads/454892545_1548744962666722_4436511815071387689_n.png', '', ''),
(19, NULL, NULL, '2025-03-26', 'pending', '2025-03-12 13:02:34', '2025-03-12 13:02:34', 'Aia Garcia', 'aiagarciaa2205@gmail.com', '../uploads/RobloxScreenShot20250303_094551743.png', '', ''),
(20, NULL, NULL, '2025-03-21', 'pending', '2025-03-12 23:59:32', '2025-03-12 23:59:32', 'Markiplier', 'mark@gmail.com', '../uploads/RobloxScreenShot20250303_094605636.png', '', ''),
(21, NULL, NULL, '2025-03-27', 'completed', '2025-03-13 00:12:33', '2025-03-14 07:14:48', 'Aia Garcia', 'curly@gmail.com', '../uploads/RobloxScreenShot20250303_094551743.png', 'Dental', ''),
(22, NULL, NULL, '2025-03-21', 'approved', '2025-03-13 00:29:39', '2025-03-13 01:16:12', 'Maricarl Leano', 'mari@gmail.com', '../uploads/ID.jpg', 'Dental', ''),
(23, NULL, NULL, '2025-03-19', 'completed', '2025-03-13 00:32:02', '2025-03-14 02:44:59', 'Cristel Famini', 'cristel@gmail.com', '../uploads/ID.jpg', 'Prenatal', ''),
(24, NULL, NULL, '2025-04-03', 'completed', '2025-03-13 00:33:12', '2025-03-14 02:40:48', 'Herbert Ludwig', 'herbert@gmail.com', '../uploads/ID.jpg', 'Consultation', ''),
(25, NULL, NULL, '2025-03-28', 'approved', '2025-03-13 00:43:14', '2025-03-13 00:43:20', 'Mark Scout', 'marks@gmail.com', '../uploads/ID.jpg', 'Consultation', ''),
(26, NULL, NULL, '2025-04-05', 'completed', '2025-03-13 02:01:48', '2025-03-14 02:39:41', 'Aia Garcia', 'aia@gmail.com', '../uploads/ID.jpg', 'Consultation', ''),
(27, NULL, NULL, '2025-03-15', 'completed', '2025-03-13 02:18:35', '2025-03-14 02:45:32', 'Chynna Moreno', 'chi@gmail.com', '../uploads/ID.jpg', 'Dental', ''),
(28, NULL, NULL, '2025-03-24', 'approved', '2025-03-13 02:20:10', '2025-03-13 02:20:14', 'Aeron Canta', 'aeron@gmail.com', '../uploads/ID.jpg', 'Prenatal', ''),
(29, NULL, NULL, '2025-03-22', 'approved', '2025-03-13 02:45:44', '2025-03-13 02:45:51', 'Karl Jexel', 'kj@gmail.com', '../uploads/ID.jpg', 'Prenatal', ''),
(30, NULL, NULL, '2025-03-21', 'completed', '2025-03-13 10:30:28', '2025-03-14 07:15:25', 'Jeremy Willis', 'jwils@gmail.com', '../uploads/ID.jpg', 'Dental', ''),
(31, NULL, NULL, '2025-03-27', 'completed', '2025-03-13 10:43:29', '2025-03-14 02:36:22', 'Damien Edwards', 'DamienEd@gmail.com', '../uploads/ID.jpg', 'Consultation', ''),
(32, NULL, NULL, '2025-03-18', 'approved', '2025-03-14 04:40:11', '2025-03-14 04:40:26', 'Jacob Smith', 'jsmith@gmail.com', '../uploads/ID.jpg', 'Dental', ''),
(33, NULL, NULL, '2025-03-28', 'approved', '2025-03-14 04:43:40', '2025-03-14 07:13:40', 'Jannella Yumang', 'jyumang@gmail.com', '../uploads/ID.jpg', 'Prenatal', ''),
(34, NULL, NULL, '2025-04-02', 'approved', '2025-03-14 07:09:08', '2025-03-14 07:09:15', 'Dark Fischbach', 'd@gmail.com', '../uploads/ID.jpg', 'Consultation', '');

--
-- Triggers `appointments`
--
DELIMITER $$
CREATE TRIGGER `move_completed_to_patients` AFTER UPDATE ON `appointments` FOR EACH ROW BEGIN
    IF NEW.status = 'completed' THEN
        INSERT INTO patients (full_name, email, doctor_id, appointment_date, id_image, status, created_at, updated_at)
        VALUES (
            NEW.full_name, 
            NEW.email, 
            IFNULL(NEW.doctor_id, 0),  -- if doctor_id is NULL, set to 0
            NEW.appointment_date, 
            NEW.id_image, 
            NEW.status, 
            NEW.created_at, 
            NEW.updated_at
        );
    END IF;
END
$$
DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `category_id` int(11) NOT NULL,
  `category_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`category_id`, `category_name`) VALUES
(2, 'Diagnostic Equipment'),
(6, 'Imaging'),
(4, 'Laboratory Equipment'),
(1, 'Medical Devices'),
(5, 'Monitoring Devices'),
(3, 'Surgical Instruments');

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `doctor_id` int(11) NOT NULL,
  `id_number` varchar(50) NOT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `contact` varchar(50) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `department`
--

INSERT INTO `department` (`doctor_id`, `id_number`, `specialization`, `contact`, `email`, `created_at`) VALUES
(1, 'D1001', 'Cardiology', '09123456789', 'dr.adams@example.com', '2025-03-07 13:33:58'),
(2, 'D1002', 'Pediatrics', '09234567890', 'dr.baker@example.com', '2025-03-07 13:33:58'),
(3, 'D1003', 'Orthopedics', '09345678901', 'dr.clark@example.com', '2025-03-07 13:33:58'),
(4, 'D1004', 'Dermatology', '09456789012', 'dr.davis@example.com', '2025-03-07 13:33:58'),
(5, 'D1005', 'Neurology', '09567890123', 'dr.evans@example.com', '2025-03-07 13:33:58');

-- --------------------------------------------------------

--
-- Table structure for table `doctors`
--

CREATE TABLE `doctors` (
  `doctor_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `specialization` varchar(100) DEFAULT NULL,
  `contact` varchar(20) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `doctors`
--

INSERT INTO `doctors` (`doctor_id`, `user_id`, `specialization`, `contact`, `email`, `created_at`) VALUES
(1, 1, 'General', '', 'john.doe@example.com', '2025-03-14 05:17:33'),
(2, 4, 'General', '', 'emily.jones@example.com', '2025-03-14 05:17:33'),
(3, 8, 'General', '', 'jeremy.willis@example.com', '2025-03-14 05:17:33');

-- --------------------------------------------------------

--
-- Table structure for table `equipment`
--

CREATE TABLE `equipment` (
  `equipment_id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `type` varchar(100) DEFAULT NULL,
  `room` varchar(50) NOT NULL,
  `assigned_doctor_id` int(11) DEFAULT NULL,
  `status` enum('available','in use','maintenance','retired') DEFAULT 'available',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `category_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `equipment`
--

INSERT INTO `equipment` (`equipment_id`, `name`, `type`, `room`, `assigned_doctor_id`, `status`, `created_at`, `category_id`) VALUES
(1, 'ECG Machine', 'Diagnostic Equipment', 'Room 101', 1, 'available', '2025-03-07 13:33:58', NULL),
(2, 'X-ray Machine', 'Imaging', 'Room 102', 2, 'available', '2025-03-07 13:33:58', NULL),
(3, 'Ultrasound Machine', 'Imaging', 'Room 103', 3, 'available', '2025-03-07 13:33:58', NULL),
(4, 'Defibrillator', 'Monitoring Devices', 'Room 104', 4, 'available', '2025-03-07 13:33:58', NULL),
(5, 'Ventilator', 'Monitoring Devices', 'ICU 1', 5, 'available', '2025-03-07 13:33:58', NULL),
(6, 'Stethoscope', 'Diagnostic Equipment', 'Room 105', NULL, 'available', '2025-03-07 13:33:58', NULL),
(7, 'Blood Pressure Monitor', 'Monitoring Devices', 'Room 106', NULL, 'available', '2025-03-07 13:33:58', NULL),
(8, 'MRI Machine', 'Imaging', 'Room 107', 1, 'maintenance', '2025-03-07 13:33:58', NULL),
(9, 'Oxygen Concentrator', 'Diagnostic Equipment', 'Room 108', 2, 'available', '2025-03-07 13:33:58', NULL),
(10, 'Syringe Pump', 'Medical Devices', 'Room 109', 3, 'available', '2025-03-07 13:33:58', NULL),
(11, 'ECG Machine 1', 'Diagnostic Equipment', '', NULL, 'available', '2025-03-12 11:02:14', NULL),
(12, 'Stethoscope 1', 'Diagnostic Equipment', '', 1, 'in use', '2025-03-12 11:07:24', NULL),
(13, 'X-Ray Machine', 'Imaging', '', NULL, 'available', '2025-03-12 11:30:07', NULL),
(14, 'CT Scanner', 'Imaging', '', 5, 'in use', '2025-03-14 02:32:59', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `medical_records`
--

CREATE TABLE `medical_records` (
  `record_id` int(11) NOT NULL,
  `appointment_id` int(11) NOT NULL,
  `diagnosis` text DEFAULT NULL,
  `prescription` text DEFAULT NULL,
  `notes` text DEFAULT NULL,
  `file_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `doctor_id` int(11) NOT NULL,
  `appointment_type` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medical_records`
--

INSERT INTO `medical_records` (`record_id`, `appointment_id`, `diagnosis`, `prescription`, `notes`, `file_path`, `created_at`, `doctor_id`, `appointment_type`) VALUES
(1, 25, NULL, NULL, NULL, NULL, '2025-03-13 00:43:20', 0, 'General'),
(2, 1, 'Cancer', '20 grams of paracetamol', 'Visit hospital in 2 days again', '../uploads/WIN_20250122_10_08_06_Pro.jpg', '2025-03-13 00:53:44', 6, 'General'),
(3, 1, 'Cancer', '20 grams of paracetamol', 'Visit hospital in 2 days again', '../uploads/WIN_20250122_10_08_06_Pro.jpg', '2025-03-13 00:54:02', 6, 'General'),
(4, 22, NULL, NULL, NULL, NULL, '2025-03-13 01:16:12', 0, 'General'),
(5, 1, 'May sakit', '10 hours screen time everyday', 'Haha adik sa cellphone', '../uploads/WIN_20250214_09_01_43_Pro.jpg', '2025-03-13 01:23:10', 0, 'General'),
(6, 22, 'Tooth Decay', 'Tooth Extraction', ' Check on 5 days', '../uploads/medical report.jpg', '2025-03-13 01:59:04', 0, 'Dental'),
(7, 26, NULL, NULL, NULL, NULL, '2025-03-13 02:01:54', 0, NULL),
(8, 23, NULL, NULL, NULL, NULL, '2025-03-13 02:05:05', 0, NULL),
(9, 23, 'Buntis', 'Wala', 'Nice', '../uploads/medical report.jpg', '2025-03-13 02:14:36', 0, 'Prenatal'),
(10, 27, NULL, NULL, NULL, NULL, '2025-03-13 02:18:46', 0, NULL),
(11, 28, NULL, NULL, NULL, NULL, '2025-03-13 02:20:14', 0, NULL),
(12, 29, NULL, NULL, NULL, NULL, '2025-03-13 02:45:51', 0, NULL),
(13, 31, NULL, NULL, NULL, NULL, '2025-03-14 02:34:53', 0, NULL),
(14, 32, NULL, NULL, NULL, NULL, '2025-03-14 04:40:26', 0, NULL),
(15, 32, 'Gingivitis', 'Ointment', 'Come back tomorrow', '../uploads/medical report.jpg', '2025-03-14 06:41:05', 0, 'Dental'),
(16, 34, NULL, NULL, NULL, NULL, '2025-03-14 07:09:15', 0, NULL),
(17, 30, NULL, NULL, NULL, NULL, '2025-03-14 07:11:10', 0, NULL),
(18, 33, NULL, NULL, NULL, NULL, '2025-03-14 07:13:40', 0, NULL),
(19, 21, NULL, NULL, NULL, NULL, '2025-03-14 07:14:07', 0, NULL),
(20, 21, 'Teeth piercing her upper jaw', 'Braces', 'Visit every month', '../uploads/medical report.jpg', '2025-03-14 07:14:41', 0, 'Dental'),
(21, 30, 'Loose tooth', 'Need bago', 'Need bago', '../uploads/medical report.jpg', '2025-03-14 07:15:21', 0, 'Dental');

-- --------------------------------------------------------

--
-- Table structure for table `medicines`
--

CREATE TABLE `medicines` (
  `medicine_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `stock` int(11) NOT NULL,
  `expiration_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `medicines`
--

INSERT INTO `medicines` (`medicine_id`, `name`, `category`, `price`, `stock`, `expiration_date`) VALUES
(1, 'Paracetamol', 'Pain Reliever', 5.00, 100, '2026-08-15'),
(2, 'Amoxicillin', 'Antibiotic', 12.50, 50, '2025-12-20'),
(3, 'Loperamide', 'Anti-Diarrheal', 8.75, 75, '2027-05-10'),
(4, 'Cetirizine', 'Antihistamine', 7.00, 60, '2026-11-30'),
(5, 'Salbutamol', 'Bronchodilator', 15.00, 40, '2025-09-25'),
(6, 'Metformin', 'Diabetes', 20.00, 30, '2026-07-05'),
(7, 'Ibuprofen', 'Pain Reliever', 10.00, 80, '2025-06-18'),
(8, 'Losartan', 'Hypertension', 18.00, 55, '2027-03-12'),
(9, 'Omeprazole', 'Antacid', 14.00, 45, '2026-01-25'),
(10, 'Mefenamic Acid', 'Pain Reliever', 9.50, 90, '2025-04-22'),
(11, 'Ciprofloxacin', 'Antibiotic', 15.00, 10, '2025-03-22');

-- --------------------------------------------------------

--
-- Table structure for table `patients`
--

CREATE TABLE `patients` (
  `patient_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `doctor_id` int(11) DEFAULT NULL,
  `appointment_date` date DEFAULT NULL,
  `id_image` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT 'pending',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `patients`
--

INSERT INTO `patients` (`patient_id`, `full_name`, `email`, `doctor_id`, `appointment_date`, `id_image`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Aia Garcia', 'curly@gmail.com', 0, '2025-03-27', '../uploads/RobloxScreenShot20250303_094551743.png', 'completed', '2025-03-13 00:12:33', '2025-03-14 07:14:48'),
(2, 'Jeremy Willis', 'jwils@gmail.com', 0, '2025-03-21', '../uploads/ID.jpg', 'completed', '2025-03-13 10:30:28', '2025-03-14 07:15:25');

-- --------------------------------------------------------

--
-- Table structure for table `tokens`
--

CREATE TABLE `tokens` (
  `token_id` int(11) NOT NULL,
  `email` varchar(100) DEFAULT NULL,
  `token` varchar(255) DEFAULT NULL,
  `expires_at` datetime DEFAULT NULL,
  `status` enum('active','used') DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `id_number` varchar(50) NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `passwordtxt` text NOT NULL,
  `role` enum('master','admin','doctor','nurse') NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `id_number`, `name`, `email`, `password`, `passwordtxt`, `role`, `created_at`) VALUES
(1, 'U12345', 'John Doe', 'john.doe@example.com', '$2y$10$.23abuwzZAQhgsXX3hCBO.NDzMWp8CZOPUr84S1WPyYRde7sUZS16', '123', 'doctor', '2025-03-07 13:33:58'),
(2, 'ADM-2025004', 'Karl Jexel', 'karl.jexel@gmail.com', '$2y$10$EhMKoQSzrhhdgrSWjVrRi.4xeVXjywKE25kt0g.Uiyn14kmPy.ZYi', '123', 'admin', '2025-03-07 13:33:58'),
(3, 'U12347', 'Mark Taylor', 'mark.taylor@example.com', '$2y$10$.23abuwzZAQhgsXX3hCBO.NDzMWp8CZOPUr84S1WPyYRde7sUZS16', '123', 'nurse', '2025-03-07 13:33:58'),
(4, 'U12348', 'Emily Jones', 'emily.jones@example.com', '$2y$10$.23abuwzZAQhgsXX3hCBO.NDzMWp8CZOPUr84S1WPyYRde7sUZS16', '123', 'doctor', '2025-03-07 13:33:58'),
(5, 'U12349', 'Michael Brown', 'michael.brown@example.com', '$2y$10$.23abuwzZAQhgsXX3hCBO.NDzMWp8CZOPUr84S1WPyYRde7sUZS16', '123', 'nurse', '2025-03-07 13:33:58'),
(6, 'ADM-2025001', 'Aia Garcia', 'aia.garci@example.com', '$2y$10$.23abuwzZAQhgsXX3hCBO.NDzMWp8CZOPUr84S1WPyYRde7sUZS16', '123', 'master', '2025-03-09 00:30:15'),
(7, 'ADM-2025002', 'Chynna Moreno', 'chynna.moreno@gmail.com', '$2y$10$.23abuwzZAQhgsXX3hCBO.NDzMWp8CZOPUr84S1WPyYRde7sUZS16', '123', 'admin', '2025-03-09 01:01:16'),
(8, 'U12341', 'Jeremy Willis', 'jeremy.willis@example.com', '$2y$10$.23abuwzZAQhgsXX3hCBO.NDzMWp8CZOPUr84S1WPyYRde7sUZS16', '123', 'doctor', '2025-03-09 01:01:16'),
(9, 'U12342', 'Mikasa Ackerman', 'mikasa.ackerman@example.com', '$2y$10$.23abuwzZAQhgsXX3hCBO.NDzMWp8CZOPUr84S1WPyYRde7sUZS16', '123', 'nurse', '2025-03-09 01:01:16'),
(11, 'ADM-2025003', 'Aeron Jhon', 'aeron.jhon@example.com', '$2y$10$6O1V.JuhkdiSl1v5j.iUDutXXPdC8QRcUfUcAiN7wDrR4Uqu/4i5O', '123', 'admin', '2025-03-09 01:01:16');

--
-- Triggers `users`
--
DELIMITER $$
CREATE TRIGGER `after_doctor_insert` AFTER INSERT ON `users` FOR EACH ROW BEGIN
    IF NEW.role = 'doctor' THEN
        INSERT INTO doctors (user_id, specialization, contact, email)
        VALUES (NEW.user_id, 'General', '', NEW.email);
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`appointment_id`),
  ADD KEY `patient_id` (`patient_id`),
  ADD KEY `doctor_id` (`doctor_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`category_id`),
  ADD UNIQUE KEY `category_name` (`category_name`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`doctor_id`),
  ADD UNIQUE KEY `id_number` (`id_number`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `doctors`
--
ALTER TABLE `doctors`
  ADD PRIMARY KEY (`doctor_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `equipment`
--
ALTER TABLE `equipment`
  ADD PRIMARY KEY (`equipment_id`),
  ADD KEY `assigned_doctor_id` (`assigned_doctor_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD PRIMARY KEY (`record_id`),
  ADD KEY `appointment_id` (`appointment_id`);

--
-- Indexes for table `medicines`
--
ALTER TABLE `medicines`
  ADD PRIMARY KEY (`medicine_id`);

--
-- Indexes for table `patients`
--
ALTER TABLE `patients`
  ADD PRIMARY KEY (`patient_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `tokens`
--
ALTER TABLE `tokens`
  ADD PRIMARY KEY (`token_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `id_number` (`id_number`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `appointment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `doctors`
--
ALTER TABLE `doctors`
  MODIFY `doctor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `equipment`
--
ALTER TABLE `equipment`
  MODIFY `equipment_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `medical_records`
--
ALTER TABLE `medical_records`
  MODIFY `record_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `medicines`
--
ALTER TABLE `medicines`
  MODIFY `medicine_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `patients`
--
ALTER TABLE `patients`
  MODIFY `patient_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tokens`
--
ALTER TABLE `tokens`
  MODIFY `token_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `appointments`
--
ALTER TABLE `appointments`
  ADD CONSTRAINT `appointments_ibfk_1` FOREIGN KEY (`patient_id`) REFERENCES `patients` (`patient_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `appointments_ibfk_2` FOREIGN KEY (`doctor_id`) REFERENCES `department` (`doctor_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `appointments_ibfk_3` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `appointments_ibfk_4` FOREIGN KEY (`doctor_id`) REFERENCES `doctors` (`doctor_id`) ON DELETE SET NULL;

--
-- Constraints for table `doctors`
--
ALTER TABLE `doctors`
  ADD CONSTRAINT `doctors_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `equipment`
--
ALTER TABLE `equipment`
  ADD CONSTRAINT `equipment_ibfk_1` FOREIGN KEY (`assigned_doctor_id`) REFERENCES `department` (`doctor_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `equipment_ibfk_2` FOREIGN KEY (`category_id`) REFERENCES `categories` (`category_id`) ON DELETE SET NULL;

--
-- Constraints for table `medical_records`
--
ALTER TABLE `medical_records`
  ADD CONSTRAINT `medical_records_ibfk_1` FOREIGN KEY (`appointment_id`) REFERENCES `appointments` (`appointment_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

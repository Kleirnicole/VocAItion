-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Nov 29, 2025 at 08:44 PM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `vocaition_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `ai_recommendations`
--

DROP TABLE IF EXISTS `ai_recommendations`;
CREATE TABLE IF NOT EXISTS `ai_recommendations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `survey_id` int NOT NULL,
  `confidence_score` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `recommended_career` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `recommended_description` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `suggested_career` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `suggested_score` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `date_generated` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `survey_id` (`survey_id`)
) ENGINE=MyISAM AUTO_INCREMENT=38 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `ai_recommendations`
--

INSERT INTO `ai_recommendations` (`id`, `survey_id`, `confidence_score`, `recommended_career`, `recommended_description`, `suggested_career`, `suggested_score`, `date_generated`) VALUES
(1, 3, '49.23', 'Social Work (BS Social Work)', 'Trains professionals for social service and community development.', 'Bachelor of Forensic Science (BFS)', '12.33', '2025-11-27 05:23:27'),
(2, 4, '37.03', 'Tourism Management (BSTM)', 'Focuses on the management of tourist attractions and travel services. ', 'Statistics (BS Stat)', '13.06', '2025-11-27 05:41:47'),
(3, 5, '37.03', 'Tourism Management (BSTM)', 'Focuses on the management of tourist attractions and travel services. ', 'Statistics (BS Stat)', '13.6', '2025-11-27 05:48:07'),
(4, 6, '33.07', 'Accountancy (BSA)', 'One of the most popular programs, this course focuses on subjects related to financial reporting, au', 'Bachelor of Forensic Science (BFS)', '13.2', '2025-11-27 05:53:51'),
(5, 7, '33.07', 'Accountancy (BSA)', 'One of the most popular programs, this course focuses on subjects related to financial reporting, au', 'Bachelor of Forensic Science (BFS)', '12.66', '2025-11-27 06:01:45'),
(6, 8, '55.26', 'Accountancy (BSA)', 'One of the most popular programs, this course focuses on subjects related to financial reporting, au', 'Bachelor of Forensic Science (BFS)', '12.56', '2025-11-27 06:10:21'),
(7, 9, '79.22', 'Fine Arts (BFA)', 'A creative degree with majors in visual communication, painting, and sculpture.', 'Bachelor of Forensic Science (BFS)', '13.04', '2025-11-27 06:15:40'),
(8, 10, '55.26', 'Accountancy (BSA)', 'One of the most popular programs, this course focuses on subjects related to financial reporting, au', 'Bachelor of Forensic Science (BFS)', '12.91', '2025-11-27 06:34:17'),
(9, 11, '88.43', 'Chemical Engineering (BSChE)', 'Applies principles of chemistry and engineering to solve problems.', 'Bachelor of Forensic Science (BFS)', '12.65', '2025-11-27 06:43:52'),
(10, 13, '58.71', 'Psychology (AB/BS Psych)', 'A popular degree for those interested in human behavior, and a pre-med option.', 'Bachelor of Forensic Science (BFS)', '12.77', '2025-11-27 07:01:50'),
(11, 14, '85.98', 'Fisheries (BSFi)', 'Focuses on the management and cultivation of aquatic resources. ', 'Bachelor of Forensic Science (BFS)', '12.48', '2025-11-27 07:09:45'),
(12, 16, '49.23', 'Social Work (BS Social Work)', 'Trains professionals for social service and community development.', 'Bachelor of Forensic Science (BFS)', '12.39', '2025-11-27 07:24:06'),
(13, 17, '85.98', 'Fisheries (BSFi)', 'Focuses on the management and cultivation of aquatic resources. ', 'Bachelor of Forensic Science (BFS)', '12.71', '2025-11-27 07:34:21'),
(14, 18, '45.93', 'Fisheries (BSFi)', 'Focuses on the management and cultivation of aquatic resources. ', 'Bachelor of Forensic Science (BFS)', '12.3', '2025-11-27 07:40:33'),
(15, 19, '55.26', 'Accountancy (BSA)', 'One of the most popular programs, this course focuses on subjects related to financial reporting, au', 'Bachelor of Forensic Science (BFS)', '12.71', '2025-11-27 07:45:00'),
(16, 20, '82.31', 'Agro-Forestry (BSAF)', 'A blend of agriculture and forestry.', 'Bachelor of Forensic Science (BFS)', '12.56', '2025-11-27 07:51:35'),
(17, 21, '33.07', 'Accountancy (BSA)', 'One of the most popular programs, this course focuses on subjects related to financial reporting, au', 'Bachelor of Forensic Science (BFS)', '12.73', '2025-11-27 07:57:09'),
(18, 22, '82.31', 'Agro-Forestry (BSAF)', 'A blend of agriculture and forestry.', 'Bachelor of Forensic Science (BFS)', '12.69', '2025-11-27 08:01:23'),
(19, 23, '33.07', 'Accountancy (BSA)', 'One of the most popular programs, this course focuses on subjects related to financial reporting, au', 'Bachelor of Forensic Science (BFS)', '12.61', '2025-11-27 08:10:44'),
(20, 24, '39.78', 'Entertainment and Multimedia Computing (BS EMC)', 'Covers game development and animation.', 'Bachelor of Forensic Science (BFS)', '12.25', '2025-11-27 08:34:12'),
(21, 25, '37.03', 'Tourism Management (BSTM)', 'Focuses on the management of tourist attractions and travel services. ', 'Bachelor of Forensic Science (BFS)', '13.28', '2025-11-27 08:39:46'),
(22, 26, '55.26', 'Accountancy (BSA)', 'One of the most popular programs, this course focuses on subjects related to financial reporting, au', 'Statistics (BS Stat)', '13.26', '2025-11-27 08:45:11'),
(23, 27, '55.26', 'Accountancy (BSA)', 'One of the most popular programs, this course focuses on subjects related to financial reporting, au', 'Bachelor of Forensic Science (BFS)', '12.37', '2025-11-28 12:36:30'),
(24, 29, '33.07', 'Accountancy (BSA)', 'One of the most popular programs, this course focuses on subjects related to financial reporting, au', 'Bachelor of Forensic Science (BFS)', '12.87', '2025-11-28 12:49:56'),
(25, 30, '43.62', 'Electrical Engineering (BSEE)', 'Specializes in the study of electricity and electronic systems.', 'Bachelor of Forensic Science (BFS)', '12.33', '2025-11-28 12:55:34'),
(26, 31, '79.22', 'Fine Arts (BFA)', 'A creative degree with majors in visual communication, painting, and sculpture.', 'Bachelor of Forensic Science (BFS)', '12.46', '2025-11-28 13:49:00'),
(27, 32, '88.43', 'Chemical Engineering (BSChE)', 'Applies principles of chemistry and engineering to solve problems.', 'Bachelor of Forensic Science (BFS)', '13.13', '2025-11-28 14:00:01'),
(28, 33, '43.62', 'Electrical Engineering (BSEE)', 'Specializes in the study of electricity and electronic systems.', 'Bachelor of Forensic Science (BFS)', '13.26', '2025-11-28 14:12:25'),
(29, 34, '13.1', 'Statistics (BS Stat)', 'Deals with the collection, analysis, and interpretation of data.', 'Accountancy (BSA)', '10', '2025-11-28 19:00:09'),
(30, 35, '17', 'Real Estate Management (BSREM)', 'Focuses on managing and investing in real estate. ', 'Bachelor of Forensic Science (BFS)', '12.39', '2025-11-28 19:06:42'),
(31, 36, '47', 'Chemical Engineering (BSChE)', 'Applies principles of chemistry and engineering to solve problems.', 'Bachelor of Forensic Science (BFS)', '13.13', '2025-11-28 19:21:40'),
(32, 37, '15', 'Legal Management', 'A pre-law course often offered by prestigious universities.', 'Chemical Engineering (BSChE)', '13', '2025-11-28 19:32:06'),
(33, 38, '15', 'Legal Management', 'A pre-law course often offered by prestigious universities.', 'Chemical Engineering (BSChE)', '13', '2025-11-28 19:49:03'),
(34, 39, '39', 'Accountancy (BSA)', 'One of the most popular programs, this course focuses on subjects related to financial reporting, au', 'Agro-Forestry (BSAF)', '8', '2025-11-28 19:54:38'),
(35, 40, '20', 'Fine Arts (BFA)', 'A creative degree with majors in visual communication, painting, and sculpture.', 'Chemical Engineering (BSChE)', '10', '2025-11-28 19:59:53'),
(36, 42, '23', 'Fisheries (BSFi)', 'Focuses on the management and cultivation of aquatic resources. ', 'Computer Science (BSCS)', '13', '2025-11-29 12:31:29'),
(37, 43, '28', 'Bachelor of Science in Accounting Information Systems (BSAIS)', 'Combines accounting principles with information technology to manage financial data.', 'Bachelor of Science in Cooperative Management', '7', '2025-11-29 13:03:57');

-- --------------------------------------------------------

--
-- Table structure for table `audit_logs`
--

DROP TABLE IF EXISTS `audit_logs`;
CREATE TABLE IF NOT EXISTS `audit_logs` (
  `id` int NOT NULL AUTO_INCREMENT,
  `user_id` int NOT NULL,
  `action` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `resource` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `details` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`)
) ENGINE=MyISAM AUTO_INCREMENT=49 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `audit_logs`
--

INSERT INTO `audit_logs` (`id`, `user_id`, `action`, `resource`, `details`, `created_at`) VALUES
(1, 8, 'Submit Survey', 'survey_answers', 'Submitted survey ID 1', '2025-11-27 05:05:56'),
(2, 8, 'Submit Survey', 'survey_answers', 'Submitted survey ID 2', '2025-11-27 05:08:12'),
(3, 22, 'Submit Survey', 'survey_answers', 'Submitted survey ID 3', '2025-11-27 05:22:44'),
(4, 23, 'Submit Survey', 'survey_answers', 'Submitted survey ID 4', '2025-11-27 05:41:12'),
(5, 25, 'Submit Survey', 'survey_answers', 'Submitted survey ID 5', '2025-11-27 05:47:32'),
(6, 24, 'Submit Survey', 'survey_answers', 'Submitted survey ID 6', '2025-11-27 05:53:17'),
(7, 26, 'Submit Survey', 'survey_answers', 'Submitted survey ID 7', '2025-11-27 06:01:10'),
(8, 28, 'Submit Survey', 'survey_answers', 'Submitted survey ID 8', '2025-11-27 06:09:42'),
(9, 27, 'Submit Survey', 'survey_answers', 'Submitted survey ID 9', '2025-11-27 06:15:01'),
(10, 29, 'Submit Survey', 'survey_answers', 'Submitted survey ID 10', '2025-11-27 06:33:42'),
(11, 31, 'Submit Survey', 'survey_answers', 'Submitted survey ID 11', '2025-11-27 06:43:15'),
(12, 34, 'Submit Survey', 'survey_answers', 'Submitted survey ID 12', '2025-11-27 06:59:00'),
(13, 34, 'Submit Survey', 'survey_answers', 'Submitted survey ID 13', '2025-11-27 07:01:10'),
(14, 11, 'Submit Survey', 'survey_answers', 'Submitted survey ID 14', '2025-11-27 07:09:11'),
(15, 35, 'Submit Survey', 'survey_answers', 'Submitted survey ID 15', '2025-11-27 07:20:15'),
(16, 35, 'Submit Survey', 'survey_answers', 'Submitted survey ID 16', '2025-11-27 07:23:25'),
(17, 36, 'Submit Survey', 'survey_answers', 'Submitted survey ID 17', '2025-11-27 07:33:45'),
(18, 37, 'Submit Survey', 'survey_answers', 'Submitted survey ID 18', '2025-11-27 07:39:52'),
(19, 13, 'Submit Survey', 'survey_answers', 'Submitted survey ID 19', '2025-11-27 07:44:24'),
(20, 7, 'Submit Survey', 'survey_answers', 'Submitted survey ID 20', '2025-11-27 07:51:00'),
(21, 10, 'Submit Survey', 'survey_answers', 'Submitted survey ID 21', '2025-11-27 07:56:32'),
(22, 12, 'Submit Survey', 'survey_answers', 'Submitted survey ID 22', '2025-11-27 08:00:47'),
(23, 38, 'Submit Survey', 'survey_answers', 'Submitted survey ID 23', '2025-11-27 08:10:11'),
(24, 16, 'Submit Survey', 'survey_answers', 'Submitted survey ID 24', '2025-11-27 08:33:38'),
(25, 19, 'Submit Survey', 'survey_answers', 'Submitted survey ID 25', '2025-11-27 08:39:01'),
(26, 18, 'Submit Survey', 'survey_answers', 'Submitted survey ID 26', '2025-11-27 08:44:38'),
(27, 420244, 'download_pdf', 'Career Report', 'MARY JESA DEMAISIP downloaded PDF for student Labesores, Ma. Lyra C.', '2025-11-27 09:09:51'),
(28, 6, 'Submit Survey', 'survey_answers', 'Submitted survey ID 27', '2025-11-28 12:35:49'),
(29, 4, 'Submit Survey', 'survey_answers', 'Submitted survey ID 28', '2025-11-28 12:48:49'),
(30, 4, 'Submit Survey', 'survey_answers', 'Submitted survey ID 29', '2025-11-28 12:49:24'),
(31, 14, 'Submit Survey', 'survey_answers', 'Submitted survey ID 30', '2025-11-28 12:55:02'),
(32, 9, 'Submit Survey', 'survey_answers', 'Submitted survey ID 31', '2025-11-28 13:48:22'),
(33, 5, 'Submit Survey', 'survey_answers', 'Submitted survey ID 32', '2025-11-28 13:59:29'),
(34, 15, 'Submit Survey', 'survey_answers', 'Submitted survey ID 33', '2025-11-28 14:11:55'),
(35, 121212, 'download_pdf', 'Career Report', 'k downloaded PDF for student Descallar, Ian Raphael B.', '2025-11-28 15:06:10'),
(36, 40, 'Submit Survey', 'survey_answers', 'Submitted survey ID 34', '2025-11-28 18:59:29'),
(37, 41, 'Submit Survey', 'survey_answers', 'Submitted survey ID 35', '2025-11-28 19:06:16'),
(38, 42, 'Submit Survey', 'survey_answers', 'Submitted survey ID 36', '2025-11-28 19:21:05'),
(39, 43, 'Submit Survey', 'survey_answers', 'Submitted survey ID 37', '2025-11-28 19:31:33'),
(40, 44, 'Submit Survey', 'survey_answers', 'Submitted survey ID 38', '2025-11-28 19:48:26'),
(41, 45, 'Submit Survey', 'survey_answers', 'Submitted survey ID 39', '2025-11-28 19:54:03'),
(42, 46, 'Submit Survey', 'survey_answers', 'Submitted survey ID 40', '2025-11-28 19:59:17'),
(43, 33, 'Submit Survey', 'survey_answers', 'Submitted survey ID 41', '2025-11-29 12:30:59'),
(44, 33, 'Submit Survey', 'survey_answers', 'Submitted survey ID 42', '2025-11-29 12:31:17'),
(45, 32, 'Submit Survey', 'survey_answers', 'Submitted survey ID 43', '2025-11-29 13:03:43'),
(46, 121212, 'download_pdf', 'Career Report', 'k downloaded PDF for student tr', '2025-11-29 14:05:03'),
(47, 121212, 'download_pdf', 'Career Report', 'k downloaded PDF for student tr', '2025-11-29 14:05:05'),
(48, 121212, 'print_report', 'Career Report', 'k printed report for student Capillan, Charlotte T.', '2025-11-29 14:41:32');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int NOT NULL AUTO_INCREMENT,
  `course_name` varchar(255) NOT NULL,
  `course_code` varchar(50) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=57 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `course_name`, `course_code`, `created_at`) VALUES
(1, 'Accountancy', 'BSA', '2025-11-29 09:47:37'),
(2, 'Business Administration', 'BSBA', '2025-11-29 09:47:37'),
(3, 'Entrepreneurship', 'BSE', '2025-11-29 09:47:37'),
(4, 'Real Estate Management', 'BSREM', '2025-11-29 09:47:37'),
(5, 'Financial Management', NULL, '2025-11-29 09:47:37'),
(6, 'Bachelor of Science in Agribusiness', NULL, '2025-11-29 09:47:37'),
(7, 'Bachelor of Science in Cooperative Management', NULL, '2025-11-29 09:47:37'),
(8, 'Legal Management', NULL, '2025-11-29 09:47:37'),
(9, 'Customs Administration', 'BSCA', '2025-11-29 09:47:37'),
(10, 'Hotel and Restaurant Management', 'BSHRM', '2025-11-29 09:47:37'),
(11, 'Tourism Management', 'BSTM', '2025-11-29 09:47:37'),
(12, 'Bachelor of Science in Hospitality Management', 'BSHM', '2025-11-29 09:47:37'),
(13, 'Civil Engineering', 'BSCE', '2025-11-29 09:47:37'),
(14, 'Electrical Engineering', 'BSEE', '2025-11-29 09:47:37'),
(15, 'Computer Engineering', 'BSCPE', '2025-11-29 09:47:37'),
(16, 'Electronics Engineering', 'BSECE', '2025-11-29 09:47:37'),
(17, 'Geodetic Engineering', 'BSGE', '2025-11-29 09:47:37'),
(18, 'Biology', 'BS Bio', '2025-11-29 09:47:37'),
(19, 'Chemistry', 'BS Chem', '2025-11-29 09:47:37'),
(20, 'Mathematics', 'BS Math', '2025-11-29 09:47:37'),
(21, 'Environmental Science', 'BSES', '2025-11-29 09:47:37'),
(22, 'Statistics', 'BS Stat', '2025-11-29 09:47:37'),
(23, 'Bachelor of Forensic Science', 'BFS', '2025-11-29 09:47:37'),
(24, 'Mechanical Engineering', 'BSME', '2025-11-29 09:47:37'),
(25, 'Agro-Forestry', 'BSAF', '2025-11-29 09:47:37'),
(26, 'Chemical Engineering', 'BSChE', '2025-11-29 09:47:37'),
(27, 'Industrial Engineering', 'BSIE', '2025-11-29 09:47:37'),
(28, 'Economics', 'AB/BS Econ', '2025-11-29 09:47:37'),
(29, 'Marine Engineering', 'BSMarE', '2025-11-29 09:47:37'),
(30, 'Architecture', 'BS Arch', '2025-11-29 09:47:37'),
(31, 'Nursing', 'BSN', '2025-11-29 09:47:37'),
(32, 'Medical Technology / Medical Laboratory Science', 'BS MedTech', '2025-11-29 09:47:37'),
(33, 'Radiologic Technology', 'BSRadTech', '2025-11-29 09:47:37'),
(34, 'Pharmacy', 'BS Pharm', '2025-11-29 09:47:37'),
(35, 'Physical Therapy', 'BSPT', '2025-11-29 09:47:37'),
(36, 'Psychology', 'AB/BS Psych', '2025-11-29 09:47:37'),
(37, 'Nutrition and Dietetics', 'BSND', '2025-11-29 09:47:37'),
(38, 'Information Technology', 'BSIT', '2025-11-29 09:47:37'),
(39, 'Information Systems', 'BSIS', '2025-11-29 09:47:37'),
(40, 'Computer Science', 'BSCS', '2025-11-29 09:47:37'),
(41, 'Entertainment and Multimedia Computing', 'BS EMC', '2025-11-29 09:47:37'),
(42, 'Library and Information Science', 'BLIS', '2025-11-29 09:47:37'),
(43, 'Education', NULL, '2025-11-29 09:47:37'),
(44, 'Social Work', 'BS Social Work', '2025-11-29 09:47:37'),
(45, 'Communication', 'AB Comm', '2025-11-29 09:47:37'),
(46, 'Bachelor of Arts in English', NULL, '2025-11-29 09:47:37'),
(47, 'Political Science', 'AB Pol Sci', '2025-11-29 09:47:37'),
(48, 'Fine Arts', 'BFA', '2025-11-29 09:47:37'),
(49, 'Agriculture', 'BSA', '2025-11-29 09:47:37'),
(50, 'Fisheries', 'BSFi', '2025-11-29 09:47:37'),
(51, 'Criminology', 'BS Crim', '2025-11-29 09:47:37'),
(52, 'Technology and Livelihood Education', 'BTLED', '2025-11-29 09:47:37'),
(53, 'Public Safety', 'BSPS', '2025-11-29 09:47:37'),
(54, 'Industrial Security Management', NULL, '2025-11-29 09:47:37'),
(55, 'Accounting Information Systems', 'BSAIS', '2025-11-29 09:47:37'),
(56, 'Diploma in Midwifery', NULL, '2025-11-29 09:47:37');

-- --------------------------------------------------------

--
-- Table structure for table `guidance_council`
--

DROP TABLE IF EXISTS `guidance_council`;
CREATE TABLE IF NOT EXISTS `guidance_council` (
  `id` int NOT NULL AUTO_INCREMENT,
  `faculty_id` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `office_location` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `position` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `profile_image` int NOT NULL,
  PRIMARY KEY (`id`),
  KEY `faculty_id` (`faculty_id`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `guidance_council`
--

INSERT INTO `guidance_council` (`id`, `faculty_id`, `full_name`, `email`, `password`, `office_location`, `position`, `created_at`, `updated_at`, `status`, `profile_image`) VALUES
(1, '121212', 'k', 'k@gmail.com', '$2y$10$d3koVbJN0p.OSKKteakuauWCn1nkjzT0/thwNJuoglYkBMz7j5BxK', 'SNHS Senior High School Guidance Office', 'Guidance Counselor', '2025-11-26 20:58:49', '2025-11-27 04:59:22', 'Active', 0),
(2, '420244', 'MARY JESA DEMAISIP', 'maryjesa.demaisip@deped.gov.ph', '$2y$10$vk9SQUg5oqwqOA1zYK8B7e1YM2FumKkcgRA6yyqpLK1XW3b.CxUgq', 'SNHS Junior High School Guidance Office', 'Guidance Coordinator', '2025-11-27 01:06:54', '2025-11-27 09:18:53', 'Active', 0),
(3, '258079', 'Edilyn Jane', 'dilayn4@gmail.com', '$2y$10$nxUnWPOEOW62pCEQUxQ9FOYoPYPtbCksq7Nq403pWhjnoo/3pZqXG', 'SNHS Senior High School Guidance Office', 'Guidance Coordinator', '2025-11-27 21:37:51', '2025-11-28 05:38:31', 'Active', 0),
(4, '112233', 'x', 'x@gmail.com', '$2y$10$yHcC39VcZrQgVJpE5vQQzuHCjDkJ3BP8xlzmq6EUzV3AKwfUx./Ie', 'Guidance Office', 'Guidance Counselor', '2025-11-28 08:53:01', '2025-11-28 16:54:01', 'Active', 0);

-- --------------------------------------------------------

--
-- Table structure for table `pending_registrations`
--

DROP TABLE IF EXISTS `pending_registrations`;
CREATE TABLE IF NOT EXISTS `pending_registrations` (
  `id` int NOT NULL AUTO_INCREMENT,
  `role` enum('student','counselor') NOT NULL,
  `full_name` varchar(255) DEFAULT NULL,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `lrn` varchar(20) DEFAULT NULL,
  `faculty_id` varchar(20) DEFAULT NULL,
  `birthdate` date DEFAULT NULL,
  `gender` varchar(10) DEFAULT NULL,
  `grade_level` varchar(20) DEFAULT NULL,
  `section` varchar(50) DEFAULT NULL,
  `guardian_contact` varchar(20) DEFAULT NULL,
  `strand` varchar(100) DEFAULT NULL,
  `office_location` varchar(100) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Table structure for table `riasec_scores`
--

DROP TABLE IF EXISTS `riasec_scores`;
CREATE TABLE IF NOT EXISTS `riasec_scores` (
  `id` int NOT NULL AUTO_INCREMENT,
  `answer_id` int NOT NULL,
  `realistic` int DEFAULT '0',
  `investigative` int DEFAULT '0',
  `artistic` int DEFAULT '0',
  `social` int DEFAULT '0',
  `enterprising` int DEFAULT '0',
  `conventional` int DEFAULT '0',
  `top_3_types` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `answer_id` (`answer_id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `riasec_scores`
--

INSERT INTO `riasec_scores` (`id`, `answer_id`, `realistic`, `investigative`, `artistic`, `social`, `enterprising`, `conventional`, `top_3_types`, `created_at`, `updated_at`) VALUES
(1, 1, 5, 4, 4, 7, 6, 7, 'S,C,E', '2025-11-27 05:05:56', '2025-11-27 05:05:56'),
(2, 2, 5, 4, 4, 7, 6, 7, 'S,C,E', '2025-11-27 05:08:12', '2025-11-27 05:08:12'),
(3, 3, 5, 4, 4, 7, 6, 7, 'S,C,E', '2025-11-27 05:22:44', '2025-11-27 05:22:44'),
(4, 4, 4, 1, 2, 6, 5, 3, 'S,E,R', '2025-11-27 05:41:12', '2025-11-27 05:41:12'),
(5, 5, 3, 0, 2, 3, 5, 2, 'E,R,S', '2025-11-27 05:47:32', '2025-11-27 05:47:32'),
(6, 6, 4, 3, 4, 7, 4, 3, 'S,R,A', '2025-11-27 05:53:17', '2025-11-27 05:53:17'),
(7, 7, 6, 4, 7, 7, 5, 6, 'A,S,R', '2025-11-27 06:01:10', '2025-11-27 06:01:10'),
(8, 8, 6, 3, 5, 7, 6, 7, 'S,C,R', '2025-11-27 06:09:42', '2025-11-27 06:09:42'),
(9, 9, 3, 6, 5, 5, 7, 4, 'E,I,A', '2025-11-27 06:15:01', '2025-11-27 06:15:01'),
(10, 10, 6, 5, 3, 6, 3, 6, 'R,S,C', '2025-11-27 06:33:42', '2025-11-27 06:33:42'),
(11, 11, 5, 7, 4, 3, 2, 3, 'I,R,A', '2025-11-27 06:43:15', '2025-11-27 06:43:15'),
(12, 12, 3, 5, 4, 5, 6, 5, 'E,I,S', '2025-11-27 06:59:00', '2025-11-27 06:59:00'),
(13, 13, 3, 5, 4, 5, 6, 5, 'E,I,S', '2025-11-27 07:01:10', '2025-11-27 07:01:10'),
(14, 14, 5, 6, 5, 7, 5, 7, 'S,C,I', '2025-11-27 07:09:11', '2025-11-27 07:09:11'),
(15, 15, 4, 5, 1, 6, 7, 7, 'E,C,S', '2025-11-27 07:20:15', '2025-11-27 07:20:15'),
(16, 16, 4, 5, 1, 6, 7, 7, 'E,C,S', '2025-11-27 07:23:25', '2025-11-27 07:23:25'),
(17, 17, 3, 4, 2, 4, 3, 7, 'C,I,S', '2025-11-27 07:33:45', '2025-11-27 07:33:45'),
(18, 18, 4, 7, 6, 5, 3, 7, 'I,C,A', '2025-11-27 07:39:52', '2025-11-27 07:39:52'),
(19, 19, 5, 5, 5, 6, 3, 7, 'C,S,R', '2025-11-27 07:44:24', '2025-11-27 07:44:24'),
(20, 20, 5, 7, 5, 6, 1, 5, 'I,S,R', '2025-11-27 07:51:00', '2025-11-27 07:51:00'),
(21, 21, 6, 4, 5, 7, 5, 5, 'S,R,A', '2025-11-27 07:56:32', '2025-11-27 07:56:32'),
(22, 22, 6, 7, 3, 6, 3, 6, 'I,R,S', '2025-11-27 08:00:47', '2025-11-27 08:00:47'),
(23, 23, 4, 4, 7, 5, 2, 4, 'A,S,R', '2025-11-27 08:10:11', '2025-11-27 08:10:11'),
(24, 24, 5, 4, 6, 5, 6, 5, 'A,E,R', '2025-11-27 08:33:38', '2025-11-27 08:33:38'),
(25, 25, 4, 3, 2, 7, 4, 4, 'S,R,E', '2025-11-27 08:39:01', '2025-11-27 08:39:01'),
(26, 26, 3, 2, 2, 4, 2, 5, 'C,S,R', '2025-11-27 08:44:38', '2025-11-27 08:44:38'),
(27, 27, 5, 4, 4, 6, 4, 7, 'C,S,R', '2025-11-28 12:35:49', '2025-11-28 12:35:49'),
(28, 28, 6, 4, 5, 5, 4, 4, 'R,A,S', '2025-11-28 12:48:49', '2025-11-28 12:48:49'),
(29, 29, 6, 4, 5, 5, 4, 4, 'R,A,S', '2025-11-28 12:49:24', '2025-11-28 12:49:24'),
(30, 30, 3, 7, 4, 5, 6, 7, 'I,C,E', '2025-11-28 12:55:02', '2025-11-28 12:55:02'),
(31, 31, 3, 7, 6, 4, 6, 5, 'I,A,E', '2025-11-28 13:48:22', '2025-11-28 13:48:22'),
(32, 32, 5, 5, 4, 3, 4, 4, 'R,I,A', '2025-11-28 13:59:29', '2025-11-28 13:59:29'),
(33, 33, 2, 4, 2, 1, 6, 6, 'E,C,I', '2025-11-28 14:11:55', '2025-11-28 14:11:55'),
(34, 34, 2, 3, 2, 3, 3, 6, 'C,I,S', '2025-11-28 18:59:29', '2025-11-28 18:59:29'),
(35, 35, 4, 5, 1, 6, 7, 7, 'E,C,S', '2025-11-28 19:06:16', '2025-11-28 19:06:16'),
(36, 36, 5, 5, 4, 3, 4, 4, 'R,I,A', '2025-11-28 19:21:05', '2025-11-28 19:21:05'),
(37, 37, 4, 3, 4, 7, 4, 3, 'S,R,A', '2025-11-28 19:31:33', '2025-11-28 19:31:33'),
(38, 38, 6, 4, 7, 7, 5, 6, 'A,S,R', '2025-11-28 19:48:26', '2025-11-28 19:48:26'),
(39, 39, 6, 3, 5, 7, 6, 7, 'S,C,R', '2025-11-28 19:54:03', '2025-11-28 19:54:03'),
(40, 40, 3, 6, 5, 5, 7, 4, 'E,I,A', '2025-11-28 19:59:17', '2025-11-28 19:59:17'),
(41, 41, 6, 3, 3, 2, 2, 4, 'R,C,I', '2025-11-29 12:30:59', '2025-11-29 12:30:59'),
(42, 42, 6, 3, 3, 2, 3, 4, 'R,C,I', '2025-11-29 12:31:17', '2025-11-29 12:31:17'),
(43, 43, 3, 3, 2, 2, 4, 6, 'C,E,R', '2025-11-29 13:03:43', '2025-11-29 13:03:43');

-- --------------------------------------------------------

--
-- Table structure for table `school`
--

DROP TABLE IF EXISTS `school`;
CREATE TABLE IF NOT EXISTS `school` (
  `id` int NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `location` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `school`
--

INSERT INTO `school` (`id`, `name`, `location`) VALUES
(1, 'State University of Northern Negros (SUNN)', 'Main Campus, Sagay City, Negros Occidental'),
(2, 'Carlos Hilado Memorial State University (CHMSU)', 'Talisay (Main) Campus, Talisay, Negros Occidental'),
(3, 'Central Philippines State University (CPSU)', 'Main Campus, Victorias City, Negros Occidental'),
(4, 'Philippine Normal University (PNU)', 'Cadiz City, Negros Occidental '),
(5, 'Technological University of the Philippines-Visayas (TUP-V)', 'Bacolod City, Talisay City, Sagay City, Binalbagan City, Negros Occidental '),
(6, 'Bacolod City College (BCC)', 'Bacolod City, Negros Occidental'),
(7, 'National University–Bacolod (NU-Bacolod)', 'Bacolod City, Negros Occidental'),
(8, 'STI West Negros University (STI WNU)', 'Private University, Bacolod City, Negros Occidental'),
(9, 'University of Negros Occidental–Recoletos (UNO-R)', ' Private University, Bacolod City, Negros Occidental'),
(10, 'University of St. La Salle (USLS)', 'Private University, La Salle Avenue, Bacolod City, Negros Occidental'),
(11, 'Central Philippine Adventist College', 'Private Christian College, Alegria, Murcia, Negros Occidental'),
(12, 'Colegio de Santa Ana de Victorias', 'Private Catholic Institution, Osmeña Avenue, Victorias City, Negros Occidental'),
(13, 'Colegio San Agustin–Bacolod (CSA-B)', 'Private College, Benigno S. Aquino Drive,Bacolod City, Negros Occidental'),
(14, 'Kabankalan Catholic College', 'Guanzon Street,Kabankalan City, Negros Occidental'),
(15, 'La Consolacion College Bacolod (LCC-B)', 'Private Catholic Institution, Bacolod City, Negros Occidental'),
(16, 'Mount Carmel College–Escalante', 'Escalante City, Negros Occidental'),
(17, 'Southland College', 'Private College, Don Emilio Village Phase One, Rizal Street, Kabankalan City, Negros Occidental'),
(18, 'VMA Global College ', 'Earl Carol St. in Sum-ag, Bacolod City, Negros Occidental'),
(19, 'John B. Lacson Colleges Foundation, Inc. (JBLCF-Bacolod)', 'Brgy. Alijis, Bacolod City, Negros Occidental'),
(20, 'ABE International Business College (ABE) - Bacolod', 'Luzuriaga Street in Bacolod City, Negros Occidental'),
(21, 'Silay Institute, Inc.', 'private, co-educational institution, Silay City, Negros Occidental'),
(22, 'Binalbagan Catholic College (BCC)', 'Private, Catholic institution, Binalbagan, Negros Occidental'),
(23, 'Fellowship Baptist College', 'Private, Baptist-affiliated institution, Rizal Street, Kabankalan City, Negros Occidental'),
(24, 'Silliman University', 'Private, Protestant research university, Dumaguete City, Negros Oriental'),
(25, 'Negros Oriental State University (NORSU)', 'Dumaguete City, Negros Oriental'),
(26, 'Foundation University', 'Private, non-sectarian university, Dumaguete City, Negros Oriental'),
(27, 'Riverside College', 'Private, non-sectarian college, Dr. Pablo O. Torre Sr. St., Barangay 5, in Bacolod City, Negros Occidental'),
(28, 'La Carlota City College (La Carlota City)', 'Gurrea Street , La Carlota City, Negros Occidental'),
(29, 'Asian College Dumaguete City', 'Dumaguete City, Negros Oriental'),
(30, 'Polytechnic University of the Philippines (PUP)', 'Outside Negros, Sta. Mesa, Manila'),
(31, 'University of Santo Tomas', 'Outside Negros,  Sampaloc, Manila'),
(32, 'Ateneo de Manila University ', 'Outside Negros, Manila'),
(33, 'Manuel L. Quezon University ', 'Outside Negros, 790 EDSA, Barangay South Triangle, Quezon City'),
(34, 'USAT College', 'Private College, Sagay City, Negros Occidental'),
(35, 'North Negros College (NNC)', 'Cadiz City, Negros Occidental'),
(36, 'Our Lady of Fatima University (Valenzuela)', 'Outside Negros, Valenzuela City, Metro Manila'),
(37, 'Philippine College of Criminology (Manila)', 'Outside Negros, 641 Sales Street, Quiapo, Manila'),
(38, 'University of Southern Mindanao (UM)', 'Outside Negros, Kabacan, Cotabato, Kidapawan City'),
(39, 'Manila Central University', 'Outside Negros, Caloocan City, Metro Manila'),
(40, 'University of the Philippines Visayas (UP-V)', 'Outside Negros, Public research university, Iloilo\r\n'),
(41, 'Philippine Public Safety College (PPSC)', 'Outside Negros, Camp Bagong Diwa, Taguig City, Metro Manila, and Quezon City.\r\n'),
(42, 'Philippine National Police Academy (PNPA)', 'Outside Negros, Camp Castañeda, Silang, Cavite\r\n'),
(43, 'King`s College of the Philippines (KCP)', 'Private Educational Institution, La Trinidad, Benguet\r\n');

-- --------------------------------------------------------

--
-- Table structure for table `school_offer`
--

DROP TABLE IF EXISTS `school_offer`;
CREATE TABLE IF NOT EXISTS `school_offer` (
  `id` int NOT NULL AUTO_INCREMENT,
  `school_id` int NOT NULL,
  `accountacy` tinyint(1) DEFAULT '0',
  `business_administration` tinyint(1) DEFAULT '0',
  `entrepreneurship` tinyint(1) DEFAULT '0',
  `real_estate_management` tinyint(1) DEFAULT '0',
  `financial_management` tinyint(1) DEFAULT '0',
  `agribusiness` tinyint(1) DEFAULT '0',
  `cooperative_management` tinyint(1) DEFAULT '0',
  `legal_management` tinyint(1) DEFAULT '0',
  `customs_administration` tinyint(1) DEFAULT '0',
  `hotel_restaurant_management` tinyint(1) DEFAULT '0',
  `tourism_management` tinyint(1) DEFAULT '0',
  `hospitality_management` tinyint(1) DEFAULT '0',
  `civil_engineering` tinyint(1) DEFAULT '0',
  `electrical_engineering` tinyint(1) DEFAULT '0',
  `computer_engineering` tinyint(1) DEFAULT '0',
  `electronics_engineering` tinyint(1) DEFAULT '0',
  `geodetic_engineering` tinyint(1) DEFAULT '0',
  `biology` tinyint(1) DEFAULT '0',
  `chemistry` tinyint(1) DEFAULT '0',
  `mathematics` tinyint(1) DEFAULT '0',
  `environmental_science` tinyint(1) DEFAULT '0',
  `statistics` tinyint(1) DEFAULT '0',
  `forensic_science` tinyint(1) DEFAULT '0',
  `mechanical_engineering` tinyint(1) DEFAULT '0',
  `agro_forestry` tinyint(1) DEFAULT '0',
  `chemical_engineering` tinyint(1) DEFAULT '0',
  `industrial_engineering` tinyint(1) DEFAULT '0',
  `economics` tinyint(1) DEFAULT '0',
  `marine_engineering` tinyint(1) DEFAULT '0',
  `architecture` tinyint(1) DEFAULT '0',
  `nursing` tinyint(1) DEFAULT '0',
  `medical_technology` tinyint(1) DEFAULT '0',
  `radiologic_technology` tinyint(1) DEFAULT '0',
  `pharmacy` tinyint(1) DEFAULT '0',
  `physical_therapy` tinyint(1) DEFAULT '0',
  `psychology` tinyint(1) DEFAULT '0',
  `nutrition_dietetics` tinyint(1) DEFAULT '0',
  `information_technology` tinyint(1) DEFAULT '0',
  `information_systems` tinyint(1) DEFAULT '0',
  `computer_science` tinyint(1) DEFAULT '0',
  `entertainment_multimedia_computing` tinyint(1) DEFAULT '0',
  `library_information_system` tinyint(1) DEFAULT '0',
  `education` tinyint(1) DEFAULT '0',
  `social_work` tinyint(1) DEFAULT '0',
  `communication` tinyint(1) DEFAULT '0',
  `arts_english` tinyint(1) DEFAULT '0',
  `political_science` tinyint(1) DEFAULT '0',
  `fine_arts` tinyint(1) DEFAULT '0',
  `agriculture` tinyint(1) DEFAULT '0',
  `fisheries` tinyint(1) DEFAULT '0',
  `criminology` tinyint(1) DEFAULT '0',
  `technology_livelihood` tinyint(1) DEFAULT '0',
  `public_safety` tinyint(1) DEFAULT '0',
  `industrial_security` tinyint(1) DEFAULT '0',
  `accounting_information_systems` tinyint(1) DEFAULT '0',
  `midwifery` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `school_id` (`school_id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `school_offer`
--

INSERT INTO `school_offer` (`id`, `school_id`, `accountacy`, `business_administration`, `entrepreneurship`, `real_estate_management`, `financial_management`, `agribusiness`, `cooperative_management`, `legal_management`, `customs_administration`, `hotel_restaurant_management`, `tourism_management`, `hospitality_management`, `civil_engineering`, `electrical_engineering`, `computer_engineering`, `electronics_engineering`, `geodetic_engineering`, `biology`, `chemistry`, `mathematics`, `environmental_science`, `statistics`, `forensic_science`, `mechanical_engineering`, `agro_forestry`, `chemical_engineering`, `industrial_engineering`, `economics`, `marine_engineering`, `architecture`, `nursing`, `medical_technology`, `radiologic_technology`, `pharmacy`, `physical_therapy`, `psychology`, `nutrition_dietetics`, `information_technology`, `information_systems`, `computer_science`, `entertainment_multimedia_computing`, `library_information_system`, `education`, `social_work`, `communication`, `arts_english`, `political_science`, `fine_arts`, `agriculture`, `fisheries`, `criminology`, `technology_livelihood`, `public_safety`, `industrial_security`, `accounting_information_systems`, `midwifery`) VALUES
(1, 1, 0, 1, 0, 0, 1, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1, 0, 1, 1, 1, 0, 0, 1, 0, 0, 1, 1, 1, 0, 0, 0, 1, 1),
(2, 2, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(3, 3, 1, 1, 0, 0, 0, 1, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 1, 0, 0, 0, 0),
(4, 4, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(5, 5, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(6, 6, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(7, 7, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(8, 8, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 1, 1, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 1, 1, 0, 1, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1),
(9, 9, 1, 1, 0, 1, 1, 0, 1, 0, 0, 1, 0, 1, 0, 1, 0, 1, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 1, 1, 0, 0, 0, 1, 0, 1, 0, 1, 1, 0, 1, 1, 1, 1, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0),
(10, 10, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 1, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 1, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(11, 11, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(12, 12, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0),
(13, 13, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0),
(14, 14, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(15, 15, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(16, 16, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(17, 17, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1),
(18, 18, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0),
(19, 19, 1, 0, 0, 0, 0, 0, 0, 0, 1, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(20, 20, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(21, 21, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(22, 22, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(23, 23, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0),
(24, 24, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(25, 25, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(26, 26, 1, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(27, 27, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0),
(28, 28, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0),
(29, 29, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(30, 30, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(31, 31, 0, 0, 1, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(32, 32, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(33, 33, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(34, 34, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(35, 35, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(36, 36, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(37, 37, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(38, 38, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(39, 39, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0),
(40, 40, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0, 0, 0),
(41, 41, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0),
(42, 42, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0, 0),
(43, 43, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 1, 0, 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

DROP TABLE IF EXISTS `students`;
CREATE TABLE IF NOT EXISTS `students` (
  `id` int NOT NULL AUTO_INCREMENT,
  `lrn` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `full_name` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `birthdate` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `gender` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `grade_level` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `section` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `guardian_contact` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `strand` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `profile_image` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `school_year` varchar(20) DEFAULT '2025-2026',
  `career_choice` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lrn` (`lrn`)
) ENGINE=MyISAM AUTO_INCREMENT=47 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `lrn`, `full_name`, `email`, `password`, `birthdate`, `gender`, `grade_level`, `section`, `guardian_contact`, `updated_at`, `created_at`, `status`, `strand`, `profile_image`, `school_year`, `career_choice`) VALUES
(1, '117712130008', 'Librando, Reahna C.', '', '$2y$10$6Mrro6HHw6frM03kaxxnfuSM.BZG2rZrl4gKmveoVz24FlmaC8vX6', '2008-09-07', 'Female', '12', 'Shakespeare', '09165449227', '2025-11-26 15:45:10', '2025-11-26 15:45:10', 'active', 'GAS', '', '2025-2026', NULL),
(2, '117721130301', 'De Asis, Wendy May I.', '', '$2y$10$AEzCn6bzln6poVFhKmbWE.apNkNGmynXHvgpXrTLaN93PxCpS22MO', '2008-05-22', 'Female', '12', 'Meyer', '09701989116', '2025-11-26 15:48:17', '2025-11-26 15:48:17', 'active', 'GAS', '', '2025-2026', NULL),
(3, '117696130083', 'Bacosa, Rene V.', 'rene3villaester@gmail.com', '$2y$10$pzHbY5sRviUgVjGFFnuSm.Ac4fK2oFraeWCnJKj8Hcvgn9Ub/reYK', '2008-02-14', 'Male', '12', 'Meyer', '', '2025-11-26 15:49:49', '2025-11-26 15:49:49', 'active', 'GAS', '', '2025-2026', NULL),
(4, '117724140001', 'Abellar, Brent Aaron R.', 'brentrojo1@gmail.com', '$2y$10$N7gezO3sugt9TVb9zyu15eqcVx8D.EXsunGEeAmUXxYnWa82f2c3m', '2008-09-13', 'Male', '12', 'Mozart', '09639011557', '2025-11-26 15:52:37', '2025-11-26 15:52:37', 'active', 'ARTS & DESIGN', '', '2025-2026', NULL),
(5, '700016190663', 'Crema, Sofia Margarette L.', 'margarettecrema@gmail.com', '$2y$10$fACvkM2UIl2yRaKwaFi3r.lQjmy2BKgPO3AL6IhwR1MMuBac/i002', '2007-08-27', 'Female', '12', 'Mozart', '', '2025-11-26 15:54:57', '2025-11-26 15:54:57', 'active', 'ARTS & DESIGN', '', '2025-2026', NULL),
(6, '117695130030', 'Ocha, Jhoros L.', '', '$2y$10$HvqWL.0dNA.74f4NU6jhSuXgkT9qqk0CP1Snrzsn3lbWnmzra/0fG', '2008-10-12', 'Male', '12', 'Mozart', '', '2025-11-28 12:38:45', '2025-11-26 16:00:07', 'active', 'ARTS & DESIGN', '692997d55d42a_WIN_20251011_20_33_10_Pro.jpg', '2025-2026', NULL),
(7, '117696140011', 'Villegas, Angelic Maxine S.', 'lzplayz583@gmail.com', '$2y$10$TYdR3LMuzlyqLj8XN5jV6uX61r6w/CPZV/4bCUemJ660caZBpQyEC', '2008-01-01', 'Female', '12', 'Newton', '09511667529', '2025-11-26 16:02:37', '2025-11-26 16:02:37', 'active', 'STEM', '', '2025-2026', NULL),
(22, '117693130038', 'Gelantagaan, Precious Anne L.', 'preciousagnes1903@gmail.com', '$2y$10$AkSSTve2S6e1uNkqrg6ibuO2HOqIhUFc8RWspuLwYexdkex1PAZNi', '2008-09-19', 'Female', '12', 'Newton', '09154945293', '2025-11-26 21:19:45', '2025-11-26 21:19:45', 'active', 'STEM', '', '2025-2026', NULL),
(9, '117697130014', 'Lumayno, Psyche Hope D.', 'psychehopelumayno362@gmail.com', '$2y$10$ZXLStqTH67uqp7Wxos/jQ.Tlgf9AcRRSDZ2vOWKXRbE/wQFolfVmy', '2008-09-13', 'Female', '12', 'Newton', '09638189582', '2025-11-26 16:07:02', '2025-11-26 16:07:02', 'active', 'STEM', '', '2025-2026', NULL),
(10, '117696130237', 'Saytas, Angel B.', 'saytasangel@gmail.com', '$2y$10$f7pCzSx8CPnMV8NEj3i/z.fXD8PfienUeQgJQ/3kzCC1RmL0IgQEe', '2008-05-22', 'Female', '12', 'Newton', '09272556385', '2025-11-26 16:08:50', '2025-11-26 16:08:50', 'active', 'STEM', '', '2025-2026', NULL),
(11, '117696140009', 'Barrientos, Septmarie Alexis P.', 'septmariealexisbarrientos@gmail.com', '$2y$10$6atsMwEag9qb5xy/nPtNMuirDjXmqWPlviPI0ozUe//IzUP228JRy', '2007-09-17', 'Female', '12', 'Newton', '09198183362', '2025-11-26 16:10:48', '2025-11-26 16:10:48', 'active', 'STEM', '', '2025-2026', NULL),
(12, '117402130069', 'Falcutila, Allyson C.', 'falcutilaallyson@gmail.com', '$2y$10$lgfoSWo2na1GYTODJqtyEeHso4VM6vw20MNoOWRAosZrjewDMd4Ei', '2008-05-10', 'Female', '12', 'Newton', '09052189473', '2025-11-26 16:12:15', '2025-11-26 16:12:15', 'active', 'STEM', '', '2025-2026', NULL),
(13, '117703130050', 'Bantigue, Shiekinah R.', 'shiekinahbantigue@gmail.com', '$2y$10$FP2HjunRONEEzfgYmAEdSOR8k5abn.XqmaWrA0cJZeXzmOajpXc6G', '2008-10-20', 'Female', '12', 'Newton', '09936365984', '2025-11-26 16:14:00', '2025-11-26 16:14:00', 'active', 'STEM', '', '2025-2026', NULL),
(14, '404199150031', 'Esmena, Lenold Daniel T.', '', '$2y$10$X2w58Vn6qYLyEArQ8n1meunms0Sm3MSoGZgxGVR1AvSe1Sk0rAsN.', '2007-02-04', 'Male', '12', 'Newton', '', '2025-11-26 16:16:25', '2025-11-26 16:16:25', 'active', 'STEM', '', '2025-2026', NULL),
(15, '125991130015', 'Descallar, Ian Raphael B.', 'iandescallar9@gmail.com', '$2y$10$YQGieiMWZdB9yOMu2IXRdOhFBRq2F3D3PWwNLwQN96/Oegh4sZNGa', '2007-12-02', 'Male', '12', 'Newton', '09512061542', '2025-11-26 16:18:15', '2025-11-26 16:18:15', 'active', 'STEM', '', '2025-2026', NULL),
(16, '117691140014', 'Navarro, Lance Raniel A.', '', '$2y$10$cwU3s.qerBwWy6YiKZjGSe5VhihEsuiS81ZoN4LyNMspOmkKVUaM6', '2008-01-20', 'Male', '12', 'Mozart', '', '2025-11-26 16:19:47', '2025-11-26 16:19:47', 'active', 'GAS', '', '2025-2026', NULL),
(17, '117415130066', 'Emparado, Reynor C.', '', '$2y$10$1bKvs2N.O.Wi/kX8v4P33OU/JlDywsdWj.HFjszaetMpXbpIUSVtO', '2007-11-17', 'Male', '12', 'Mozart', '09945338947', '2025-11-26 16:20:56', '2025-11-26 16:20:56', 'active', 'GAS', '', '2025-2026', NULL),
(18, '117709130046', 'Labesores, Ma. Lyra C.', '', '$2y$10$lpOo1GbY4CU8bA37cA.Dx.s2IYX8LrVOCmDgMC4QSBMKxk55e5mMi', '2008-07-09', 'Female', '12', 'Mozart', '09053075343', '2025-11-26 16:23:12', '2025-11-26 16:23:12', 'active', 'GAS', '', '2025-2026', NULL),
(19, '117692130100', 'Geronimo, Charmeil Dianne V.', '', '$2y$10$ZA8H9mFql95G68EQVQBD3uMH.zBz5EsdaYI6oAramFgk.HDqnRGIC', '2007-11-19', 'Female', '12', 'Mozart', '09639011838', '2025-11-26 16:24:56', '2025-11-26 16:24:56', 'active', 'GAS', '', '2025-2026', NULL),
(20, '117046130040', 'Ayuno, Van Russell A.', 'ayunovanrussell@gmail.com', '$2y$10$HF1nD2qpHq06c4lLSWcBseR93tKVo4Ga.UtVL5K26ON.C5H23JsSy', '2008-07-08', 'Male', '12', 'Mozart', '09070049316', '2025-11-26 16:26:53', '2025-11-26 16:26:53', 'active', 'GAS', '', '2025-2026', NULL),
(21, '117700130175', 'Legario, Matt A.', 'mattlegario@gmail.com', '$2y$10$CH0e4hPkabW9st8JABh5TefWjyUxtQc49BX5HXldz2aefDekDAX6a', '2008-05-25', 'Male', '12', 'Mozart', '09074655242', '2025-11-26 16:28:24', '2025-11-26 16:28:24', 'active', 'GAS', '', '2025-2026', NULL),
(23, '117696130266', 'Penafiel, Genie Ann S.', '', '$2y$10$ejGsfjkpgr5.qzHajP6bMelAYL.mGKC7vQi3Rh74EhPZBaqUV3x5y', '2008-07-07', 'Female', '12', 'Sheldo', '09638739954', '2025-11-26 21:31:02', '2025-11-26 21:31:02', 'active', 'GAS', '', '2025-2026', NULL),
(24, '117696130169', 'Flores, Ronel M.', '', '$2y$10$chyGx3YUfew8y2ef6leWtuAacX9JT41bwsN69EPLoaByzwTFDYoia', '2008-07-19', 'Male', '12', 'Sheldon', '', '2025-11-26 21:32:24', '2025-11-26 21:32:24', 'active', 'GAS', '', '2025-2026', NULL),
(25, '117695130021', 'Jairah Mae E. Tantiado', '', '$2y$10$J0wScDXrMXYI1BbQrs.TguIh5DXAMC2myWVm1cR5PutL2SorHxNfu', '', 'Female', '12', 'Sheldon', '09198119127', '2025-11-26 21:33:33', '2025-11-26 21:33:33', 'active', 'GAS', '', '2025-2026', NULL),
(26, '117700130342', 'Andrie Eullaine P. Arellano', '', '$2y$10$4puJoGAKfdAgO5W47YzjtuDstCdbJrzQlCUcY27nAliO5vC0ozjgK', '2008-07-06', 'Female', '12', 'Sheldon', '', '2025-11-26 21:34:36', '2025-11-26 21:34:36', 'active', 'GAS', '', '2025-2026', NULL),
(27, '117696150280', 'Christ T. Gillana Jr', '', '$2y$10$LF6ElHgoXypfrCMU3bNWX.8GVzkjGyMzIDPictnqArh4F3Be96Tum', '2008-07-08', 'Male', '12', 'Sheldon', '09278883593', '2025-11-26 21:36:48', '2025-11-26 21:36:48', 'active', 'GAS', '', '2025-2026', NULL),
(28, '136432146225', 'Grande, Mae Ann J.', '', '$2y$10$fyzyOx1UtyeIk7wyM/M4pul/EtrKwPe22whxVNK7L7SUCVNePG13G', '2008-09-22', 'Female', '12', 'Sheldon', '09318247108', '2025-11-26 22:03:43', '2025-11-26 22:03:43', 'active', 'GAS', '', '2025-2026', NULL),
(29, '136432146226', 'Grande, Mary Ann J.', '', '$2y$10$aILWJl7C1ycFxJamp0UzIuMUe5KWAejr5sGXwVRE4ImHh.kiVw6ga', '2008-02-09', 'Female', '12', 'Sheldon', '09318247108', '2025-11-26 22:23:41', '2025-11-26 22:23:41', 'active', 'GAS', '', '2025-2026', NULL),
(31, '117693140053', 'Rubiato, Chene Rhoa M.', '', '$2y$10$Q2TIBxjha2qDP/JzPAHsbO6SxhXa.UELSXrakZgpcdnTkqhqfXuGO', '2008-01-22', 'Female', '12', 'Faraday', '', '2025-11-26 22:40:00', '2025-11-26 22:40:00', 'active', 'STEM', '', '2025-2026', NULL),
(32, '117692130072', 'Capillan, Charlotte T.', 'charlottecapillan@gmail.com', '$2y$10$jJp6gDdVUpz.gyuAO2m64u0fB36p/pxuFCoAd8fMBzkGhJdSklk9m', '2007-11-09', 'Female', '12', 'Faraday', '', '2025-11-26 22:50:38', '2025-11-26 22:50:38', 'active', 'STEM', '', '2025-2026', NULL),
(33, '11771213005', 'Cabahug, Lianne', '', '$2y$10$RmOqcdOaaja5pz4oWRDGD.E2y6NKEBHBh2lcu2SwOCXjZ0bgf15AK', '2008-09-07', 'Female', '12', 'Faraday', '', '2025-11-26 22:52:13', '2025-11-26 22:52:13', 'active', 'STEM', '', '2025-2026', NULL),
(34, '11724130107', 'Ploteria, Heart O.', '', '$2y$10$cjc4VxlvSQID4UNsCCb7EuWD4aa477rO6T0W1HbAM7zihhVkn9XjG', '2008-02-14', 'Female', '12', 'Faraday', '', '2025-11-26 22:53:36', '2025-11-26 22:53:36', 'active', 'STEM', '', '2025-2026', NULL),
(35, '117712130017', 'Fernandez, Kathleen', '', '$2y$10$5nlHj4EEkmzCTIEc.oAKE.t8SzTQisICT9oMBdcHOCp0b.hwnfFUS', '2008-07-16', 'Female', '12', 'Newton', '', '2025-11-26 23:16:06', '2025-11-26 23:16:06', 'active', 'STEM', '', '2025-2026', NULL),
(36, '117707130086', 'Gaduyon, Frecy R.', 'gaduyonfrecy@gmail.com', '$2y$10$LRQceODetd8R19IRJxdr7ey59UTeC/D7b3fAz8DJOe7zbbOjUQCwC', '2008-05-23', 'Female', '12', 'Newton', '', '2025-11-26 23:28:45', '2025-11-26 23:28:45', 'active', 'STEM', '', '2025-2026', NULL),
(37, '117050120060', 'Sapatan, Shajanie S.', '', '$2y$10$0PEevF2gl.YuA2jojsip8u/xt3S1c8XxVlyJlDx7G9zBntZpUOpnK', '2008-02-21', 'Female', '12', 'Newton', '', '2025-11-26 23:30:05', '2025-11-26 23:30:05', 'active', 'STEM', '', '2025-2026', NULL),
(38, '404045150107', 'de la Pena, Moses William M.', 'moseswilliamdp@gmail.com', '$2y$10$uVO4sVmkNQtmPC7SoInrwOM0TFtQVJq677v7WSMpgYcgwYVyo1WWa', '2009-02-09', 'Male', '12', 'Newton', '', '2025-11-27 00:07:26', '2025-11-27 00:07:26', 'active', 'STEM', '', '2025-2026', NULL),
(39, '1', 'k', '', '$2y$10$QKGpiQTW7bih/HJoEf0DwuuPJbTJeKEkzjI0J9XYxFNIQoex3JdYu', '2008-07-18', 'Female', '12', 'Laravel', '09091234542', '2025-11-27 05:50:41', '2025-11-27 05:50:41', 'active', 'STEM', '', '2025-2026', NULL),
(40, '131313', 'X', 'x@gmail.com', '$2y$10$Lcy/80xHQQ/0IcAWCsOFE.X0q.PpmSHvLN646qcnyjiAVOkQye7Mi', '2007-07-09', 'Female', '12', 'Polar', '09090487283', '2025-11-28 10:55:18', '2025-11-28 10:55:18', 'active', 'STEM', '', '2025-2026', NULL),
(41, '4444', 'p', 'p@gmail.com', '$2y$10$292TTW319Rd4BS7WSXd57ODq7BQEqfy.BITtgTW3SmDfz1xkWgYMC', '2008-07-07', 'Female', '12', 'Polar', '09090487283', '2025-11-28 11:02:34', '2025-11-28 11:02:34', 'active', 'STEM', '', '2025-2026', NULL),
(42, '1111', 'L', 'l@gmail.com', '$2y$10$7XMASL6iUaagaTCuNR4mmOkP4L8cQlmeZ0zzs/eTFTuLNa4OvkZPK', '2008-07-09', 'Female', '12', 'Polar', '09090487283', '2025-11-29 10:06:58', '2025-11-28 11:13:52', 'active', 'STEM', '', '2025-2026', 'Biology'),
(43, '5555', 'm', 'm@gmail.com', '$2y$10$ykUa4cWAYjeSNMlL5el30ODNtBqR9jg.kIQp3UUu1.nAmiPHLJg8K', '2008-05-06', 'Female', '12', 'Laravel', '09091234542', '2025-11-28 11:26:41', '2025-11-28 11:26:41', 'active', 'ARTS & DESIGN', '', '2025-2026', NULL),
(44, '223344', 'tr', 't@gmail.com', '$2y$10$AMryTQhpo.I6SkYISXnMqe0X4MYS4LDiL6BCc6asg//AxSn571erK', '', 'Male', '12', '', '', '2025-11-28 11:38:57', '2025-11-28 11:38:57', 'active', 'GAS', '', '2025-2026', NULL),
(45, '7777', 'rtr', '', '$2y$10$GLtuCZzCDc1pUsJbu7mDAeUYbgMVW.be/nhoQqto0x1BAk8Azjhhu', '', 'Female', '12', 'Polar', '', '2025-11-28 11:50:41', '2025-11-28 11:50:41', 'active', 'ARTS & DESIGN', '', '2025-2026', NULL),
(46, '8888', 'pingboss', '', '$2y$10$E1SgRa.HiguJWrl4b/uzX.YqohVTYpMkH9ANKU6cBTZaFcrHvOC3C', '', 'Female', '12', '', '', '2025-11-28 11:56:24', '2025-11-28 11:56:24', 'active', 'STEM', '', '2025-2026', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `survey_answers`
--

DROP TABLE IF EXISTS `survey_answers`;
CREATE TABLE IF NOT EXISTS `survey_answers` (
  `id` int NOT NULL AUTO_INCREMENT,
  `student_id` int NOT NULL,
  `q1` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q2` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q3` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q4` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q5` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q6` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q7` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q8` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q9` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q10` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q11` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q12` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q13` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q14` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q15` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q16` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q17` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q18` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q19` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q20` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q21` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q22` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q23` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q24` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q25` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q26` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q27` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q28` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q29` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q30` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q31` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q32` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q33` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q34` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q35` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q36` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q37` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q38` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q39` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q40` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q41` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `q42` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `student_id` (`student_id`)
) ENGINE=MyISAM AUTO_INCREMENT=44 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `survey_answers`
--

INSERT INTO `survey_answers` (`id`, `student_id`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`, `q8`, `q9`, `q10`, `q11`, `q12`, `q13`, `q14`, `q15`, `q16`, `q17`, `q18`, `q19`, `q20`, `q21`, `q22`, `q23`, `q24`, `q25`, `q26`, `q27`, `q28`, `q29`, `q30`, `q31`, `q32`, `q33`, `q34`, `q35`, `q36`, `q37`, `q38`, `q39`, `q40`, `q41`, `q42`, `created_at`) VALUES
(1, 8, 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', '2025-11-27 05:05:56'),
(2, 8, 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', '2025-11-27 05:08:12'),
(3, 22, 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', '2025-11-27 05:22:44'),
(4, 23, 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'no', 'no', 'no', 'no', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'no', 'yes', 'no', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'no', '2025-11-27 05:41:12'),
(5, 25, 'no', 'no', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'no', 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'yes', '2025-11-27 05:47:32'),
(6, 24, 'no', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'no', 'no', 'no', 'no', 'no', 'yes', 'yes', 'no', '2025-11-27 05:53:17'),
(7, 26, 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'yes', '2025-11-27 06:01:10'),
(8, 28, 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'no', 'yes', '2025-11-27 06:09:42'),
(9, 27, 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'no', 'yes', 'no', 'yes', '2025-11-27 06:15:01'),
(10, 29, 'no', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'no', 'no', '2025-11-27 06:33:42'),
(11, 31, 'no', 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', '2025-11-27 06:43:15'),
(12, 34, 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'yes', '2025-11-27 06:59:00'),
(13, 34, 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'yes', '2025-11-27 07:01:10'),
(14, 11, 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'no', '2025-11-27 07:09:11'),
(15, 35, 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', '2025-11-27 07:20:15'),
(16, 35, 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', '2025-11-27 07:23:25'),
(17, 36, 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'no', 'no', '2025-11-27 07:33:45'),
(18, 37, 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', '2025-11-27 07:39:52'),
(19, 13, 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'no', '2025-11-27 07:44:24'),
(20, 7, 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', '2025-11-27 07:51:00'),
(21, 10, 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', '2025-11-27 07:56:32'),
(22, 12, 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'no', '2025-11-27 08:00:47'),
(23, 38, 'no', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'no', '2025-11-27 08:10:11'),
(24, 16, 'no', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', '2025-11-27 08:33:38'),
(25, 19, 'no', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', '2025-11-27 08:39:01'),
(26, 18, 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'no', 'no', 'no', 'no', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'no', 'no', '2025-11-27 08:44:38'),
(27, 6, 'no', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'no', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', '2025-11-28 12:35:49'),
(28, 4, 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'yes', '2025-11-28 12:48:49'),
(29, 4, 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'yes', '2025-11-28 12:49:24'),
(30, 14, 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', '2025-11-28 12:55:02'),
(31, 9, 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', '2025-11-28 13:48:22'),
(32, 5, 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'no', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'no', 'yes', 'no', '2025-11-28 13:59:29'),
(33, 15, 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'no', 'no', '2025-11-28 14:11:55'),
(34, 40, 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'no', 'yes', 'no', 'yes', 'no', 'yes', 'no', 'no', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'no', 'no', '2025-11-28 18:59:29'),
(35, 41, 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', '2025-11-28 19:06:16'),
(36, 42, 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'no', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'no', 'yes', 'no', '2025-11-28 19:21:05'),
(37, 43, 'no', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'no', 'no', 'no', 'no', 'no', 'yes', 'yes', 'no', '2025-11-28 19:31:33'),
(38, 44, 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'yes', '2025-11-28 19:48:26'),
(39, 45, 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'no', 'yes', '2025-11-28 19:54:03'),
(40, 46, 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'no', 'yes', 'no', 'yes', '2025-11-28 19:59:17'),
(41, 33, 'yes', 'no', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'no', 'yes', 'no', 'no', '2025-11-29 12:30:59'),
(42, 33, 'yes', 'no', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'no', 'yes', 'no', 'yes', '2025-11-29 12:31:17'),
(43, 32, 'no', 'no', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'yes', 'yes', 'yes', 'no', 'no', 'no', 'yes', 'yes', 'no', 'yes', 'no', 'yes', 'no', 'yes', 'yes', 'no', 'yes', 'no', 'no', 'no', 'yes', 'no', 'no', 'yes', 'yes', 'yes', 'yes', 'no', 'no', 'yes', 'no', 'no', 'no', 'no', '2025-11-29 13:03:43');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `role` enum('student','counselor','admin') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `student_id` int DEFAULT NULL,
  `counselor_id` int DEFAULT NULL,
  `email_verified_at` datetime DEFAULT NULL,
  `remember_token` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci DEFAULT NULL,
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `email` (`email`(250)),
  KEY `student_id` (`student_id`),
  KEY `counselor_id` (`counselor_id`)
) ENGINE=MyISAM AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `password`, `role`, `student_id`, `counselor_id`, `email_verified_at`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'admin@vocaiton.local', '0192023a7bbd73250516f069df18b500', 'admin', NULL, NULL, '2025-10-21 01:48:17', NULL, '2025-10-21 01:48:17', '2025-10-21 01:48:17'),
(2, '', '$2y$10$6Mrro6HHw6frM03kaxxnfuSM.BZG2rZrl4gKmveoVz24FlmaC8vX6', 'student', 1, NULL, NULL, NULL, '2025-11-26 23:45:10', '2025-11-26 23:45:10'),
(3, '', '$2y$10$AEzCn6bzln6poVFhKmbWE.apNkNGmynXHvgpXrTLaN93PxCpS22MO', 'student', 2, NULL, NULL, NULL, '2025-11-26 23:48:17', '2025-11-26 23:48:17'),
(4, 'rene3villaester@gmail.com', '$2y$10$pzHbY5sRviUgVjGFFnuSm.Ac4fK2oFraeWCnJKj8Hcvgn9Ub/reYK', 'student', 3, NULL, NULL, NULL, '2025-11-26 23:49:49', '2025-11-26 23:49:49'),
(5, 'brentrojo1@gmail.com', '$2y$10$N7gezO3sugt9TVb9zyu15eqcVx8D.EXsunGEeAmUXxYnWa82f2c3m', 'student', 4, NULL, NULL, NULL, '2025-11-26 23:52:37', '2025-11-26 23:52:37'),
(6, 'margarettecrema@gmail.com', '$2y$10$fACvkM2UIl2yRaKwaFi3r.lQjmy2BKgPO3AL6IhwR1MMuBac/i002', 'student', 5, NULL, NULL, NULL, '2025-11-26 23:54:57', '2025-11-26 23:54:57'),
(7, '', '$2y$10$HvqWL.0dNA.74f4NU6jhSuXgkT9qqk0CP1Snrzsn3lbWnmzra/0fG', 'student', 6, NULL, NULL, NULL, '2025-11-27 00:00:07', '2025-11-27 00:00:07'),
(8, 'lzplayz583@gmail.com', '$2y$10$TYdR3LMuzlyqLj8XN5jV6uX61r6w/CPZV/4bCUemJ660caZBpQyEC', 'student', 7, NULL, NULL, NULL, '2025-11-27 00:02:37', '2025-11-27 00:02:37'),
(9, 'preciousagnes1903@gmail.com', '$2y$10$stUOsGDseS5hu58N2Q5xAuQT2dn3nYrlHIf.HIaV9K71FQA0KStLy', 'student', 8, NULL, NULL, NULL, '2025-11-27 00:04:39', '2025-11-27 00:04:39'),
(10, 'psychehopelumayno362@gmail.com', '$2y$10$ZXLStqTH67uqp7Wxos/jQ.Tlgf9AcRRSDZ2vOWKXRbE/wQFolfVmy', 'student', 9, NULL, NULL, NULL, '2025-11-27 00:07:02', '2025-11-27 00:07:02'),
(11, 'saytasangel@gmail.com', '$2y$10$f7pCzSx8CPnMV8NEj3i/z.fXD8PfienUeQgJQ/3kzCC1RmL0IgQEe', 'student', 10, NULL, NULL, NULL, '2025-11-27 00:08:50', '2025-11-27 00:08:50'),
(12, 'septmariealexisbarrientos@gmail.com', '$2y$10$6atsMwEag9qb5xy/nPtNMuirDjXmqWPlviPI0ozUe//IzUP228JRy', 'student', 11, NULL, NULL, NULL, '2025-11-27 00:10:48', '2025-11-27 00:10:48'),
(13, 'falcutilaallyson@gmail.com', '$2y$10$lgfoSWo2na1GYTODJqtyEeHso4VM6vw20MNoOWRAosZrjewDMd4Ei', 'student', 12, NULL, NULL, NULL, '2025-11-27 00:12:15', '2025-11-27 00:12:15'),
(14, 'shiekinahbantigue@gmail.com', '$2y$10$FP2HjunRONEEzfgYmAEdSOR8k5abn.XqmaWrA0cJZeXzmOajpXc6G', 'student', 13, NULL, NULL, NULL, '2025-11-27 00:14:00', '2025-11-27 00:14:00'),
(15, '', '$2y$10$X2w58Vn6qYLyEArQ8n1meunms0Sm3MSoGZgxGVR1AvSe1Sk0rAsN.', 'student', 14, NULL, NULL, NULL, '2025-11-27 00:16:25', '2025-11-27 00:16:25'),
(16, 'iandescallar9@gmail.com', '$2y$10$YQGieiMWZdB9yOMu2IXRdOhFBRq2F3D3PWwNLwQN96/Oegh4sZNGa', 'student', 15, NULL, NULL, NULL, '2025-11-27 00:18:15', '2025-11-27 00:18:15'),
(17, '', '$2y$10$cwU3s.qerBwWy6YiKZjGSe5VhihEsuiS81ZoN4LyNMspOmkKVUaM6', 'student', 16, NULL, NULL, NULL, '2025-11-27 00:19:47', '2025-11-27 00:19:47'),
(18, '', '$2y$10$1bKvs2N.O.Wi/kX8v4P33OU/JlDywsdWj.HFjszaetMpXbpIUSVtO', 'student', 17, NULL, NULL, NULL, '2025-11-27 00:20:56', '2025-11-27 00:20:56'),
(19, '', '$2y$10$lpOo1GbY4CU8bA37cA.Dx.s2IYX8LrVOCmDgMC4QSBMKxk55e5mMi', 'student', 18, NULL, NULL, NULL, '2025-11-27 00:23:12', '2025-11-27 00:23:12'),
(20, '', '$2y$10$ZA8H9mFql95G68EQVQBD3uMH.zBz5EsdaYI6oAramFgk.HDqnRGIC', 'student', 19, NULL, NULL, NULL, '2025-11-27 00:24:56', '2025-11-27 00:24:56'),
(21, 'ayunovanrussell@gmail.com', '$2y$10$HF1nD2qpHq06c4lLSWcBseR93tKVo4Ga.UtVL5K26ON.C5H23JsSy', 'student', 20, NULL, NULL, NULL, '2025-11-27 00:26:53', '2025-11-27 00:26:53'),
(22, 'mattlegario@gmail.com', '$2y$10$CH0e4hPkabW9st8JABh5TefWjyUxtQc49BX5HXldz2aefDekDAX6a', 'student', 21, NULL, NULL, NULL, '2025-11-27 00:28:24', '2025-11-27 00:28:24'),
(23, 'k@gmail.com', '$2y$10$d3koVbJN0p.OSKKteakuauWCn1nkjzT0/thwNJuoglYkBMz7j5BxK', 'counselor', NULL, 1, NULL, NULL, '2025-11-27 12:59:22', '2025-11-27 12:59:22'),
(24, 'preciousagnes1903@gmail.com', '$2y$10$AkSSTve2S6e1uNkqrg6ibuO2HOqIhUFc8RWspuLwYexdkex1PAZNi', 'student', 22, NULL, NULL, NULL, '2025-11-27 05:19:45', '2025-11-27 05:19:45'),
(25, '', '$2y$10$ejGsfjkpgr5.qzHajP6bMelAYL.mGKC7vQi3Rh74EhPZBaqUV3x5y', 'student', 23, NULL, NULL, NULL, '2025-11-27 05:31:02', '2025-11-27 05:31:02'),
(26, '', '$2y$10$chyGx3YUfew8y2ef6leWtuAacX9JT41bwsN69EPLoaByzwTFDYoia', 'student', 24, NULL, NULL, NULL, '2025-11-27 05:32:24', '2025-11-27 05:32:24'),
(27, '', '$2y$10$J0wScDXrMXYI1BbQrs.TguIh5DXAMC2myWVm1cR5PutL2SorHxNfu', 'student', 25, NULL, NULL, NULL, '2025-11-27 05:33:33', '2025-11-27 05:33:33'),
(28, '', '$2y$10$4puJoGAKfdAgO5W47YzjtuDstCdbJrzQlCUcY27nAliO5vC0ozjgK', 'student', 26, NULL, NULL, NULL, '2025-11-27 05:34:36', '2025-11-27 05:34:36'),
(29, '', '$2y$10$LF6ElHgoXypfrCMU3bNWX.8GVzkjGyMzIDPictnqArh4F3Be96Tum', 'student', 27, NULL, NULL, NULL, '2025-11-27 05:36:48', '2025-11-27 05:36:48'),
(30, '', '$2y$10$fyzyOx1UtyeIk7wyM/M4pul/EtrKwPe22whxVNK7L7SUCVNePG13G', 'student', 28, NULL, NULL, NULL, '2025-11-27 06:03:43', '2025-11-27 06:03:43'),
(31, '', '$2y$10$aILWJl7C1ycFxJamp0UzIuMUe5KWAejr5sGXwVRE4ImHh.kiVw6ga', 'student', 29, NULL, NULL, NULL, '2025-11-27 06:23:41', '2025-11-27 06:23:41'),
(32, '', '$2y$10$NVVLsTAGkVONWrNIc1Pt/u52MPqN/DizwiLATE.QdYsI0HA9wFnRy', 'student', 30, NULL, NULL, NULL, '2025-11-27 06:24:47', '2025-11-27 06:24:47'),
(33, '', '$2y$10$Q2TIBxjha2qDP/JzPAHsbO6SxhXa.UELSXrakZgpcdnTkqhqfXuGO', 'student', 31, NULL, NULL, NULL, '2025-11-27 06:40:00', '2025-11-27 06:40:00'),
(34, 'charlottecapillan@gmail.com', '$2y$10$jJp6gDdVUpz.gyuAO2m64u0fB36p/pxuFCoAd8fMBzkGhJdSklk9m', 'student', 32, NULL, NULL, NULL, '2025-11-27 06:50:38', '2025-11-27 06:50:38'),
(35, '', '$2y$10$RmOqcdOaaja5pz4oWRDGD.E2y6NKEBHBh2lcu2SwOCXjZ0bgf15AK', 'student', 33, NULL, NULL, NULL, '2025-11-27 06:52:13', '2025-11-27 06:52:13'),
(36, '', '$2y$10$cjc4VxlvSQID4UNsCCb7EuWD4aa477rO6T0W1HbAM7zihhVkn9XjG', 'student', 34, NULL, NULL, NULL, '2025-11-27 06:53:36', '2025-11-27 06:53:36'),
(37, '', '$2y$10$5nlHj4EEkmzCTIEc.oAKE.t8SzTQisICT9oMBdcHOCp0b.hwnfFUS', 'student', 35, NULL, NULL, NULL, '2025-11-27 07:16:06', '2025-11-27 07:16:06'),
(38, 'gaduyonfrecy@gmail.com', '$2y$10$LRQceODetd8R19IRJxdr7ey59UTeC/D7b3fAz8DJOe7zbbOjUQCwC', 'student', 36, NULL, NULL, NULL, '2025-11-27 07:28:45', '2025-11-27 07:28:45'),
(39, '', '$2y$10$0PEevF2gl.YuA2jojsip8u/xt3S1c8XxVlyJlDx7G9zBntZpUOpnK', 'student', 37, NULL, NULL, NULL, '2025-11-27 07:30:05', '2025-11-27 07:30:05'),
(40, 'moseswilliamdp@gmail.com', '$2y$10$uVO4sVmkNQtmPC7SoInrwOM0TFtQVJq677v7WSMpgYcgwYVyo1WWa', 'student', 38, NULL, NULL, NULL, '2025-11-27 08:07:26', '2025-11-27 08:07:26'),
(41, 'maryjesa.demaisip@deped.gov.ph', '$2y$10$vk9SQUg5oqwqOA1zYK8B7e1YM2FumKkcgRA6yyqpLK1XW3b.CxUgq', 'counselor', NULL, 2, NULL, NULL, '2025-11-27 17:07:30', '2025-11-27 17:07:30'),
(42, '', '$2y$10$QKGpiQTW7bih/HJoEf0DwuuPJbTJeKEkzjI0J9XYxFNIQoex3JdYu', 'student', 39, NULL, NULL, NULL, '2025-11-27 13:50:41', '2025-11-27 13:50:41'),
(43, 'dilayn4@gmail.com', '$2y$10$nxUnWPOEOW62pCEQUxQ9FOYoPYPtbCksq7Nq403pWhjnoo/3pZqXG', 'counselor', NULL, 3, NULL, NULL, '2025-11-28 13:38:31', '2025-11-28 13:38:31'),
(44, 'x@gmail.com', '$2y$10$yHcC39VcZrQgVJpE5vQQzuHCjDkJ3BP8xlzmq6EUzV3AKwfUx./Ie', 'counselor', NULL, 4, NULL, NULL, '2025-11-29 00:54:01', '2025-11-29 00:54:01'),
(45, 'x@gmail.com', '$2y$10$Lcy/80xHQQ/0IcAWCsOFE.X0q.PpmSHvLN646qcnyjiAVOkQye7Mi', 'student', 40, NULL, NULL, NULL, '2025-11-28 18:55:18', '2025-11-28 18:55:18'),
(46, 'p@gmail.com', '$2y$10$292TTW319Rd4BS7WSXd57ODq7BQEqfy.BITtgTW3SmDfz1xkWgYMC', 'student', 41, NULL, NULL, NULL, '2025-11-28 19:02:34', '2025-11-28 19:02:34'),
(47, 'l@gmail.com', '$2y$10$7XMASL6iUaagaTCuNR4mmOkP4L8cQlmeZ0zzs/eTFTuLNa4OvkZPK', 'student', 42, NULL, NULL, NULL, '2025-11-28 19:13:52', '2025-11-28 19:13:52'),
(48, 'm@gmail.com', '$2y$10$ykUa4cWAYjeSNMlL5el30ODNtBqR9jg.kIQp3UUu1.nAmiPHLJg8K', 'student', 43, NULL, NULL, NULL, '2025-11-28 19:26:41', '2025-11-28 19:26:41'),
(49, 't@gmail.com', '$2y$10$AMryTQhpo.I6SkYISXnMqe0X4MYS4LDiL6BCc6asg//AxSn571erK', 'student', 44, NULL, NULL, NULL, '2025-11-28 19:38:57', '2025-11-28 19:38:57'),
(50, '', '$2y$10$GLtuCZzCDc1pUsJbu7mDAeUYbgMVW.be/nhoQqto0x1BAk8Azjhhu', 'student', 45, NULL, NULL, NULL, '2025-11-28 19:50:41', '2025-11-28 19:50:41'),
(51, '', '$2y$10$E1SgRa.HiguJWrl4b/uzX.YqohVTYpMkH9ANKU6cBTZaFcrHvOC3C', 'student', 46, NULL, NULL, NULL, '2025-11-28 19:56:24', '2025-11-28 19:56:24');

-- --------------------------------------------------------

--
-- Table structure for table `validation_history`
--

DROP TABLE IF EXISTS `validation_history`;
CREATE TABLE IF NOT EXISTS `validation_history` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ai_id` int NOT NULL,
  `student_id` int NOT NULL,
  `survey_id` int NOT NULL,
  `recommended_career` varchar(255) DEFAULT NULL,
  `confidence_score` decimal(5,2) DEFAULT NULL,
  `counselor_suggestion` varchar(255) DEFAULT NULL,
  `status` varchar(50) DEFAULT NULL,
  `validated_by` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_validation` (`ai_id`,`student_id`,`survey_id`),
  KEY `fk_student` (`student_id`),
  KEY `fk_survey` (`survey_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

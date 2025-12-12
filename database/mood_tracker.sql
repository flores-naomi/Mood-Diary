-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 12, 2025 at 07:03 AM
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
-- Database: `mood_tracker`
--

-- --------------------------------------------------------

--
-- Table structure for table `diary_entries`
--

CREATE TABLE `diary_entries` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `content` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `diary_entries`
--

INSERT INTO `diary_entries` (`id`, `user_id`, `date`, `time`, `content`, `created_at`) VALUES
(1, 1, '2025-12-12', '11:27:55', 'Umm, hello. It\'s just that this day is too tiring.It\'s now working. It\'s now working OK. It\'s now working.', '2025-12-12 03:47:34'),
(2, 1, '2025-12-11', '11:56:05', 'it was fun', '2025-12-12 04:08:38'),
(3, 1, '2025-12-10', '12:36:16', 'Is it working?', '2025-12-12 04:38:00'),
(4, 1, '2025-12-08', '12:44:41', 'Join join join', '2025-12-12 04:44:41'),
(5, 1, '2025-12-09', '12:48:00', 'jkdshajkcfje', '2025-12-12 04:48:00');

-- --------------------------------------------------------

--
-- Table structure for table `media_uploads`
--

CREATE TABLE `media_uploads` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `diary_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `media_type` enum('photo','video') NOT NULL,
  `file_path` varchar(255) NOT NULL,
  `file_size` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `media_uploads`
--

INSERT INTO `media_uploads` (`id`, `user_id`, `diary_id`, `date`, `media_type`, `file_path`, `file_size`, `created_at`) VALUES
(3, 1, 1, '2025-12-12', 'photo', 'uploads/1/2025/12/1765511230_26578ecb8304619e.png', 54848, '2025-12-12 03:47:10'),
(4, 1, 2, '2025-12-11', 'photo', 'uploads/1/2025/12/1765511766_ebf6db182bb25805.png', 31866, '2025-12-12 03:56:06'),
(5, 1, NULL, '2025-12-11', 'photo', 'uploads/1/2025/12/1765512496_8c699d054f973e90.png', 42082, '2025-12-12 04:08:16'),
(6, 1, NULL, '2025-12-08', 'photo', 'uploads/1/2025/12/1765514585_87a25c58cfe82a9f.png', 15094, '2025-12-12 04:43:05'),
(7, 1, 5, '2025-12-09', 'photo', 'uploads/1/2025/12/1765514880_ba24ebda3385b88a.PNG', 71110, '2025-12-12 04:48:00');

-- --------------------------------------------------------

--
-- Table structure for table `mood_logs`
--

CREATE TABLE `mood_logs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `face_emotion` varchar(64) DEFAULT NULL,
  `face_confidence` float DEFAULT NULL,
  `audio_emotion` varchar(64) DEFAULT NULL,
  `audio_score` float DEFAULT NULL,
  `combined_score` int(11) NOT NULL,
  `diary_id` int(11) DEFAULT NULL,
  `meta` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin DEFAULT NULL CHECK (json_valid(`meta`)),
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mood_logs`
--

INSERT INTO `mood_logs` (`id`, `user_id`, `date`, `time`, `face_emotion`, `face_confidence`, `audio_emotion`, `audio_score`, `combined_score`, `diary_id`, `meta`, `created_at`) VALUES
(1, NULL, '2025-12-12', '08:35:37', NULL, 0, 'calm', 1, 3, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:35:37'),
(2, NULL, '2025-12-12', '08:35:39', NULL, 0, 'calm', 1, 1, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:35:39'),
(3, NULL, '2025-12-12', '08:35:44', NULL, 0, 'calm', 2, 5, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:35:44'),
(4, NULL, '2025-12-12', '08:38:42', 'neutral', 0.869252, 'calm', 6, 41, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:38:42'),
(5, NULL, '2025-12-12', '08:39:03', 'surprised', 0.565282, 'neutral', 11, 48, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:39:03'),
(6, NULL, '2025-12-12', '08:53:04', 'neutral', 0.613382, 'calm', 2, 29, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:04'),
(7, NULL, '2025-12-12', '08:53:04', 'neutral', 0.613382, 'calm', 1, 27, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:04'),
(8, NULL, '2025-12-12', '08:53:04', 'surprised', 0.917061, 'calm', 1, 34, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:04'),
(9, NULL, '2025-12-12', '08:53:04', 'surprised', 0.917061, 'calm', 1, 40, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:04'),
(10, NULL, '2025-12-12', '08:53:05', 'surprised', 0.917061, 'calm', 1, 43, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:05'),
(11, NULL, '2025-12-12', '08:53:05', 'surprised', 0.917061, 'calm', 1, 44, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:05'),
(12, NULL, '2025-12-12', '08:53:05', 'surprised', 0.79071, 'calm', 6, 44, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:05'),
(13, NULL, '2025-12-12', '08:53:05', 'surprised', 0.79071, 'calm', 4, 42, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:05'),
(14, NULL, '2025-12-12', '08:53:05', 'surprised', 0.79071, 'calm', 4, 41, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:05'),
(15, NULL, '2025-12-12', '08:53:05', 'surprised', 0.79071, 'calm', 3, 40, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:05'),
(16, NULL, '2025-12-12', '08:53:08', 'happy', 0.460372, 'neutral', 7, 52, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:08'),
(17, NULL, '2025-12-12', '08:53:08', 'happy', 0.460372, 'calm', 3, 32, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:08'),
(18, NULL, '2025-12-12', '08:53:09', 'surprised', 0.52363, 'calm', 1, 28, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:09'),
(19, NULL, '2025-12-12', '08:53:09', 'surprised', 0.52363, 'calm', 1, 27, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:09'),
(20, NULL, '2025-12-12', '08:53:10', 'surprised', 0.999543, 'neutral', 6, 53, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:10'),
(21, NULL, '2025-12-12', '08:53:11', 'happy', 0.9752, 'calm', 1, 60, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:11'),
(22, NULL, '2025-12-12', '08:53:12', 'neutral', 0.980947, 'calm', 1, 43, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:12'),
(23, NULL, '2025-12-12', '08:53:12', 'neutral', 0.896895, 'calm', 1, 40, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:12'),
(24, NULL, '2025-12-12', '08:53:12', 'neutral', 0.896895, 'calm', 1, 39, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:12'),
(25, NULL, '2025-12-12', '08:53:13', 'happy', 0.99475, 'calm', 1, 47, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:13'),
(26, NULL, '2025-12-12', '08:53:13', 'happy', 0.99475, 'calm', 1, 57, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:13'),
(27, NULL, '2025-12-12', '08:53:13', 'happy', 0.99475, 'calm', 1, 61, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:13'),
(28, NULL, '2025-12-12', '08:53:13', 'happy', 0.99475, 'calm', 1, 62, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:13'),
(29, NULL, '2025-12-12', '08:53:13', 'neutral', 0.811702, 'calm', 1, 53, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:13'),
(30, NULL, '2025-12-12', '08:53:14', 'neutral', 0.811702, 'calm', 1, 41, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:14'),
(31, NULL, '2025-12-12', '08:53:14', 'neutral', 0.811702, 'calm', 1, 37, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:14'),
(32, NULL, '2025-12-12', '08:53:14', 'neutral', 0.811702, 'calm', 1, 35, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:14'),
(33, NULL, '2025-12-12', '08:53:14', 'neutral', 0.928281, 'calm', 1, 35, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:14'),
(34, NULL, '2025-12-12', '08:53:14', 'neutral', 0.928281, 'calm', 1, 37, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:14'),
(35, NULL, '2025-12-12', '08:53:14', 'neutral', 0.928281, 'calm', 1, 38, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:14'),
(36, NULL, '2025-12-12', '08:53:14', 'neutral', 0.928281, 'calm', 1, 39, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:14'),
(37, NULL, '2025-12-12', '08:53:15', 'neutral', 0.928281, 'calm', 1, 39, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:15'),
(38, NULL, '2025-12-12', '08:53:15', 'neutral', 0.975705, 'calm', 2, 40, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:15'),
(39, NULL, '2025-12-12', '08:53:15', 'neutral', 0.975705, 'calm', 2, 41, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:15'),
(40, NULL, '2025-12-12', '08:53:15', 'neutral', 0.975705, 'calm', 2, 42, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:15'),
(41, NULL, '2025-12-12', '08:53:15', 'neutral', 0.64753, 'calm', 2, 42, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:15'),
(42, NULL, '2025-12-12', '08:53:16', 'neutral', 0.64753, 'calm', 2, 35, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:16'),
(43, NULL, '2025-12-12', '08:53:16', 'neutral', 0.64753, 'calm', 2, 30, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:16'),
(44, NULL, '2025-12-12', '08:53:16', 'neutral', 0.64753, 'calm', 2, 29, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:16'),
(45, NULL, '2025-12-12', '08:53:16', 'neutral', 0.89164, 'calm', 1, 30, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:16'),
(46, NULL, '2025-12-12', '08:53:16', 'neutral', 0.89164, 'calm', 1, 34, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:16'),
(47, NULL, '2025-12-12', '08:53:16', 'neutral', 0.89164, 'calm', 1, 36, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:16'),
(48, NULL, '2025-12-12', '08:53:17', 'neutral', 0.89164, 'calm', 3, 37, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:17'),
(49, NULL, '2025-12-12', '08:53:17', 'happy', 0.976562, 'calm', 1, 45, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:17'),
(50, NULL, '2025-12-12', '08:53:17', 'happy', 0.976562, 'calm', 1, 54, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:17'),
(51, NULL, '2025-12-12', '08:53:17', 'happy', 0.976562, 'calm', 1, 60, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:17'),
(52, NULL, '2025-12-12', '08:53:17', 'happy', 0.976562, 'calm', 1, 61, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:17'),
(53, NULL, '2025-12-12', '08:53:18', 'neutral', 0.677142, 'calm', 3, 46, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:18'),
(54, NULL, '2025-12-12', '08:53:18', 'neutral', 0.677142, 'neutral', 12, 38, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:18'),
(55, NULL, '2025-12-12', '08:53:19', 'neutral', 0.677142, 'calm', 1, 33, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:19'),
(56, NULL, '2025-12-12', '08:53:19', 'happy', 0.978619, 'calm', 1, 35, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:19'),
(57, NULL, '2025-12-12', '08:53:19', 'happy', 0.978619, 'calm', 2, 49, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:19'),
(58, NULL, '2025-12-12', '08:53:19', 'happy', 0.978619, 'calm', 6, 58, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:19'),
(59, NULL, '2025-12-12', '08:53:59', 'surprised', 0.889015, 'calm', 3, 40, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:53:59'),
(60, NULL, '2025-12-12', '08:54:01', 'surprised', 0.66373, 'calm', 2, 34, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:54:01'),
(61, NULL, '2025-12-12', '08:54:02', 'surprised', 0.835832, 'calm', 4, 40, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:54:02'),
(62, NULL, '2025-12-12', '08:54:04', 'happy', 0.999982, 'calm', 1, 62, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:54:04'),
(63, NULL, '2025-12-12', '08:54:11', 'neutral', 0.99691, 'calm', 1, 42, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:54:11'),
(64, NULL, '2025-12-12', '08:54:11', 'neutral', 0.998088, 'calm', 2, 43, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:54:11'),
(65, NULL, '2025-12-12', '08:58:47', 'surprised', 0.744997, 'calm', 1, 45, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:58:47'),
(66, NULL, '2025-12-12', '08:59:18', 'happy', 1, 'neutral', 9, 65, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:59:18'),
(67, NULL, '2025-12-12', '08:59:18', 'happy', 1, 'calm', 2, 65, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:59:18'),
(68, NULL, '2025-12-12', '08:59:19', 'happy', 0.999963, 'calm', 1, 63, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:59:19'),
(69, NULL, '2025-12-12', '08:59:20', 'happy', 1, 'calm', 2, 63, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36\"}', '2025-12-12 00:59:20'),
(70, 1, '2025-12-12', '09:57:31', 'happy', 0.994952, 'calm', 5, 63, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36 Edg\\/143.0.0.0\"}', '2025-12-12 01:57:31'),
(71, 1, '2025-12-12', '10:15:27', 'neutral', 0.997581, 'calm', 3, 43, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36 Edg\\/143.0.0.0\"}', '2025-12-12 02:15:27'),
(72, 1, '2025-12-12', '10:15:32', 'happy', 0.825499, 'calm', 2, 50, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36 Edg\\/143.0.0.0\"}', '2025-12-12 02:15:32'),
(73, 1, '2025-12-12', '10:15:34', 'neutral', 0.993495, 'calm', 5, 43, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36 Edg\\/143.0.0.0\"}', '2025-12-12 02:15:34'),
(74, 1, '2025-12-12', '10:15:35', 'neutral', 0.995817, 'calm', 5, 42, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36 Edg\\/143.0.0.0\"}', '2025-12-12 02:15:35'),
(75, 1, '2025-12-12', '10:15:36', 'neutral', 0.995817, 'calm', 1, 42, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36 Edg\\/143.0.0.0\"}', '2025-12-12 02:15:36'),
(76, 1, '2025-12-12', '10:15:38', 'happy', 1, 'calm', 4, 66, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36 Edg\\/143.0.0.0\"}', '2025-12-12 02:15:38'),
(77, 1, '2025-12-12', '10:15:39', 'happy', 1, 'calm', 4, 65, NULL, '{\"userAgent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/143.0.0.0 Safari\\/537.36 Edg\\/143.0.0.0\"}', '2025-12-12 02:15:39'),
(78, 1, '2025-12-12', '11:27:55', 'Tired', 0, 'Tired', 0, 75, NULL, '{\"diary_id\":\"1\",\"camera_enabled\":false,\"mic_enabled\":false,\"selected_mood\":\"Tired\",\"saved_at\":\"2025-12-12T03:27:55.374Z\"}', '2025-12-12 03:27:55'),
(79, 1, '2025-12-12', '11:40:29', 'Joyful', 0, 'Joyful', 0, 75, NULL, '{\"diary_id\":1,\"camera_enabled\":true,\"mic_enabled\":true,\"selected_mood\":\"Joyful\",\"saved_at\":\"2025-12-12T03:40:29.665Z\"}', '2025-12-12 03:40:29'),
(80, 1, '2025-12-12', '11:47:34', 'Happy', 0, 'Happy', 0, 75, NULL, '{\"diary_id\":1,\"camera_enabled\":true,\"mic_enabled\":true,\"selected_mood\":\"Happy\",\"saved_at\":\"2025-12-12T03:47:34.674Z\"}', '2025-12-12 03:47:34'),
(81, 1, '2025-12-12', '11:56:05', 'Calm', 0, 'Calm', 0, 75, NULL, '{\"diary_id\":\"2\",\"camera_enabled\":false,\"mic_enabled\":false,\"selected_mood\":\"Calm\",\"saved_at\":\"2025-12-12T03:56:05.912Z\"}', '2025-12-12 03:56:05'),
(82, 1, '2025-12-11', '05:08:38', 'Happy', 0, 'Happy', 0, 75, 2, '{\"camera_enabled\":true,\"mic_enabled\":false,\"selected_mood\":\"Happy\",\"saved_at\":\"2025-12-12T04:08:38.136Z\"}', '2025-12-12 04:08:38'),
(83, 1, '2025-12-10', '05:36:16', 'Happy', 0, 'Happy', 0, 75, 3, '{\"camera_enabled\":true,\"mic_enabled\":true,\"selected_mood\":\"Happy\",\"saved_at\":\"2025-12-12T04:36:16.886Z\"}', '2025-12-12 04:36:16'),
(84, 1, '2025-12-10', '05:38:00', 'Happy', 0, 'Happy', 0, 75, 3, '{\"camera_enabled\":true,\"mic_enabled\":false,\"selected_mood\":\"Happy\",\"saved_at\":\"2025-12-12T04:38:00.889Z\"}', '2025-12-12 04:38:00'),
(85, 1, '2025-12-08', '05:44:41', 'Calm', 0, 'Calm', 0, 75, 4, '{\"camera_enabled\":false,\"mic_enabled\":false,\"selected_mood\":\"Calm\",\"saved_at\":\"2025-12-12T04:44:41.738Z\"}', '2025-12-12 04:44:41'),
(86, 1, '2025-12-09', '05:48:00', 'Happy', 0, 'Happy', 0, 75, 5, '{\"camera_enabled\":true,\"mic_enabled\":false,\"selected_mood\":\"Happy\",\"saved_at\":\"2025-12-12T04:48:00.131Z\"}', '2025-12-12 04:48:00');

-- --------------------------------------------------------

--
-- Table structure for table `mood_tags`
--

CREATE TABLE `mood_tags` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `mood_id` int(11) DEFAULT NULL,
  `date` date NOT NULL,
  `tag_name` varchar(50) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `mood_tags`
--

INSERT INTO `mood_tags` (`id`, `user_id`, `mood_id`, `date`, `tag_name`, `created_at`) VALUES
(3, 1, 80, '2025-12-12', 'School', '2025-12-12 03:47:34'),
(5, 1, 82, '2025-12-11', 'Family', '2025-12-12 04:08:38'),
(7, 1, 84, '2025-12-10', 'Friends', '2025-12-12 04:38:00'),
(8, 1, 85, '2025-12-08', 'Friends', '2025-12-12 04:44:41'),
(9, 1, 86, '2025-12-09', 'Friends', '2025-12-12 04:48:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password_hash`, `created_at`) VALUES
(1, 'Naomi', '$2y$10$bKTUydf3ciCDOoTkHwr/b.4JP2HclwDU7DEnRELK3YRSeg1vS7b3y', '2025-12-12 01:44:26');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `diary_entries`
--
ALTER TABLE `diary_entries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unique_daily` (`user_id`,`date`);

--
-- Indexes for table `media_uploads`
--
ALTER TABLE `media_uploads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `diary_id` (`diary_id`);

--
-- Indexes for table `mood_logs`
--
ALTER TABLE `mood_logs`
  ADD PRIMARY KEY (`id`),
  ADD KEY `diary_id` (`diary_id`);

--
-- Indexes for table `mood_tags`
--
ALTER TABLE `mood_tags`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `mood_id` (`mood_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `diary_entries`
--
ALTER TABLE `diary_entries`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `media_uploads`
--
ALTER TABLE `media_uploads`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `mood_logs`
--
ALTER TABLE `mood_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=87;

--
-- AUTO_INCREMENT for table `mood_tags`
--
ALTER TABLE `mood_tags`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `diary_entries`
--
ALTER TABLE `diary_entries`
  ADD CONSTRAINT `diary_entries_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

--
-- Constraints for table `media_uploads`
--
ALTER TABLE `media_uploads`
  ADD CONSTRAINT `media_uploads_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `media_uploads_ibfk_2` FOREIGN KEY (`diary_id`) REFERENCES `diary_entries` (`id`);

--
-- Constraints for table `mood_logs`
--
ALTER TABLE `mood_logs`
  ADD CONSTRAINT `mood_logs_ibfk_1` FOREIGN KEY (`diary_id`) REFERENCES `diary_entries` (`id`);

--
-- Constraints for table `mood_tags`
--
ALTER TABLE `mood_tags`
  ADD CONSTRAINT `mood_tags_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `mood_tags_ibfk_2` FOREIGN KEY (`mood_id`) REFERENCES `mood_logs` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

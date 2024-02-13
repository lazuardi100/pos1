-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Sep 07, 2022 at 10:46 AM
-- Server version: 10.4.19-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `toefl`
--

-- --------------------------------------------------------

--
-- Table structure for table `answers`
--

CREATE TABLE `answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `alphabet` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `answer` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `flag` enum('0','1') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `answers`
--

INSERT INTO `answers` (`id`, `question_id`, `alphabet`, `answer`, `flag`, `created_at`, `updated_at`) VALUES
(1, 1, 'a', 'ini jawaban a', '0', '2022-08-30 15:01:29', '2022-08-30 15:01:29'),
(2, 1, 'b', 'ini jawaban b', '0', '2022-08-30 15:01:35', '2022-08-30 15:01:35'),
(3, 1, 'c', 'ini jawaban c', '0', '2022-08-30 15:01:41', '2022-08-30 15:01:41'),
(4, 1, 'd', 'ini jawaban d', '0', '2022-08-30 15:01:46', '2022-08-30 15:01:46'),
(5, 2, 'a', 'ini jawaban aaa', '0', '2022-08-30 15:09:57', '2022-08-30 15:09:57'),
(6, 2, 'b', 'ini jawaban bbb', '0', '2022-08-30 15:10:02', '2022-08-30 15:10:02'),
(7, 2, 'c', 'ini jawaban ccc', '0', '2022-08-30 15:10:07', '2022-08-30 15:10:07'),
(8, 2, 'd', 'ini jawaban ddd', '0', '2022-08-30 15:10:13', '2022-08-30 15:10:13'),
(9, 3, 'a', 'ini jawaban teefl a', '0', '2022-08-30 19:00:11', '2022-08-30 19:00:11'),
(10, 3, 'b', 'ini jawaban teefl b', '0', '2022-08-30 19:01:20', '2022-08-30 19:01:20'),
(11, 3, 'c', 'ini jawaban teefl c', '0', '2022-08-30 19:01:25', '2022-08-30 19:01:25'),
(12, 3, 'd', 'ini jawaban teefl d', '0', '2022-08-30 19:01:31', '2022-08-30 19:01:31');

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `categories` enum('pre-test','toefl') COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `time` time NOT NULL,
  `soft_delete` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `categories`, `name`, `slug`, `time`, `soft_delete`, `created_at`, `updated_at`) VALUES
(1, 'pre-test', 'ini beneran', 'ini-beneran', '02:01:00', '0', '2022-08-30 14:54:54', '2022-08-30 14:54:54'),
(2, 'pre-test', 'ini beneran 2', 'ini-beneran-2', '02:30:00', '0', '2022-08-30 17:09:03', '2022-08-30 17:09:03'),
(3, 'toefl', 'ini toefl 1', 'ini-toefl-1', '01:30:00', '0', '2022-08-30 18:04:34', '2022-08-30 18:04:34');

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `he_answers`
--

CREATE TABLE `he_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `test_id` bigint(20) UNSIGNED NOT NULL,
  `he_answer` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `he_answers`
--

INSERT INTO `he_answers` (`id`, `question_id`, `test_id`, `he_answer`, `created_at`, `updated_at`) VALUES
(1, 1, 1, 'a', NULL, NULL),
(2, 1, 2, 'e', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `key_answers`
--

CREATE TABLE `key_answers` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `question_id` bigint(20) UNSIGNED NOT NULL,
  `alphabet_key` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `key_answers`
--

INSERT INTO `key_answers` (`id`, `question_id`, `alphabet_key`, `created_at`, `updated_at`) VALUES
(1, 1, 'c', '2022-08-30 15:13:09', '2022-08-30 15:13:29');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_resets_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2022_07_29_192210_create_categories_table', 1),
(6, '2022_07_30_192519_create_spaces_table', 1),
(7, '2022_08_28_183615_create_students_table', 1),
(8, '2022_08_29_092621_create_referrals_table', 1),
(9, '2022_08_29_192004_create_questions_table', 1),
(10, '2022_08_29_192927_create_answers_table', 1),
(11, '2022_08_30_180907_create_key_answers_table', 1),
(12, '2022_09_01_171152_create_tests_table', 2),
(13, '2022_09_01_172631_create_he_answers_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `questions`
--

CREATE TABLE `questions` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `space_id` bigint(20) UNSIGNED NOT NULL,
  `question` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `questions`
--

INSERT INTO `questions` (`id`, `space_id`, `question`, `created_at`, `updated_at`) VALUES
(1, 1, 'ini pertanyaan 1', '2022-08-30 15:00:51', '2022-08-30 15:00:51'),
(2, 6, 'ini pertanyaan toefl stuctiure1', '2022-08-30 15:09:25', '2022-08-30 19:15:44'),
(3, 6, 'ini pertanyaan toefl listening 1', '2022-08-30 18:57:39', '2022-08-30 19:14:00'),
(6, 6, 'ini pertanyaan toefl stuctiure1', '2022-08-30 19:15:11', '2022-08-30 19:16:19');

-- --------------------------------------------------------

--
-- Table structure for table `referrals`
--

CREATE TABLE `referrals` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `referral` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','non-active') COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `referrals`
--

INSERT INTO `referrals` (`id`, `referral`, `status`, `created_at`, `updated_at`) VALUES
(1, 'sasadf', 'non-active', NULL, '2022-09-01 10:41:05'),
(2, '090455', 'non-active', '2022-09-02 13:00:04', '2022-09-02 13:00:36');

-- --------------------------------------------------------

--
-- Table structure for table `spaces`
--

CREATE TABLE `spaces` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `long_question` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `section` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `spaces`
--

INSERT INTO `spaces` (`id`, `category_id`, `long_question`, `created_at`, `updated_at`, `section`) VALUES
(1, 1, 'ini pertanyaan puanjangggg', '2022-08-30 14:58:22', '2022-08-30 15:07:04', NULL),
(2, 1, NULL, '2022-08-30 15:07:09', '2022-08-30 16:53:58', NULL),
(4, 1, 'jiaks', '2022-08-30 16:54:04', '2022-08-30 16:54:04', NULL),
(5, 2, 'jiaks', '2022-08-30 17:09:27', '2022-08-30 17:09:27', NULL),
(6, 3, 'ini space 1 toefl', '2022-08-30 18:08:24', '2022-08-30 21:53:28', 'structure'),
(11, 3, 'audio/815104.mp3', '2022-08-30 21:53:46', '2022-08-30 22:16:49', 'listening'),
(12, 3, 'audio/647856.mp3', '2022-08-30 22:17:33', '2022-08-30 22:17:33', 'listening'),
(13, 1, 'audio/707536.mp3', '2022-09-01 06:57:23', '2022-09-01 06:57:23', 'listening');

-- --------------------------------------------------------

--
-- Table structure for table `students`
--

CREATE TABLE `students` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `img` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `status` enum('active','non-active') COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `students`
--

INSERT INTO `students` (`id`, `img`, `name`, `email`, `status`, `email_verified_at`, `password`, `token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'default', 'rizky-student', 'riskipatra22@student.com', 'active', NULL, '$2y$10$z//kd7tIhoQd04FRJIM5xOv/RIH3sNHE2v2sVDd0te2wlJT7srQDu', '$2y$10$Rc.qrTTfx7omM1yrmAPCVOdG8mqx0cedM/9PKtCthsEcq2TQ.wewe', NULL, '2022-09-01 10:30:27', '2022-09-01 10:30:27'),
(2, 'default', 'rizky-student', 'riskipatra33@student.com', 'active', NULL, '$2y$10$JQ04s6dKKyd59XcpA7e1Eeqzs6iaQSVMkKw4hA2zNszqNYolcbVHi', '$2y$10$ywHZNzxnAhcCYN2fuRoo5utYIHs8WigbDVv8C5Zt4n78Lub3COaWO', NULL, '2022-09-01 10:41:05', '2022-09-06 15:58:05'),
(3, 'default', 'rizky-student', 'riskipatra2233@student.com', 'active', NULL, '$2y$10$d3p264KDDAFdCKMADClL5eJACyHDXFhbaEIFqzVL8MSkMVeIshCVS', '$2y$10$nzNxsltPUzMN4L4GkJOOoOeKqdQ3HhnW/CkIynq.N4EhdnR.n8mbu', NULL, '2022-09-02 13:00:36', '2022-09-02 13:00:36');

-- --------------------------------------------------------

--
-- Table structure for table `tests`
--

CREATE TABLE `tests` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `category_id` bigint(20) UNSIGNED NOT NULL,
  `student_id` bigint(20) UNSIGNED NOT NULL,
  `score` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `tests`
--

INSERT INTO `tests` (`id`, `category_id`, `student_id`, `score`, `created_at`, `updated_at`) VALUES
(1, 1, 1, NULL, NULL, NULL),
(2, 1, 2, NULL, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(191) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(191) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `token`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 'rizky', 'riskipatra5@gmail.com', NULL, '$2y$10$odFNC6I5oLeZCvqPvqHKLup3xqwxGI1/qiILrcSTKT3R4QpssqRFy', '$2y$10$KEaNWAZI9m6tNX9gX/md0.Gwe/6yyGN1ldhBXecaCoPqKbFuerNpC', NULL, '2022-08-30 12:47:28', '2022-09-06 15:53:52');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `answers`
--
ALTER TABLE `answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `answers_question_id_foreign` (`question_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `he_answers`
--
ALTER TABLE `he_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `he_answers_question_id_foreign` (`question_id`),
  ADD KEY `he_answers_test_id_foreign` (`test_id`);

--
-- Indexes for table `key_answers`
--
ALTER TABLE `key_answers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `key_answers_question_id_foreign` (`question_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `questions`
--
ALTER TABLE `questions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `questions_space_id_foreign` (`space_id`);

--
-- Indexes for table `referrals`
--
ALTER TABLE `referrals`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `spaces`
--
ALTER TABLE `spaces`
  ADD PRIMARY KEY (`id`),
  ADD KEY `spaces_category_id_foreign` (`category_id`);

--
-- Indexes for table `students`
--
ALTER TABLE `students`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `students_email_unique` (`email`);

--
-- Indexes for table `tests`
--
ALTER TABLE `tests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `tests_category_id_foreign` (`category_id`),
  ADD KEY `tests_student_id_foreign` (`student_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `answers`
--
ALTER TABLE `answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `he_answers`
--
ALTER TABLE `he_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `key_answers`
--
ALTER TABLE `key_answers`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `questions`
--
ALTER TABLE `questions`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `referrals`
--
ALTER TABLE `referrals`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `spaces`
--
ALTER TABLE `spaces`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `students`
--
ALTER TABLE `students`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tests`
--
ALTER TABLE `tests`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `answers`
--
ALTER TABLE `answers`
  ADD CONSTRAINT `answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `he_answers`
--
ALTER TABLE `he_answers`
  ADD CONSTRAINT `he_answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `he_answers_test_id_foreign` FOREIGN KEY (`test_id`) REFERENCES `tests` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `key_answers`
--
ALTER TABLE `key_answers`
  ADD CONSTRAINT `key_answers_question_id_foreign` FOREIGN KEY (`question_id`) REFERENCES `questions` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `questions`
--
ALTER TABLE `questions`
  ADD CONSTRAINT `questions_space_id_foreign` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `spaces`
--
ALTER TABLE `spaces`
  ADD CONSTRAINT `spaces_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tests`
--
ALTER TABLE `tests`
  ADD CONSTRAINT `tests_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `tests_student_id_foreign` FOREIGN KEY (`student_id`) REFERENCES `students` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

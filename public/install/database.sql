-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Aug 03, 2023 at 04:07 PM
-- Server version: 10.4.28-MariaDB
-- PHP Version: 8.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `adds`
--

CREATE TABLE `adds` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `section` tinyint(4) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `code_body` longtext DEFAULT NULL,
  `img_body` varchar(255) DEFAULT NULL,
  `img_url` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `adds`
--

INSERT INTO `adds` (`id`, `section`, `type`, `code_body`, `img_body`, `img_url`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 2, NULL, 'media/adds/1690178813_64be14fd719de_facebook-shared-image.png', 'http://google.com', 0, '2023-07-23 23:59:27', '2023-07-24 04:12:31'),
(2, 2, 1, '<div id=\"fb-root\"></div>\r\n<script async defer crossorigin=\"anonymous\" src=\"https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v17.0\" nonce=\"Qxlqol9P\"></script>\r\n\r\n<div class=\"fb-share-button\" data-href=\"https://developers.facebook.com/docs/plugins/\" data-layout=\"\" data-size=\"\"><a target=\"_blank\" href=\"https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse\" class=\"fb-xfbml-parse-ignore\">Share</a></div>', NULL, NULL, 0, '2023-07-23 23:59:27', '2023-07-24 03:12:04'),
(3, 3, 2, NULL, 'media/adds/1690178794_64be14ea948ac_linkedin-hero-image-1.png', NULL, 0, '2023-07-23 23:59:27', '2023-07-24 03:09:24');

-- --------------------------------------------------------

--
-- Table structure for table `conversion_histories`
--

CREATE TABLE `conversion_histories` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `unique_code` varchar(255) DEFAULT NULL,
  `user_agent` varchar(255) DEFAULT NULL,
  `user_ip` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `conversion_lists`
--

CREATE TABLE `conversion_lists` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `conversion_history_id` bigint(20) UNSIGNED NOT NULL,
  `file_name` varchar(255) NOT NULL,
  `file_url` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `original_url` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `uuid` varchar(255) NOT NULL,
  `connection` text NOT NULL,
  `queue` text NOT NULL,
  `payload` longtext NOT NULL,
  `exception` longtext NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `forget_passwords`
--

CREATE TABLE `forget_passwords` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `otp` int(11) DEFAULT NULL,
  `failed_attempt` smallint(6) NOT NULL DEFAULT 0,
  `token` varchar(255) DEFAULT NULL,
  `suspend_duration` varchar(255) NOT NULL DEFAULT '0',
  `resent_count` smallint(6) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_12_000000_create_users_table', 1),
(2, '2014_10_12_100000_create_password_reset_tokens_table', 1),
(3, '2019_08_19_000000_create_failed_jobs_table', 1),
(4, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(5, '2023_05_11_051813_create_forget_passwords_table', 1),
(6, '2023_05_22_105554_create_pages_table', 1),
(7, '2023_07_23_115038_create_adds_table', 1),
(14, '2023_07_26_041606_create_conversion_histories_table', 2),
(15, '2023_07_26_041613_create_conversion_lists_table', 2);

-- --------------------------------------------------------

--
-- Table structure for table `pages`
--

CREATE TABLE `pages` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `slug` varchar(255) NOT NULL,
  `content` longtext NOT NULL,
  `meta_title` varchar(255) DEFAULT NULL,
  `meta_description` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `pages`
--

INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `meta_title`, `meta_description`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Contact Us', 'contact', '<h1 style=\"font-family: &quot;Roboto Flex&quot;, sans-serif; color: rgb(34, 34, 34); letter-spacing: 0.8px;\">Our Contact</h1><h1 style=\"font-family: &quot;Roboto Flex&quot;, sans-serif; color: rgb(34, 34, 34); letter-spacing: 0.8px;\"><span style=\"letter-spacing: 0.8px;\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><p></p><p><span style=\"letter-spacing: 0.8px;\"><br></span></p><p><br style=\"color: rgb(33, 37, 41); font-family: &quot;Source Sans Pro&quot;, -apple-system, BlinkMacSystemFont, &quot;Segoe UI&quot;, Roboto, &quot;Helvetica Neue&quot;, Arial, sans-serif, &quot;Apple Color Emoji&quot;, &quot;Segoe UI Emoji&quot;, &quot;Segoe UI Symbol&quot;; font-size: 16px; letter-spacing: normal;\"></p></h1>', NULL, NULL, 1, '2023-07-24 01:53:00', '2023-07-24 05:10:06'),
(2, 'Our Services', 'services', '<h1 style=\"font-family: &quot;Roboto Flex&quot;, sans-serif; color: rgb(34, 34, 34); letter-spacing: 0.8px;\">Our Services</h1><span style=\"color: rgb(34, 34, 34); font-family: &quot;Roboto Flex&quot;, sans-serif; letter-spacing: 0.8px;\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><p></p><p><span style=\"color: rgb(34, 34, 34); font-family: &quot;Roboto Flex&quot;, sans-serif; letter-spacing: 0.8px;\"><br></span></p><p><br></p>', NULL, NULL, 0, '2023-07-24 01:53:09', '2023-07-24 05:09:49'),
(3, 'About me', 'about', '<p></p><h1 style=\"color: rgb(34, 34, 34); font-family: &quot;Roboto Flex&quot;, sans-serif; letter-spacing: 0.8px;\">About us</h1><span style=\"color: rgb(34, 34, 34); font-family: &quot;Roboto Flex&quot;, sans-serif; letter-spacing: 0.8px;\">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry\'s standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span><p></p><p><img style=\"width: 210px;\" src=\"data:image/gif;base64,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\" data-filename=\"SmallFullColourGIF (1).gif\"><span style=\"color: rgb(34, 34, 34); font-family: &quot;Roboto Flex&quot;, sans-serif; letter-spacing: 0.8px;\"><br></span></p><p><span style=\"color: rgb(34, 34, 34); font-family: &quot;Roboto Flex&quot;, sans-serif; letter-spacing: 0.8px;\"><br></span></p><p><span style=\"color: rgb(34, 34, 34); font-family: &quot;Roboto Flex&quot;, sans-serif; letter-spacing: 0.8px;\"><br></span></p><p><span style=\"color: rgb(34, 34, 34); font-family: &quot;Roboto Flex&quot;, sans-serif; letter-spacing: 0.8px;\"><br></span></p><p><span style=\"color: rgb(34, 34, 34); font-family: &quot;Roboto Flex&quot;, sans-serif; letter-spacing: 0.8px;\"><br></span></p><p><span style=\"color: rgb(34, 34, 34); font-family: &quot;Roboto Flex&quot;, sans-serif; letter-spacing: 0.8px;\"><br></span></p><p><span style=\"color: rgb(34, 34, 34); font-family: &quot;Roboto Flex&quot;, sans-serif; letter-spacing: 0.8px;\"><br></span></p><p><span style=\"color: rgb(34, 34, 34); font-family: &quot;Roboto Flex&quot;, sans-serif; letter-spacing: 0.8px;\"><br></span></p><p><span style=\"color: rgb(34, 34, 34); font-family: &quot;Roboto Flex&quot;, sans-serif; letter-spacing: 0.8px;\"><br></span></p><p><span style=\"color: rgb(34, 34, 34); font-family: &quot;Roboto Flex&quot;, sans-serif; letter-spacing: 0.8px;\"><br></span></p><p><span style=\"color: rgb(34, 34, 34); font-family: &quot;Roboto Flex&quot;, sans-serif; letter-spacing: 0.8px;\"><br></span></p><p><span style=\"color: rgb(34, 34, 34); font-family: &quot;Roboto Flex&quot;, sans-serif; letter-spacing: 0.8px;\">&nbsp;Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</span></p><p><span style=\"color: rgb(34, 34, 34); font-family: &quot;Roboto Flex&quot;, sans-serif; letter-spacing: 0.8px;\"><br></span></p><p><span style=\"color: rgb(34, 34, 34); font-family: &quot;Roboto Flex&quot;, sans-serif; letter-spacing: 0.8px;\">BYEEEEEEEEEEEEEEEEEEEEEE<br></span><span style=\"color: rgb(34, 34, 34); font-family: &quot;Roboto Flex&quot;, sans-serif; letter-spacing: 0.8px;\"><br></span></p>', NULL, NULL, 1, '2023-07-24 01:53:17', '2023-07-24 04:59:40');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset_tokens`
--

CREATE TABLE `password_reset_tokens` (
  `email` varchar(255) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) NOT NULL,
  `tokenable_id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `token` varchar(64) NOT NULL,
  `abilities` text DEFAULT NULL,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `type` varchar(255) NOT NULL DEFAULT 'User',
  `username` varchar(255) NOT NULL,
  `profile_image` varchar(255) DEFAULT NULL,
  `google_id` varchar(255) DEFAULT NULL,
  `is_google_registered` tinyint(1) NOT NULL DEFAULT 0,
  `is_suspended` tinyint(1) NOT NULL DEFAULT 0,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `type`, `username`, `profile_image`, `google_id`, `is_google_registered`, `is_suspended`, `created_at`, `updated_at`) VALUES
(1, 'Mr Admin', 'asd@mail.com', NULL, '$2y$10$B0KvTho.ApmI6LvATzz8RuWDAyagSqAxcQ9LY2cSyFpvqe.rTSB4W', NULL, 'Admin', '64c222cb106fe', NULL, NULL, 0, 0, '2023-07-27 01:54:51', '2023-07-27 01:54:51');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `adds`
--
ALTER TABLE `adds`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversion_histories`
--
ALTER TABLE `conversion_histories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `conversion_lists`
--
ALTER TABLE `conversion_lists`
  ADD PRIMARY KEY (`id`),
  ADD KEY `conversion_lists_conversion_history_id_foreign` (`conversion_history_id`);

--
-- Indexes for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indexes for table `forget_passwords`
--
ALTER TABLE `forget_passwords`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `forget_passwords_user_id_unique` (`user_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `pages`
--
ALTER TABLE `pages`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `pages_slug_unique` (`slug`);

--
-- Indexes for table `password_reset_tokens`
--
ALTER TABLE `password_reset_tokens`
  ADD PRIMARY KEY (`email`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD UNIQUE KEY `users_username_unique` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adds`
--
ALTER TABLE `adds`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `conversion_histories`
--
ALTER TABLE `conversion_histories`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `conversion_lists`
--
ALTER TABLE `conversion_lists`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `forget_passwords`
--
ALTER TABLE `forget_passwords`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `pages`
--
ALTER TABLE `pages`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `conversion_lists`
--
ALTER TABLE `conversion_lists`
  ADD CONSTRAINT `conversion_lists_conversion_history_id_foreign` FOREIGN KEY (`conversion_history_id`) REFERENCES `conversion_histories` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

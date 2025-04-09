-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 08, 2025 at 06:07 AM
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
-- Database: `rajas`
--

-- --------------------------------------------------------

--
-- Table structure for table `appointments`
--

CREATE TABLE `appointments` (
  `id` int(10) UNSIGNED NOT NULL,
  `google_appointment_id` varchar(255) DEFAULT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `admin_id` int(11) NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `category_id` varchar(255) DEFAULT NULL,
  `service_id` varchar(255) NOT NULL,
  `date` date NOT NULL,
  `start_time` time NOT NULL,
  `finish_time` time NOT NULL,
  `comments` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'pending' COMMENT 'pending',
  `note` varchar(255) DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `cancel_reason` varchar(255) DEFAULT NULL,
  `appointment_process` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0-Complete,1-Processing',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_services`
--

CREATE TABLE `employee_services` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `category_id` int(11) NOT NULL,
  `service_id` int(10) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `employee_settings`
--

CREATE TABLE `employee_settings` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `access_token` text NOT NULL,
  `refresh_token` text NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '2014_10_11_000000_create_roles_table', 1),
(2, '2014_10_12_000000_create_users_table', 1),
(3, '2014_10_12_100000_create_password_resets_table', 1),
(4, '2018_10_14_141048_create_working_hours_table', 1),
(5, '2018_10_14_142201_create_services_table', 1),
(6, '2018_10_14_142638_create_employee_services_table', 1),
(7, '2018_10_14_142920_create_appointments_table', 1),
(8, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(9, '2022_07_28_063624_create_categories_table', 1),
(10, '2022_08_06_101808_create_payments_table', 1),
(11, '2022_08_31_103859_create_settings_table', 1),
(12, '2022_09_06_122057_create_payment_details_table', 1),
(13, '2022_09_08_112052_create_site_configs_table', 1),
(14, '2022_09_30_161702_create_notification_table', 1),
(15, '2023_05_11_105720_create_employee_settings_table', 1),
(16, '2023_05_11_152009_add_client_id_column_to_settings_table', 1),
(17, '2023_05_26_094211_add_country_code_column_to_site_configs_table', 1),
(18, '2023_05_26_094957_add_col_twillio_country_column_to_settings_table', 1),
(19, '2023_05_26_100552_add_col_country_column_to_users_table', 1),
(20, '2023_09_04_103615_add_col_companyname_column_to_site_configs_table', 1),
(21, '2023_09_12_063140_add_col_employee_column_to_settings_table', 1),
(22, '2024_01_17_182722_add_google_appointment_id_to_appointments_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `notification`
--

CREATE TABLE `notification` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `admin_id` int(11) NOT NULL,
  `employee_id` int(11) NOT NULL,
  `appointment_id` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL,
  `is_read` tinyint(4) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `notification`
--

INSERT INTO `notification` (`id`, `user_id`, `admin_id`, `employee_id`, `appointment_id`, `type`, `message`, `is_read`, `created_at`, `updated_at`) VALUES
(1, 2, 1, 0, '', 'customer', 'Hey Mahtab Alam, Thanks for registration. Enjoy unlimited appointment of different services!', 1, '2025-04-03 12:03:53', '2025-04-03 12:12:02');

-- --------------------------------------------------------

--
-- Table structure for table `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(100) NOT NULL,
  `token` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payments`
--

CREATE TABLE `payments` (
  `id` int(10) UNSIGNED NOT NULL,
  `appointment_id` int(10) UNSIGNED NOT NULL,
  `payment_method` varchar(255) NOT NULL DEFAULT 'offline',
  `payment_id` text NOT NULL,
  `currency` varchar(255) NOT NULL,
  `amount` double NOT NULL,
  `payment_type` varchar(255) DEFAULT NULL,
  `payment_detail_id` int(11) DEFAULT NULL,
  `upi_id` varchar(255) DEFAULT NULL,
  `status` varchar(255) NOT NULL,
  `payment_date` date DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_details`
--

CREATE TABLE `payment_details` (
  `id` int(10) UNSIGNED NOT NULL,
  `account_no` varchar(255) NOT NULL,
  `cheque_no` varchar(255) NOT NULL,
  `account_holder_name` varchar(255) NOT NULL,
  `bank_name` varchar(255) NOT NULL,
  `ifsc_code` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

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
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `roles`
--

CREATE TABLE `roles` (
  `id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `roles`
--

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'admin', NULL, NULL),
(2, 'client', NULL, NULL),
(3, 'employee', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `services`
--

CREATE TABLE `services` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` varchar(255) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` double NOT NULL,
  `description` text NOT NULL,
  `duration` time NOT NULL,
  `auto_approve` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0->no,1->yes',
  `cancel_before` time NOT NULL,
  `image` varchar(121) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(10) UNSIGNED NOT NULL,
  `smtp_email` varchar(100) DEFAULT NULL,
  `smtp_password` text DEFAULT NULL,
  `smtp_host` varchar(255) DEFAULT NULL,
  `smtp_port` int(11) DEFAULT NULL,
  `smtp_mail` tinyint(4) NOT NULL DEFAULT 0,
  `stripe_key` varchar(255) DEFAULT NULL,
  `stripe_secret` varchar(255) DEFAULT NULL,
  `stripe_live_key` varchar(255) DEFAULT NULL,
  `stripe_secret_live` varchar(255) DEFAULT NULL,
  `is_stripe` tinyint(4) NOT NULL DEFAULT 0,
  `stripe_active_mode` varchar(255) NOT NULL DEFAULT '0',
  `is_paypal` tinyint(4) NOT NULL DEFAULT 0,
  `paypal_active_mode` varchar(255) NOT NULL DEFAULT '0',
  `paypal_client_id` text DEFAULT NULL,
  `paypal_client_secret` text DEFAULT NULL,
  `paypal_locale` varchar(255) NOT NULL DEFAULT 'en_US',
  `paypal_live_client_id` varchar(255) DEFAULT NULL,
  `paypal_client_secret_live` varchar(255) DEFAULT NULL,
  `currency` varchar(255) NOT NULL DEFAULT 'inr',
  `currency_icon` varchar(255) DEFAULT NULL,
  `custom_field_text` varchar(255) NOT NULL DEFAULT 'employee',
  `custom_field_category` varchar(255) NOT NULL DEFAULT 'category',
  `custom_field_service` varchar(255) NOT NULL DEFAULT 'service',
  `custom_time_slot` tinyint(4) NOT NULL DEFAULT 0,
  `is_razorpay` tinyint(4) NOT NULL DEFAULT 0,
  `razorpay_active_mode` varchar(255) NOT NULL DEFAULT '0',
  `timezone` varchar(255) NOT NULL DEFAULT 'UTC',
  `date_format` varchar(255) DEFAULT 'Y-m-d',
  `categories` tinyint(4) NOT NULL DEFAULT 0,
  `employees` tinyint(4) NOT NULL DEFAULT 1,
  `is_payment_later` tinyint(4) NOT NULL DEFAULT 1,
  `razorpay_test_key` varchar(255) DEFAULT NULL,
  `razorpay_test_secret` varchar(255) DEFAULT NULL,
  `razorpay_live_key` varchar(255) DEFAULT NULL,
  `razorpay_live_secret` varchar(255) DEFAULT NULL,
  `notification` tinyint(4) NOT NULL DEFAULT 0,
  `twilio_active_mode` tinyint(4) NOT NULL DEFAULT 0,
  `twilio_notify_customer` tinyint(4) NOT NULL DEFAULT 1,
  `twilio_notify_employee` tinyint(4) NOT NULL DEFAULT 0,
  `twilio_notify_admin` tinyint(4) NOT NULL DEFAULT 0,
  `use_twilio_service_id` tinyint(4) NOT NULL DEFAULT 0,
  `twilio_service_id` varchar(255) NOT NULL,
  `twilio_sandbox_key` varchar(255) NOT NULL,
  `twilio_sandbox_secret` varchar(255) NOT NULL,
  `twilio_live_key` varchar(255) NOT NULL,
  `twilio_live_secret` varchar(255) NOT NULL,
  `country_name` varchar(255) NOT NULL,
  `country_code` varchar(255) NOT NULL,
  `twilio_phone` varchar(255) NOT NULL,
  `google_client_id` text DEFAULT NULL,
  `google_client_secret` text DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `smtp_email`, `smtp_password`, `smtp_host`, `smtp_port`, `smtp_mail`, `stripe_key`, `stripe_secret`, `stripe_live_key`, `stripe_secret_live`, `is_stripe`, `stripe_active_mode`, `is_paypal`, `paypal_active_mode`, `paypal_client_id`, `paypal_client_secret`, `paypal_locale`, `paypal_live_client_id`, `paypal_client_secret_live`, `currency`, `currency_icon`, `custom_field_text`, `custom_field_category`, `custom_field_service`, `custom_time_slot`, `is_razorpay`, `razorpay_active_mode`, `timezone`, `date_format`, `categories`, `employees`, `is_payment_later`, `razorpay_test_key`, `razorpay_test_secret`, `razorpay_live_key`, `razorpay_live_secret`, `notification`, `twilio_active_mode`, `twilio_notify_customer`, `twilio_notify_employee`, `twilio_notify_admin`, `use_twilio_service_id`, `twilio_service_id`, `twilio_sandbox_key`, `twilio_sandbox_secret`, `twilio_live_key`, `twilio_live_secret`, `country_name`, `country_code`, `twilio_phone`, `google_client_id`, `google_client_secret`, `created_at`, `updated_at`) VALUES
(1, 'john@example.com', 'eyJpdiI6IkRzY092S2NPTXAyMlV2aVJwTXgwL2c9PSIsInZhbHVlIjoib2g2SEMyQW5oOFF4OVR3RnZERkxIUT09IiwibWFjIjoiZjk3NWI4NWNkNTkxZjM1MGZlYWVlZWZiZWVjMTk0N2QyNzJmYWJhOWYyNjFlMGE4NjlmNTJmNDUxM2I2M2ExNCIsInRhZyI6IiJ9', 'smtp.gmail.com', 587, 0, '', '', '', '', 0, '0', 0, '0', '', '', 'en_US', '', '', 'USD', '$', 'employee', 'category', 'service', 0, 0, '0', 'UTC', 'Y-m-d', 0, 1, 1, '', '', '', '', 0, 0, 1, 0, 0, 0, '', '', '', '', '', '', '', '', NULL, NULL, '2025-04-02 11:54:00', '2025-04-02 11:54:00');

-- --------------------------------------------------------

--
-- Table structure for table `site_configs`
--

CREATE TABLE `site_configs` (
  `id` int(10) UNSIGNED NOT NULL,
  `company_name` varchar(255) DEFAULT 'ReadyBook',
  `site_title` varchar(255) NOT NULL,
  `about_company` text NOT NULL,
  `address` text NOT NULL,
  `email` text NOT NULL,
  `country_name` varchar(255) DEFAULT NULL,
  `country_code` varchar(255) DEFAULT NULL,
  `phone` text NOT NULL,
  `facebook` varchar(255) NOT NULL,
  `twitter` varchar(255) NOT NULL,
  `linkedin` varchar(255) NOT NULL,
  `instagram` varchar(255) NOT NULL,
  `logo` varchar(255) DEFAULT NULL,
  `favicon` varchar(255) DEFAULT NULL,
  `location` longtext DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `site_configs`
--

INSERT INTO `site_configs` (`id`, `company_name`, `site_title`, `about_company`, `address`, `email`, `country_name`, `country_code`, `phone`, `facebook`, `twitter`, `linkedin`, `instagram`, `logo`, `favicon`, `location`, `created_at`, `updated_at`) VALUES
(1, 'ReadyBook', 'Appointment Booking System', 'About Us Appointment Booking Company', '103, Bonanza Trade Centre, East Bonanza Road, Las Vegas, USA, 88901', 'booking@gmail.com', NULL, NULL, '+19876543210', 'https://www.facebook.com/', 'https://www.twitter.com/', 'https://in.linkedin.com/', 'https://www.instagram.com/', NULL, NULL, '<iframe src=\"https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d25765.591349056853!2d-115.13562712118132!3d36.17388057976022!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c8c34ccd3f00f1%3A0xed9d41fbe9875fec!2sEast%20Las%20Vegas%2C%20Las%20Vegas%2C%20NV%2C%20USA!5e0!3m2!1sen!2sin!4v1705493109583!5m2!1sen!2sin\" width=\"400\" height=\"300\" style=\"border:0;\" allowfullscreen=\"\" loading=\"lazy\" referrerpolicy=\"no-referrer-when-downgrade\"></iframe>', '2025-04-02 11:54:00', '2025-04-02 11:54:00');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(10) UNSIGNED NOT NULL,
  `parent_user_id` int(11) NOT NULL DEFAULT 1,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `country_name` varchar(255) DEFAULT NULL,
  `country_code` varchar(255) DEFAULT NULL,
  `phone` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `position` varchar(50) DEFAULT NULL,
  `password` varchar(100) NOT NULL,
  `facebook` varchar(121) DEFAULT NULL,
  `instagram` varchar(121) DEFAULT NULL,
  `twitter` varchar(121) DEFAULT NULL,
  `linkedin` varchar(121) DEFAULT NULL,
  `confirmed` tinyint(1) NOT NULL DEFAULT 0,
  `role_id` int(10) UNSIGNED NOT NULL,
  `profile` varchar(255) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0->Inactive,1->active,2->leave',
  `remember_token` varchar(100) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `parent_user_id`, `first_name`, `last_name`, `country_name`, `country_code`, `phone`, `email`, `position`, `password`, `facebook`, `instagram`, `twitter`, `linkedin`, `confirmed`, `role_id`, `profile`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'John', 'Doe', NULL, NULL, '3834300000', 'admin@gmail.com', 'Administrator', '$2y$10$fTDnms3ymX9OiNthkJHEI.GBSGXVhvGGGQ8pkjOAwYuXhMUWVoobm', NULL, NULL, NULL, NULL, 1, 1, NULL, 1, NULL, '2025-04-02 11:53:59', '2025-04-02 11:53:59'),
(2, 1, 'Mahtab', 'Alam', 'in', '+91', '7678677867', 'mehtab.makent@gmail.com', NULL, '$2y$10$AsOhQVLuCoQn6MNlYCUGD.BkYxj4Y/Ojh6hqQGeOljO8CrEZPRqXa', NULL, NULL, NULL, NULL, 0, 2, NULL, 1, NULL, '2025-04-03 12:03:53', '2025-04-03 12:03:53');

-- --------------------------------------------------------

--
-- Table structure for table `working_hours`
--

CREATE TABLE `working_hours` (
  `id` int(10) UNSIGNED NOT NULL,
  `user_id` int(11) NOT NULL,
  `employee_id` int(10) UNSIGNED NOT NULL,
  `days` text DEFAULT NULL,
  `start_time` time NOT NULL,
  `finish_time` time NOT NULL,
  `rest_time` time NOT NULL,
  `break_start_time` time DEFAULT NULL,
  `break_end_time` time DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1 COMMENT '0->Inactive,1->active,2->leave',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `working_hours`
--

INSERT INTO `working_hours` (`id`, `user_id`, `employee_id`, `days`, `start_time`, `finish_time`, `rest_time`, `break_start_time`, `break_end_time`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, 1, '[\"0\",\"1\",\"2\",\"3\",\"4\",\"5\",\"6\"]', '09:00:00', '18:00:00', '00:30:00', '13:00:00', '13:30:00', 1, '2025-04-02 11:53:59', '2025-04-02 11:53:59');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `appointments`
--
ALTER TABLE `appointments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `appointments_employee_id_foreign` (`employee_id`),
  ADD KEY `appointments_user_id_foreign` (`user_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `employee_services`
--
ALTER TABLE `employee_services`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_services_employee_id_foreign` (`employee_id`),
  ADD KEY `employee_services_service_id_foreign` (`service_id`);

--
-- Indexes for table `employee_settings`
--
ALTER TABLE `employee_settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `employee_settings_employee_id_foreign` (`employee_id`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notification`
--
ALTER TABLE `notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `password_resets`
--
ALTER TABLE `password_resets`
  ADD KEY `password_resets_email_index` (`email`);

--
-- Indexes for table `payments`
--
ALTER TABLE `payments`
  ADD PRIMARY KEY (`id`),
  ADD KEY `payments_appointment_id_foreign` (`appointment_id`);

--
-- Indexes for table `payment_details`
--
ALTER TABLE `payment_details`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indexes for table `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `services`
--
ALTER TABLE `services`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_configs`
--
ALTER TABLE `site_configs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `users_email_unique` (`email`),
  ADD KEY `users_role_id_foreign` (`role_id`);

--
-- Indexes for table `working_hours`
--
ALTER TABLE `working_hours`
  ADD PRIMARY KEY (`id`),
  ADD KEY `working_hours_employee_id_foreign` (`employee_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `appointments`
--
ALTER TABLE `appointments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_services`
--
ALTER TABLE `employee_services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `employee_settings`
--
ALTER TABLE `employee_settings`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `notification`
--
ALTER TABLE `notification`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `payments`
--
ALTER TABLE `payments`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_details`
--
ALTER TABLE `payment_details`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `roles`
--
ALTER TABLE `roles`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `services`
--
ALTER TABLE `services`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `site_configs`
--
ALTER TABLE `site_configs`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `working_hours`
--
ALTER TABLE `working_hours`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

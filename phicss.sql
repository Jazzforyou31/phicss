-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 25, 2025 at 12:56 AM
-- Server version: 11.6.2-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `phicss`
--

-- --------------------------------------------------------

--
-- Table structure for table `about_phicss`
--

CREATE TABLE `about_phicss` (
  `info_id` int(11) NOT NULL,
  `mission` text DEFAULT NULL,
  `vision` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `account`
--

CREATE TABLE `account` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(50) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `datetime_sign_up` datetime DEFAULT current_timestamp(),
  `datetime_last_online` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `role` enum('admin','moderator') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`user_id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `email`, `datetime_sign_up`, `datetime_last_online`, `role`) VALUES
(1, 'nice', 'nice', 'nice', 'nice', 'nice', 'nice', '2025-03-07 07:47:00', '2025-03-07 07:47:00', 'admin');

-- --------------------------------------------------------

--
-- Table structure for table `announcements`
--

CREATE TABLE `announcements` (
  `announcement_id` int(11) NOT NULL,
  `announcement_title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `announcement_date` datetime DEFAULT NULL,
  `created_by` int(11) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bylaws`
--

CREATE TABLE `bylaws` (
  `bylaw_id` int(11) NOT NULL,
  `section_no` int(11) NOT NULL,
  `article_no` int(11) NOT NULL,
  `content` text NOT NULL,
  `effective_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `bylaw_signatories`
--

CREATE TABLE `bylaw_signatories` (
  `bylaw_id` int(11) NOT NULL,
  `officer_id` int(11) NOT NULL,
  `date_signed` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(11) NOT NULL,
  `address` varchar(255) NOT NULL,
  `contact_number` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `schedule` varchar(255) NOT NULL,
  `user_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `department_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `event_id` int(11) NOT NULL,
  `event_name` varchar(255) NOT NULL,
  `event_category` varchar(255) NOT NULL,
  `event_audience` varchar(255) NOT NULL,
  `image` longtext DEFAULT NULL,
  `event_description` text DEFAULT NULL,
  `created_by` int(11) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `assigned_officers` text DEFAULT NULL,
  `event_venue` varchar(255) DEFAULT NULL,
  `event_start_date` datetime DEFAULT NULL,
  `event_end_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`event_id`, `event_name`, `event_category`, `event_audience`, `image`, `event_description`, `created_by`, `created_at`, `updated_at`, `updated_by`, `assigned_officers`, `event_venue`, `event_start_date`, `event_end_date`) VALUES
(1, 'event try', 'event try', 'event try', 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fen.wikipedia.org%2Fwiki%2FChucky_%2528Child%2527s_Play%2529&psig=AOvVaw1d1EfuBPSqcAmuS0h86H9J&ust=1742946534617000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCJjPrvvzo4wDFQAAAAAdAAAAABAE', 'event try', 1, '2025-03-06 07:50:35', '2025-03-21 07:50:35', NULL, 'event try', 'event try', '2025-03-26 07:50:35', '2025-03-28 07:50:35');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `faq_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `category` varchar(255) NOT NULL,
  `is_active` tinyint(1) DEFAULT 1,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `gallery`
--

CREATE TABLE `gallery` (
  `gallery_id` int(11) NOT NULL,
  `gallery_name` varchar(255) NOT NULL,
  `event_id` int(11) DEFAULT NULL,
  `project_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `news_title` varchar(255) NOT NULL,
  `news_description` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `image` longtext DEFAULT NULL,
  `news_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `news_title`, `news_description`, `message`, `image`, `news_date`, `created_at`, `created_by`, `updated_at`, `updated_by`, `author`) VALUES
(1, 'nice', 'nice', 'nice', 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fen.wikipedia.org%2Fwiki%2FChucky_%2528Child%2527s_Play%2529&psig=AOvVaw1d1EfuBPSqcAmuS0h86H9J&ust=1742946534617000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCJjPrvvzo4wDFQAAAAAdAAAAABAE', '0000-00-00', '2025-03-19 07:48:04', 1, '2025-03-25 07:49:21', 1, 'cx'),
(9, 'try', 'try', 'try', '1730975328188.png', '2025-03-07', '2025-03-25 07:49:49', 1, '2025-03-25 07:49:49', NULL, 'try');

-- --------------------------------------------------------

--
-- Table structure for table `officers`
--

CREATE TABLE `officers` (
  `officer_id` int(11) NOT NULL,
  `full_name` varchar(255) NOT NULL,
  `image` longtext DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `school_year_id` int(11) DEFAULT NULL,
  `department_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `position` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school_year`
--

CREATE TABLE `school_year` (
  `school_year_id` int(11) NOT NULL,
  `school_year` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `socials`
--

CREATE TABLE `socials` (
  `social_id` int(11) NOT NULL,
  `social_name` varchar(255) NOT NULL,
  `officer_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transparency_link`
--

CREATE TABLE `transparency_link` (
  `id` int(11) NOT NULL,
  `section_id` int(11) NOT NULL,
  `document_title` varchar(255) NOT NULL,
  `document_link` text NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transparency_link`
--

INSERT INTO `transparency_link` (`id`, `section_id`, `document_title`, `document_link`, `created_at`, `updated_at`, `created_by`, `updated_by`) VALUES
(1, 1, 'BSCS-2C', 'https://www.imdb.com/title/tt0094862/', '2025-03-14 07:52:57', '2025-03-20 07:52:57', 1, 1),
(2, 1, 'DS', 'DS', '2025-03-06 07:55:02', '2025-03-13 07:55:02', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `transparency_section`
--

CREATE TABLE `transparency_section` (
  `id` int(11) NOT NULL,
  `section_title` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transparency_section`
--

INSERT INTO `transparency_section` (`id`, `section_title`, `created_at`, `created_by`, `updated_by`) VALUES
(1, 'Transparency Report Management for 2025', '2025-03-14 07:52:03', 1, 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about_phicss`
--
ALTER TABLE `about_phicss`
  ADD PRIMARY KEY (`info_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `account`
--
ALTER TABLE `account`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `announcements`
--
ALTER TABLE `announcements`
  ADD PRIMARY KEY (`announcement_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `bylaws`
--
ALTER TABLE `bylaws`
  ADD PRIMARY KEY (`bylaw_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `bylaw_signatories`
--
ALTER TABLE `bylaw_signatories`
  ADD PRIMARY KEY (`bylaw_id`,`officer_id`),
  ADD KEY `officer_id` (`officer_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`event_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`faq_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`gallery_id`),
  ADD KEY `fk_gallery_event` (`event_id`),
  ADD KEY `fk_gallery_project` (`project_id`);

--
-- Indexes for table `news`
--
ALTER TABLE `news`
  ADD PRIMARY KEY (`news_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `officers`
--
ALTER TABLE `officers`
  ADD PRIMARY KEY (`officer_id`),
  ADD UNIQUE KEY `user_id` (`user_id`),
  ADD KEY `school_year_id` (`school_year_id`),
  ADD KEY `department_id` (`department_id`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `school_year`
--
ALTER TABLE `school_year`
  ADD PRIMARY KEY (`school_year_id`);

--
-- Indexes for table `socials`
--
ALTER TABLE `socials`
  ADD PRIMARY KEY (`social_id`),
  ADD KEY `officer_id` (`officer_id`);

--
-- Indexes for table `transparency_link`
--
ALTER TABLE `transparency_link`
  ADD PRIMARY KEY (`id`),
  ADD KEY `section_id` (`section_id`),
  ADD KEY `fk_transparency_link_created_by` (`created_by`),
  ADD KEY `fk_transparency_link_updated_by` (`updated_by`);

--
-- Indexes for table `transparency_section`
--
ALTER TABLE `transparency_section`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_transparency_section_created_by` (`created_by`),
  ADD KEY `fk_transparency_section_updated_by` (`updated_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_phicss`
--
ALTER TABLE `about_phicss`
  MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `announcements`
--
ALTER TABLE `announcements`
  MODIFY `announcement_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `bylaws`
--
ALTER TABLE `bylaws`
  MODIFY `bylaw_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `event_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `gallery_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `officers`
--
ALTER TABLE `officers`
  MODIFY `officer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school_year`
--
ALTER TABLE `school_year`
  MODIFY `school_year_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `socials`
--
ALTER TABLE `socials`
  MODIFY `social_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transparency_link`
--
ALTER TABLE `transparency_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `transparency_section`
--
ALTER TABLE `transparency_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `about_phicss`
--
ALTER TABLE `about_phicss`
  ADD CONSTRAINT `about_phicss_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `account` (`user_id`),
  ADD CONSTRAINT `about_phicss_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `account` (`user_id`);

--
-- Constraints for table `announcements`
--
ALTER TABLE `announcements`
  ADD CONSTRAINT `announcements_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `account` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `announcements_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `account` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `bylaws`
--
ALTER TABLE `bylaws`
  ADD CONSTRAINT `bylaws_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `account` (`user_id`),
  ADD CONSTRAINT `bylaws_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `account` (`user_id`);

--
-- Constraints for table `bylaw_signatories`
--
ALTER TABLE `bylaw_signatories`
  ADD CONSTRAINT `bylaw_signatories_ibfk_1` FOREIGN KEY (`bylaw_id`) REFERENCES `bylaws` (`bylaw_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `bylaw_signatories_ibfk_2` FOREIGN KEY (`officer_id`) REFERENCES `officers` (`officer_id`) ON DELETE CASCADE;

--
-- Constraints for table `contacts`
--
ALTER TABLE `contacts`
  ADD CONSTRAINT `contacts_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `account` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `events_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `account` (`user_id`);

--
-- Constraints for table `faqs`
--
ALTER TABLE `faqs`
  ADD CONSTRAINT `faqs_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `account` (`user_id`),
  ADD CONSTRAINT `faqs_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `account` (`user_id`);

--
-- Constraints for table `gallery`
--
ALTER TABLE `gallery`
  ADD CONSTRAINT `fk_gallery_event` FOREIGN KEY (`event_id`) REFERENCES `events` (`event_id`) ON DELETE CASCADE;

--
-- Constraints for table `news`
--
ALTER TABLE `news`
  ADD CONSTRAINT `news_ibfk_1` FOREIGN KEY (`created_by`) REFERENCES `account` (`user_id`),
  ADD CONSTRAINT `news_ibfk_2` FOREIGN KEY (`updated_by`) REFERENCES `account` (`user_id`);

--
-- Constraints for table `officers`
--
ALTER TABLE `officers`
  ADD CONSTRAINT `officers_ibfk_1` FOREIGN KEY (`school_year_id`) REFERENCES `school_year` (`school_year_id`),
  ADD CONSTRAINT `officers_ibfk_2` FOREIGN KEY (`department_id`) REFERENCES `department` (`department_id`),
  ADD CONSTRAINT `officers_ibfk_3` FOREIGN KEY (`user_id`) REFERENCES `account` (`user_id`),
  ADD CONSTRAINT `officers_ibfk_4` FOREIGN KEY (`updated_by`) REFERENCES `account` (`user_id`);

--
-- Constraints for table `socials`
--
ALTER TABLE `socials`
  ADD CONSTRAINT `socials_ibfk_1` FOREIGN KEY (`officer_id`) REFERENCES `officers` (`officer_id`) ON DELETE CASCADE;

--
-- Constraints for table `transparency_link`
--
ALTER TABLE `transparency_link`
  ADD CONSTRAINT `fk_transparency_link_created_by` FOREIGN KEY (`created_by`) REFERENCES `account` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_transparency_link_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `account` (`user_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `transparency_link_ibfk_1` FOREIGN KEY (`section_id`) REFERENCES `transparency_section` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `transparency_section`
--
ALTER TABLE `transparency_section`
  ADD CONSTRAINT `fk_transparency_section_created_by` FOREIGN KEY (`created_by`) REFERENCES `account` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_transparency_section_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `account` (`user_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

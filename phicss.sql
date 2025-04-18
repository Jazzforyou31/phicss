-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2025 at 01:02 PM
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
  `updated_by` int(11) DEFAULT NULL,
  `phicss_image` longtext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about_phicss`
--

INSERT INTO `about_phicss` (`info_id`, `mission`, `vision`, `description`, `created_at`, `created_by`, `updated_at`, `updated_by`, `phicss_image`) VALUES
(1, 'The Western Mindanao State University, set in a culturally diverse environment, shall pursue a vibrant socio-economic agenda that include:\r\n• A relevant instruction paradigm in the education and training of competent and responsive human resource for societal and industry needs;\r\n• A home for intellectual formation that generates knowledge for people empowerment, social transformation and sustainable development; and,\r\n• A hub where science, technology and innovation flourish, enriched by the wisdom of the Arts and Letters, and Philosophy.', 'The University of Choice for higher learning with strong research orientation that produces professionals who are socially responsive to and responsible for human development; ecological sustainability; and, peace and security within and beyond the region', 'As PhiCSS operates within the College of Computing Studies, it falls under the direct supervision of both the Dean of the College of Computing Studies and the Dean of Student Affairs.', '2025-03-11 23:44:06', 3, '2025-04-17 21:46:34', 3, NULL);

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
  `role` enum('admin','moderator','student') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `account`
--

INSERT INTO `account` (`user_id`, `username`, `password`, `first_name`, `middle_name`, `last_name`, `email`, `datetime_sign_up`, `datetime_last_online`, `role`) VALUES
(3, 'nesty', '$2y$10$sfe9AeFrSg4AxH8Jgy9QgulVi37ApTT6HvluJ1Tenl5AdD67b35/K', 'nesty', 'nesty', 'nesty', 'nestyomongos315@gmail.com', '2025-04-06 10:21:17', '2025-04-16 00:15:01', 'admin'),
(4, 'nicorobin', 'nicorobin315', 'robin', 'haha', 'nico', 'nicorobin315@wmsu.edu.ph', '2025-04-16 23:47:14', '2025-04-18 12:31:58', 'admin');

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
-- Table structure for table `cash_in`
--

CREATE TABLE `cash_in` (
  `id` int(11) NOT NULL,
  `collection_id` int(11) NOT NULL,
  `collection_date` date NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cash_in`
--

INSERT INTO `cash_in` (`id`, `collection_id`, `collection_date`, `amount`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-04-16', 3500.00, 3, 3, '2025-04-18 16:35:34', '2025-04-18 16:35:34'),
(2, 1, '2025-04-19', 2500.00, 3, 3, '2025-04-18 17:26:53', '2025-04-18 17:27:22');

-- --------------------------------------------------------

--
-- Table structure for table `cash_out`
--

CREATE TABLE `cash_out` (
  `id` int(11) NOT NULL,
  `collection_id` int(11) NOT NULL,
  `cashout_date` date NOT NULL,
  `expense_details` varchar(255) NOT NULL,
  `expense_category` varchar(100) NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `cash_out`
--

INSERT INTO `cash_out` (`id`, `collection_id`, `cashout_date`, `expense_details`, `expense_category`, `amount`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-04-18', 'DICT Hackathon Congratulatory Tarp contribution\r\n\r\n', 'Student Development Contributions', 1008.00, 3, NULL, '2025-04-18 17:27:30', '2025-04-18 17:31:56');

-- --------------------------------------------------------

--
-- Table structure for table `collection`
--

CREATE TABLE `collection` (
  `id` int(11) NOT NULL,
  `collection_school_year_id` int(11) NOT NULL,
  `total_cash_in` decimal(10,2) DEFAULT 0.00,
  `total_cash_out` decimal(10,2) DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `collection`
--

INSERT INTO `collection` (`id`, `collection_school_year_id`, `total_cash_in`, `total_cash_out`) VALUES
(1, 1, 0.00, 0.00);

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `contact_id` int(11) NOT NULL,
  `start_day` varchar(10) NOT NULL,
  `end_day` varchar(10) NOT NULL,
  `opening_time` time NOT NULL,
  `closing_time` time NOT NULL,
  `street` varchar(255) NOT NULL,
  `campus` varchar(255) NOT NULL,
  `building` varchar(255) NOT NULL,
  `city` varchar(100) NOT NULL,
  `province` varchar(100) NOT NULL,
  `country` varchar(100) DEFAULT NULL,
  `primary_email` varchar(50) DEFAULT NULL,
  `alternative_email` varchar(50) DEFAULT NULL,
  `primary_number` varchar(20) DEFAULT NULL,
  `secondary_number` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`contact_id`, `start_day`, `end_day`, `opening_time`, `closing_time`, `street`, `campus`, `building`, `city`, `province`, `country`, `primary_email`, `alternative_email`, `primary_number`, `secondary_number`) VALUES
(1, 'Monday', 'Friday', '08:00:00', '16:00:00', 'Wmsu Baliwasan', 'Campus B', 'Computing Department, Floor 2', 'Zamboanga City', 'Zamboanga Del Sur', 'Philippines', 'admissions@computing.edu.ph', 'info@computing.edu.ph', '09651429523', '09817717423');

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
(1, 'Youth Leadership Camp 2025', 'Leadership Training', 'College Students', 'https://www.google.com/url?sa=i&url=https%3A%2F%2Fen.wikipedia.org%2Fwiki%2FChucky_%2528Child%2527s_Play%2529&psig=AOvVaw1d1EfuBPSqcAmuS0h86H9J&ust=1742946534617000&source=images&cd=vfe&opi=89978449&ved=0CBQQjRxqFwoTCJjPrvvzo4wDFQAAAAAdAAAAABAE', 'The Youth Leadership Camp 2025 is a two-day event focused on developing leadership skills among student leaders. Participants will take part in hands-on workshops, talks from experienced mentors, and group activities to build teamwork, communication, and confidence.', 3, '2025-03-06 07:50:35', '2025-04-17 21:54:48', 3, 'event try', 'Campus Multipurpose Hall', '2025-04-26 07:50:35', '2025-04-28 07:50:35');

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `faq_id` int(11) NOT NULL,
  `question` text NOT NULL,
  `answer` text NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `faqs`
--

INSERT INTO `faqs` (`faq_id`, `question`, `answer`, `category`, `created_at`, `created_by`, `updated_at`, `updated_by`) VALUES
(1, 'How can I join Phiccs?', 'Information about joining Phiccs will be available soon. Please check back later for membership details.', NULL, '2025-03-19 02:30:41', 3, '2025-04-17 21:58:30', 3),
(2, 'How can I apply to the Computing Department?', 'To apply to our programs, visit the Admissions section of our website or contact our admissions office directly at admissions@computing.edu.ph. We offer various undergraduate and graduate programs in Computer Science, Information Technology, and related fields.', NULL, '2025-04-09 21:58:13', 3, '2025-04-22 21:58:13', 3),
(4, 'Who can join school organizations?', 'All enrolled students are welcome to join, though some orgs may have specific requirements based on year level, course, or skills.', NULL, '2025-04-14 22:15:57', 3, '2025-04-17 21:57:25', 3),
(5, 'What are the benefits of joining a school organization?', 'Benefits include leadership experience, new friendships, skill development, volunteer opportunities, and enhanced resumes or portfolios.', NULL, '2025-04-15 19:14:41', 3, '2025-04-17 21:58:14', 3),
(9, 'How can I join school program?', 'To apply to our programs, visit the Admissions section of our website or contact our admissions office directly at admissions@computing.edu.ph. We offer various undergraduate and graduate programs in Computer Science, Information Technology, and related fields.', 'General', '2025-04-18 16:27:12', 4, '2025-04-18 16:27:12', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `rating` int(11) NOT NULL CHECK (`rating` between 1 and 5),
  `feedback` text DEFAULT NULL,
  `date_submitted` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `rating`, `feedback`, `date_submitted`) VALUES
(25, 5, 'I found it really helpful that I can read news and announcements about orgs in one place. Very convenient!', '2025-04-17 14:02:02'),
(26, 4, 'The site is user-friendly.', '2025-04-17 14:03:15'),
(27, 2, 'Not really good', '2025-04-17 14:03:27');

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
-- Table structure for table `message`
--

CREATE TABLE `message` (
  `message_id` int(11) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email_address` varchar(150) NOT NULL,
  `phone_number` varchar(20) DEFAULT NULL,
  `message` text NOT NULL,
  `status` enum('Pending','Received','In Progress','Resolved') DEFAULT 'Pending',
  `processed_by` int(11) DEFAULT NULL,
  `date_sent` date NOT NULL,
  `date_resolved` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `message`
--

INSERT INTO `message` (`message_id`, `full_name`, `email_address`, `phone_number`, `message`, `status`, `processed_by`, `date_sent`, `date_resolved`) VALUES
(1, 'Jane Doe', 'janedoe@wmsu.edu.ph', '09123456789', 'I need help with my enrollment.', 'Received', NULL, '2025-04-16', NULL),
(10, 'Angela Ramirez', 'angela.ramirez21@example.com', '0917-456-7890', 'I want to join Phicss Officers', 'Pending', NULL, '2025-04-17', NULL),
(11, 'Mark Dela Cruz', 'mark.dc@example.com', '0998-321-6547', 'My name was not included on the list. Can you please check and update it?', 'In Progress', NULL, '2025-04-17', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE `news` (
  `news_id` int(11) NOT NULL,
  `news_title` varchar(255) NOT NULL,
  `news_description` text DEFAULT NULL,
  `message` text DEFAULT NULL,
  `category` varchar(255) NOT NULL,
  `image` longtext DEFAULT NULL,
  `news_date` date DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` int(11) DEFAULT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `updated_by` int(11) DEFAULT NULL,
  `author` varchar(255) DEFAULT NULL,
  `is_latest` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`news_id`, `news_title`, `news_description`, `message`, `category`, `image`, `news_date`, `created_at`, `created_by`, `updated_at`, `updated_by`, `author`, `is_latest`) VALUES
(9, 'Colors of Culture: School Hosts Multicultural Week Celebration', 'Students showcased different cultures through traditional attire, cuisine, performances, and interactive booths during the Multicultural Week. The highlight of the event was a cultural parade that filled the school grounds with color, rhythm, and joy.\r\n“This week showed us that diversity is our strength,” one student shared. The event ended with unity dances and awards for best presentations.', '', 'Campus Events', 'news_1744881169_6800c611efc9c.png', '2025-03-07', '2025-03-25 07:49:49', 3, '2025-04-17 22:43:48', NULL, 'Rick Grimes', 0),
(13, 'Shining Bright: Students Excel in Regional Science Fair', 'School representatives take home top honors in the annual regional science competition.\r\nOur talented students have once again proven their excellence by securing multiple awards at the Regional Science Fair held last weekend. From environmental innovations to tech-based solutions, their projects impressed judges and participants alike.\r\nTeachers and mentors praised their dedication and teamwork, while the principal expressed pride in the students\' academic passion.', '', 'Academic Achievements', 'news_1744881084_6800c5bc3ce38.png', '2025-04-10', '2025-04-10 17:19:29', 3, '2025-04-17 22:43:11', NULL, 'Rick Grimes', 0),
(14, 'Marching Toward the Future: A Celebration of Success', 'As the class of 2025 takes their final steps across the stage, a new chapter begins. Filled with pride, joy, and reflection, this year’s graduation ceremony honored the hard work, resilience, and achievements of our students. Family, friends, and faculty gathered to celebrate not just academic milestones, but the unforgettable memories and growth that define the journey. Here\'s a glimpse into a day that marked the end of one path—and the exciting start of another', 'To our beloved graduates, your journey has been one of dedication, growth, and unwavering determination. As you march forward into new beginnings, remember that this success is not just the end of a chapter, but the beginning of limitless possibilities. We are incredibly proud of each of you—keep dreaming big, keep reaching higher, and always carry with you the spirit of excellence and compassion that brought you this far. Congratulations, Class of 2025!', 'Graduation', 'news_1744880323_6800c2c399ab5.png', '2025-04-17', '2025-04-17 11:53:19', 4, '2025-04-17 16:59:30', NULL, 'Rick Grimes', 1),
(17, 'From Council to Commencement: Honoring Our Graduates in Leadership', 'The Student Council held its annual End-of-Term Recognition to formally thank and honor its graduating officers. Speeches from peers, tokens of appreciation, and a symbolic turnover ceremony marked the emotional event.\r\n“They are not just leaders—they are mentors, changemakers, and role models,” said the council adviser. The incoming officers vowed to continue their projects and uphold their values.', 'The Student Council sends off its graduating members in a fitting celebration of service and success.', 'School Organization', 'news_1744880960_6800c540d9150.avif', '2025-04-17', '2025-04-17 12:19:14', 4, '2025-04-17 17:09:20', NULL, 'Rick Grimes', 1),
(18, 'Honoring Excellence: Our Graduates Shine Bright', 'This year’s graduation ceremony was a heartfelt celebration of dreams fulfilled and new beginnings, as students step confidently into the world.', 'Each graduate has left a unique mark on our school community. We celebrate your journey and can’t wait to see what you achieve next.', 'Achievements', 'news_1744880717_6800c44dc816c.png', '2025-04-17', '2025-04-17 13:20:04', 4, '2025-04-17 17:05:17', NULL, 'Rick Grimes', 1),
(19, 'Memories in Caps and Gowns', 'A day filled with photos, laughter, hugs, and heartfelt goodbyes—graduation was both a celebration and a farewell to unforgettable moments.', '', 'Achievements', 'news_1744881434_6800c71a577b0.png', '2025-04-17', '2025-04-17 17:17:14', 4, '2025-04-17 17:17:14', NULL, 'Rick Grimes', 1);

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
  `position` varchar(100) DEFAULT NULL,
  `biography` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `school_year`
--

CREATE TABLE `school_year` (
  `school_year_id` int(11) NOT NULL,
  `school_year` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `school_year`
--

INSERT INTO `school_year` (`school_year_id`, `school_year`) VALUES
(1, '2024-2025'),
(2, '2023-2024');

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
(1, 1, 'Annual Transparency Report', 'https://docs.google.com/document/d/1GGAlve-p1dZ09dr2P6WRibXgQLIpWRVBPALAPdx9QsU/edit?tab=t.0#heading=h.v8uvgq9ke1k4', '2025-03-14 07:52:57', '2025-04-18 19:00:38', 3, 3),
(2, 1, 'Financial Disclosure Statements', 'https://docs.google.com/document/d/1GGAlve-p1dZ09dr2P6WRibXgQLIpWRVBPALAPdx9QsU/edit?tab=t.0#heading=h.v8uvgq9ke1k4', '2025-03-06 07:55:02', '2025-04-18 19:00:50', 3, 3),
(3, 1, 'Policy and Ethics Framework', 'https://docs.google.com/document/d/1jOOHiCl8Uh2uTsjNFep_BtTw0M6irnVHsLFFD6h8JOI/edit?tab=t.0#heading=h.nynfo5r8vltv', '2025-04-10 16:53:46', '2025-04-18 19:01:14', 3, 3),
(40, 10, 'BSCS-2A', 'https://docs.google.com/document/d/1GGAlve-p1dZ09dr2P6WRibXgQLIpWRVBPALAPdx9QsU/edit?tab=t.0#heading=h.v8uvgq9ke1k4', '2025-04-13 17:17:48', '2025-04-18 18:57:39', 3, NULL),
(41, 10, 'BSCS-2B', 'https://docs.google.com/document/d/1GGAlve-p1dZ09dr2P6WRibXgQLIpWRVBPALAPdx9QsU/edit?tab=t.0#heading=h.v8uvgq9ke1k4', '2025-04-13 17:18:18', '2025-04-18 18:57:30', 3, NULL),
(45, 10, 'BSCS-2C', 'https://docs.google.com/document/d/1GGAlve-p1dZ09dr2P6WRibXgQLIpWRVBPALAPdx9QsU/edit?tab=t.0#heading=h.v8uvgq9ke1k4', '2025-04-17 22:26:48', '2025-04-18 18:57:49', 3, NULL),
(46, 11, 'Leadership and Officers', 'https://docs.google.com/document/d/1hbb8gjv5PhHKvbr6kFQrQ4f--4QFSsdet1N2Vesquug/edit?tab=t.0#heading=h.rgjxm0ukfz8x', '2025-04-17 22:39:09', '2025-04-18 19:01:36', 3, NULL),
(47, 11, 'Core Purpose and Objectives\r\n\r\n', 'https://docs.google.com/document/d/1jOOHiCl8Uh2uTsjNFep_BtTw0M6irnVHsLFFD6h8JOI/edit?tab=t.0#heading=h.nynfo5r8vltv', '2025-04-17 22:40:16', '2025-04-18 18:55:59', 3, NULL),
(48, 11, 'Mission and Vision', 'https://docs.google.com/document/d/1jOOHiCl8Uh2uTsjNFep_BtTw0M6irnVHsLFFD6h8JOI/edit?tab=t.0#heading=h.nynfo5r8vltv', '2025-04-17 22:41:12', '2025-04-18 18:56:18', 3, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `transparency_section`
--

CREATE TABLE `transparency_section` (
  `id` int(11) NOT NULL,
  `section_title` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp(),
  `created_by` int(11) NOT NULL,
  `updated_by` int(11) DEFAULT NULL,
  `tr_school_year` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transparency_section`
--

INSERT INTO `transparency_section` (`id`, `section_title`, `created_at`, `created_by`, `updated_by`, `tr_school_year`) VALUES
(1, 'Accomplishment Report 1ST SEMESTER 2024-2025 ', '2025-03-14 07:52:03', 3, 3, 1),
(10, '1st Semester Financial Report \r\nPhilippine Computing Students Society \r\nWestern Mindanao State University\r\n', '2025-04-13 17:10:48', 3, NULL, 1),
(11, 'About Our Organization: Officers, Purpose, Mission and Vision', '2025-04-13 17:18:29', 3, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `volunteers`
--

CREATE TABLE `volunteers` (
  `id` int(11) NOT NULL,
  `first_name` varchar(100) NOT NULL,
  `middle_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) NOT NULL,
  `school_email` varchar(150) NOT NULL,
  `course` varchar(100) NOT NULL,
  `year` varchar(100) NOT NULL,
  `interest` varchar(255) NOT NULL,
  `program` varchar(255) NOT NULL,
  `status` enum('approved','pending','declined') DEFAULT 'pending',
  `approved_by` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `volunteers`
--

INSERT INTO `volunteers` (`id`, `first_name`, `middle_name`, `last_name`, `school_email`, `course`, `year`, `interest`, `program`, `status`, `approved_by`) VALUES
(1, 'Nesty', 'Villalon', 'Omongos', 'hz202301549@wmsu.edu.ph', 'Computer Science', '2nd Year', 'art', 'art project', 'pending', NULL),
(14, 'Mark', '', 'Dela Cruz', 'mark.dc@example.com', 'Computer Science', '2nd Year', 'advocacy', 'environmental campaign', 'pending', NULL),
(15, 'Mark', '', 'Dela Cruz', 'mark.dc@example.com', 'Computer Science', '2nd Year', 'advocacy', 'environmental campaign', 'pending', NULL),
(16, 'Nesty', 'Villalon', 'Omongos', 'hz202301549@wmsu.edu.ph', 'Computer Science', '2nd Year', 'art', 'art project', 'pending', NULL),
(17, 'Nesty', 'Villalon', 'Omongos', 'hz202301549@wmsu.edu.ph', 'Computer Science', '2nd Year', 'art', 'art project', 'pending', NULL),
(18, 'Nesty', 'Villalon', 'Omongos', 'hz202301549@wmsu.edu.ph', 'Computer Science', '2nd Year', 'art', 'art project', 'pending', NULL);

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
-- Indexes for table `cash_in`
--
ALTER TABLE `cash_in`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collection_id` (`collection_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `cash_out`
--
ALTER TABLE `cash_out`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collection_id` (`collection_id`),
  ADD KEY `created_by` (`created_by`),
  ADD KEY `updated_by` (`updated_by`);

--
-- Indexes for table `collection`
--
ALTER TABLE `collection`
  ADD PRIMARY KEY (`id`),
  ADD KEY `collection_school_year_id` (`collection_school_year_id`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`contact_id`);

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
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`);

--
-- Indexes for table `gallery`
--
ALTER TABLE `gallery`
  ADD PRIMARY KEY (`gallery_id`),
  ADD KEY `fk_gallery_event` (`event_id`),
  ADD KEY `fk_gallery_project` (`project_id`);

--
-- Indexes for table `message`
--
ALTER TABLE `message`
  ADD PRIMARY KEY (`message_id`),
  ADD KEY `processed_by` (`processed_by`);

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
  ADD KEY `fk_transparency_section_updated_by` (`updated_by`),
  ADD KEY `fk_transparency_school_year` (`tr_school_year`);

--
-- Indexes for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `fk_approved_by` (`approved_by`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `about_phicss`
--
ALTER TABLE `about_phicss`
  MODIFY `info_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `account`
--
ALTER TABLE `account`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `bylaws`
--
ALTER TABLE `bylaws`
  MODIFY `bylaw_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cash_in`
--
ALTER TABLE `cash_in`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `cash_out`
--
ALTER TABLE `cash_out`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `collection`
--
ALTER TABLE `collection`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `contact_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
  MODIFY `faq_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `gallery`
--
ALTER TABLE `gallery`
  MODIFY `gallery_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `message`
--
ALTER TABLE `message`
  MODIFY `message_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `news`
--
ALTER TABLE `news`
  MODIFY `news_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT for table `officers`
--
ALTER TABLE `officers`
  MODIFY `officer_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `school_year`
--
ALTER TABLE `school_year`
  MODIFY `school_year_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `socials`
--
ALTER TABLE `socials`
  MODIFY `social_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transparency_link`
--
ALTER TABLE `transparency_link`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=49;

--
-- AUTO_INCREMENT for table `transparency_section`
--
ALTER TABLE `transparency_section`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `volunteers`
--
ALTER TABLE `volunteers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

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
-- Constraints for table `cash_in`
--
ALTER TABLE `cash_in`
  ADD CONSTRAINT `cash_in_ibfk_1` FOREIGN KEY (`collection_id`) REFERENCES `collection` (`id`),
  ADD CONSTRAINT `cash_in_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `account` (`user_id`),
  ADD CONSTRAINT `cash_in_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `account` (`user_id`);

--
-- Constraints for table `cash_out`
--
ALTER TABLE `cash_out`
  ADD CONSTRAINT `cash_out_ibfk_1` FOREIGN KEY (`collection_id`) REFERENCES `collection` (`id`),
  ADD CONSTRAINT `cash_out_ibfk_2` FOREIGN KEY (`created_by`) REFERENCES `account` (`user_id`),
  ADD CONSTRAINT `cash_out_ibfk_3` FOREIGN KEY (`updated_by`) REFERENCES `account` (`user_id`);

--
-- Constraints for table `collection`
--
ALTER TABLE `collection`
  ADD CONSTRAINT `collection_ibfk_1` FOREIGN KEY (`collection_school_year_id`) REFERENCES `school_year` (`school_year_id`);

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
-- Constraints for table `message`
--
ALTER TABLE `message`
  ADD CONSTRAINT `message_ibfk_1` FOREIGN KEY (`processed_by`) REFERENCES `account` (`user_id`) ON DELETE SET NULL;

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
  ADD CONSTRAINT `fk_transparency_school_year` FOREIGN KEY (`tr_school_year`) REFERENCES `school_year` (`school_year_id`),
  ADD CONSTRAINT `fk_transparency_section_created_by` FOREIGN KEY (`created_by`) REFERENCES `account` (`user_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_transparency_section_updated_by` FOREIGN KEY (`updated_by`) REFERENCES `account` (`user_id`) ON DELETE SET NULL;

--
-- Constraints for table `volunteers`
--
ALTER TABLE `volunteers`
  ADD CONSTRAINT `fk_approved_by` FOREIGN KEY (`approved_by`) REFERENCES `account` (`user_id`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

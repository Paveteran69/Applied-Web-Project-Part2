-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 11, 2026 at 01:22 PM
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
-- Database: `fintech_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `jobs`
--

CREATE TABLE `jobs` (
  `job_name` varchar(30) NOT NULL,
  `reference_number` varchar(5) NOT NULL,
  `job_description` text NOT NULL,
  `starting_salary` varchar(8) NOT NULL,
  `reporting_line` longblob NOT NULL,
  `key_responsibilities` text NOT NULL,
  `essential_requirements` text NOT NULL,
  `preferable_requirements` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `jobs`
--

INSERT INTO `jobs` (`job_name`, `reference_number`, `job_description`, `starting_salary`, `reporting_line`, `key_responsibilities`, `essential_requirements`, `preferable_requirements`) VALUES
('Front-End Developer', 'JN023', 'These developers are used to create and maintain the GUI that the user will use to navigate and interact with the website.', 'AUD 8000', '', '1.Ensuring that the company website GUI can adapt to the needs of the users.\n2.Maintaining the website appearance.\n3.Cooperating with the back-end developers.', '•Must be able to code in CSS, HTML, and/or JavaScript.\n•Must be able to effectively and efficiently communicate with your peers.\n•Must have a CGPA of 3.4 and above.', '•Knows how to speak other languages than english.\n•Has been part of a club that hosts activities that utilise front-end development skills.\n•Has interned in a company that has a website with multiple functions.'),
('Back-End Developer', 'JN024', 'These developers are used to create and maintain the server-side code that helps the website and server connect with each other.', 'AUD 8000', '', 'Ensuring that the company server and website are able to communicate with each other.\n Maintaning the server-side code.\n Cooperating with the front-end developers.', '•Must be able to code in PHP, C#, and/or MySQL.\n•Must be able to effectively and efficiently communicate with your peers.\n•Must have a CGPA of 3.4 and above.', '•Knows how to speak other languages than english.\n•Has been part of a club that hosts activities that utilise back-end development skills.\n•Has interned in a company that has advance server-side coding.'),
('Vulnerability Analyst', 'JN025', 'These analysts are used to analyse security systems to ensure that they secure and are difficult to breach.', 'AUD 9500', '', '1.Ensuring that the company security is secure from threats.\n2.Conducting monthly security audits at the company headquarters.\n3.Writing reports to Cybersecurity and Risk Management about current and future security needs.', '•Must be able to use FortiCNAPP, Nessus and/or InsightVM.\n•Must be able to effectively and efficiently communicate with your peers.\n•Must have a CGPA of 3.4 and above.', '•Knows how to speak other languages than english.\n•Has been part of a club that hosts activities that utilise vulnerability analysis.\n•Has interned in a company that has used vulnerability analysis tools.'),
('Help Desk Technician', 'JN026', 'These technicians are used to give important first-line IT support, troubleshooting, and managing support tickets.', 'AUD 6500', '', '1.Giving users technical support.\n2.Trouble shooting problems.\n3.Managing support tickets.', '•Must be able to use TeamViewer and Jira.\n•Must be able to effectively and efficiently communicate with the users.\n•Must have a CGPA of 3.4 and above.', '•Knows how to speak other languages than english.\n•Has CompTIA A+ certification.\n•Has interned in a company that has given basic customer service experience.');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

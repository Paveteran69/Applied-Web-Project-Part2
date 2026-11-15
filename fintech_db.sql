-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 15, 2026 at 03:25 AM
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
-- Table structure for table `about`
--

CREATE TABLE `about` (
  `Student_ID` int(9) NOT NULL,
  `Name` varchar(50) NOT NULL,
  `Contributions_Field` varchar(100) NOT NULL,
  `Quote` tinytext DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `about`
--

INSERT INTO `about` (`Student_ID`, `Name`, `Contributions_Field`, `Quote`) VALUES
(106218184, 'RYAN STOTHARD', 'about.html, about.css, PHP validate records', '\"I give em an inch, and they take a mile!\"'),
(106728654, 'AKSHAY KUMAR', 'jobs.html, jobs.css, group leader , help create/manage the database including the jobs table', '\"Looking for my next meal\"'),
(106729026, 'NIK MOHAMED AIMAN', 'about.html, about.css, created the contributions table , about.php', '\"Hidup Melayu\"'),
(106729136, 'MUHAMAD DANIAL', 'apply.html, apply.css, created manage.php and manager queries ', '\"Aku suka kura-kura\" ~ (I love turtles, in Malay)'),
(106947909, 'PAVETERAN ELANGOVAN', 'Index.html, index.css, converted navivation and footer into include file while creating settings.php', '\"I wish I could have 5 cats\"');

-- --------------------------------------------------------

--
-- Table structure for table `eoi`
--

CREATE TABLE `eoi` (
  `EOInumber` int(10) UNSIGNED NOT NULL,
  `Ref_ID` varchar(5) NOT NULL,
  `First_Name` varchar(20) NOT NULL,
  `Last_Name` varchar(20) NOT NULL,
  `Date_of_Birth` date NOT NULL,
  `Gender` varchar(10) NOT NULL,
  `Street_Address` varchar(100) NOT NULL,
  `Suburb` varchar(100) NOT NULL,
  `State` varchar(3) NOT NULL,
  `Postcode` char(4) NOT NULL,
  `Email` varchar(255) NOT NULL,
  `Phone_Number` varchar(12) NOT NULL,
  `Desired_Role` varchar(50) NOT NULL,
  `Skills` varchar(255) NOT NULL,
  `Other_Skills` text NOT NULL,
  `Uploaded_File` varchar(255) DEFAULT NULL,
  `Status` enum('New','Current','Final','') NOT NULL DEFAULT 'New',
  `Submitted_At` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `eoi`
--

INSERT INTO `eoi` (`EOInumber`, `Ref_ID`, `First_Name`, `Last_Name`, `Date_of_Birth`, `Gender`, `Street_Address`, `Suburb`, `State`, `Postcode`, `Email`, `Phone_Number`, `Desired_Role`, `Skills`, `Other_Skills`, `Uploaded_File`, `Status`, `Submitted_At`) VALUES
(1, 'JN023', 'John', 'Smith', '2000-05-14', 'Male', '12 King Street', 'Melbourne', 'VIC', '3000', 'john@example.com', '0412345678', 'Software Engineer', 'PHP, HTML, CSS', 'Good communication skills', NULL, 'New', '2026-11-15 02:51:21'),
(2, 'JN023', 'Sarah', 'Johnson', '1999-08-22', 'Female', '25 Queen Street', 'Sydney', 'NSW', '2000', 'sarah@example.com', '0412345679', 'Software Engineer', 'Java, Python, SQL', 'Teamwork and leadership', NULL, 'Current', '2026-11-15 02:51:21'),
(3, 'JN024', 'Michael', 'Brown', '2001-03-10', 'Male', '8 Park Road', 'Brisbane', 'QLD', '4000', 'michael@example.com', '0412345680', 'Web Developer', 'HTML, CSS, JavaScript', 'Responsive web design', NULL, 'New', '2026-11-15 02:51:21'),
(4, 'JN025', 'Emily', 'Davis', '1998-11-05', 'Female', '16 George Street', 'Perth', 'WA', '6000', 'emily@example.com', '0412345681', 'Data Analyst', 'SQL, Excel, Python', 'Data visualisation', NULL, 'Final', '2026-11-15 02:51:21');

--
-- Indexes for dumped tables
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

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`) VALUES
(1, 'admin', '$2y$10$4op/V7MYZyhrZXOUgdzmReAWnf9NTHfz7ZjTA2uQZJGAz2n8fKaa6');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `about`
--
ALTER TABLE `about`
  ADD PRIMARY KEY (`Student_ID`);

--
-- Indexes for table `eoi`
--
ALTER TABLE `eoi`
  ADD PRIMARY KEY (`EOInumber`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `eoi`
--
ALTER TABLE `eoi`
  MODIFY `EOInumber` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

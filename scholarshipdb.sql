-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 29, 2024 at 09:05 AM
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
-- Database: `scholarshipdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `scholarship_requirements`
--

CREATE TABLE `scholarship_requirements` (
  `id` int(11) NOT NULL,
  `requirement_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `scholarship_requirements`
--

INSERT INTO `scholarship_requirements` (`id`, `requirement_name`) VALUES
(1, 'Letter of Intent'),
(2, 'Marriage Certificate(If grantee is the legal spouse)'),
(3, 'Validated Student\'s Enrollment Copy'),
(4, 'Children\'s PSA Birth Certificate'),
(5, 'Authority to Deduct Form'),
(6, 'Original Copy of Certification from the Brgy. Captain as evidence of their relationship'),
(7, 'Original Copy of Certification from the SHS Principal as evidence of being Top 3 with Highest Honor Student in their school'),
(8, 'Rating Card of the two (2) previous semesters'),
(9, 'New applicants only. Rating Card of the previous semesters for continuing grantees'),
(10, 'Endorsement Letter from the Athletic Coordinator'),
(11, 'Rating Card of the previous semester'),
(12, 'Proof of Competition in Provincial, Regional, National Level'),
(13, 'Endorsement Letter from the SIPAG Coordinator and from Publication Adviser with their corresponding Performance Rating'),
(14, 'Barangay Residency '),
(15, 'School I.D with specimen signature'),
(16, 'Valid I.D');

-- --------------------------------------------------------

--
-- Table structure for table `tbladmin`
--

CREATE TABLE `tbladmin` (
  `ID` int(10) NOT NULL,
  `AdminName` varchar(120) DEFAULT NULL,
  `UserName` varchar(120) DEFAULT NULL,
  `MobileNumber` bigint(11) DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Password` varchar(200) DEFAULT NULL,
  `AdminRegdate` timestamp NULL DEFAULT current_timestamp(),
  `Photo` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbladmin`
--

INSERT INTO `tbladmin` (`ID`, `AdminName`, `UserName`, `MobileNumber`, `Email`, `Password`, `AdminRegdate`, `Photo`) VALUES
(1, 'Admin', 'admin', 9546415455, 'admin@gmail.com', '200ceb26807d6bf99fd6f4f0d1ca54d4', '2019-10-11 04:36:52', 'bnsc123.png');

-- --------------------------------------------------------

--
-- Table structure for table `tblapply`
--

CREATE TABLE `tblapply` (
  `ID` int(10) NOT NULL,
  `SchemeId` int(10) DEFAULT NULL,
  `ApplicationNumber` int(10) DEFAULT NULL,
  `UserID` int(10) DEFAULT NULL,
  `ApplyDate` timestamp NULL DEFAULT current_timestamp(),
  `Status` varchar(250) DEFAULT NULL,
  `Remark` mediumtext DEFAULT NULL,
  `UpdationDate` timestamp NULL DEFAULT current_timestamp(),
  `DocReq` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `DisbursedAmount` decimal(10,0) DEFAULT NULL,
  `SanctionedDate` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblapply`
--

INSERT INTO `tblapply` (`ID`, `SchemeId`, `ApplicationNumber`, `UserID`, `ApplyDate`, `Status`, `Remark`, `UpdationDate`, `DocReq`, `DisbursedAmount`, `SanctionedDate`) VALUES
(85, 25, 853501737, 55, '2024-10-28 08:19:51', 'Approved', 'FDDASDAsas', '2024-10-28 08:19:51', '35690c01d92834217fe91a0031de572d1730103591.docx', NULL, '2024-11-01 15:04:49'),
(86, 30, 807998906, 55, '2024-10-30 06:43:45', 'Pending', 'asdasdasdasd', '2024-10-30 06:43:45', '8811961114e4329730c1d94f2418c2fb1730270625.docx', NULL, '2024-11-01 14:36:34'),
(87, 29, 653626279, 55, '2024-10-30 07:12:07', NULL, NULL, '2024-10-30 07:12:07', '8811961114e4329730c1d94f2418c2fb1730272327.docx', NULL, NULL),
(88, 25, 205834714, 58, '2024-11-29 04:16:21', NULL, NULL, '2024-11-29 04:16:21', '3c319eda3e81fa9f0c07f48beb79abda1732853781.docx', NULL, NULL),
(89, 59, 539788067, 61, '2024-11-29 05:52:59', NULL, NULL, '2024-11-29 05:52:59', '8f1aca14864219d0a615d0309afc99c01732859579.docx', NULL, NULL),
(90, 25, 783775841, 61, '2024-11-29 06:03:48', NULL, NULL, '2024-11-29 06:03:48', 'f1be3a8ebc704c89a518a90091ddf7e01732860228.docx', NULL, NULL),
(91, 58, 566866975, 61, '2024-11-29 06:04:02', NULL, NULL, '2024-11-29 06:04:02', '8f1aca14864219d0a615d0309afc99c01732860242.docx', NULL, NULL),
(92, 60, 963659781, 61, '2024-11-29 06:14:43', 'Approved', 'uyghv', '2024-11-29 06:14:43', 'c9cf287310d4b37ddf36e683890c91331732860883.docx', NULL, '2024-11-29 06:16:11'),
(93, 25, 177326718, 62, '2024-11-29 06:20:55', 'Approved', 'dsfsdf', '2024-11-29 06:20:55', '8f1aca14864219d0a615d0309afc99c01732861255.docx', NULL, '2024-11-29 06:22:16'),
(94, 25, 363975685, 64, '2024-11-29 07:26:27', NULL, NULL, '2024-11-29 07:26:27', 'f1be3a8ebc704c89a518a90091ddf7e01732865187.docx', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblpage`
--

CREATE TABLE `tblpage` (
  `ID` int(10) NOT NULL,
  `PageType` varchar(200) DEFAULT NULL,
  `PageTitle` mediumtext DEFAULT NULL,
  `PageDescription` mediumtext DEFAULT NULL,
  `Email` varchar(200) DEFAULT NULL,
  `Address` mediumtext NOT NULL,
  `website_links` varchar(200) NOT NULL,
  `MobileNumber` bigint(18) DEFAULT NULL,
  `UpdationDate` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblpage`
--

INSERT INTO `tblpage` (`ID`, `PageType`, `PageTitle`, `PageDescription`, `Email`, `Address`, `website_links`, `MobileNumber`, `UpdationDate`) VALUES
(2, 'contactus', 'Contact Us', 'Office Hours: Monday ~ Friday - 8:00 AM ~ 5:00 PM\r\n          NO NOON BREAK\r\n          Saturday ~ Sunday: Closed', 'info@bnsc.edu.ph', 'Isaac Garces St. 6315 Ubay, Bohol, Philippines', 'www.scholarship.edu.php', 9505647101, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `tblscheme`
--

CREATE TABLE `tblscheme` (
  `ID` int(5) NOT NULL,
  `SchemeName` varchar(250) DEFAULT NULL,
  `Yearofscholarship` varchar(250) DEFAULT NULL,
  `LastDate` date DEFAULT NULL,
  `Scholarfee` mediumtext DEFAULT NULL,
  `PublishedDate` timestamp NULL DEFAULT current_timestamp(),
  `Image` varchar(255) DEFAULT NULL,
  `Requirements` varchar(255) DEFAULT NULL,
  `department` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tblscheme`
--

INSERT INTO `tblscheme` (`ID`, `SchemeName`, `Yearofscholarship`, `LastDate`, `Scholarfee`, `PublishedDate`, `Image`, `Requirements`, `department`) VALUES
(25, 'Employee, Legal Spouse, Children, and Dependents', '2024-2025', '2026-01-31', '(50% Tuition Fee Discount)', '2024-10-24 05:13:15', 'uploads/mlogo.png', 'Letter of Intent, Marriage Certificate(If grantee is the legal spouse), Validated Student\'s Enrollment Copy, Children\'s PSA Birth Certificate, Authority to Deduct Form', ''),
(28, 'Employee Siblings, Relatives, and Working Students', '2024-2025', '2026-01-31', '(25% Tuition Fee Discount)', '2024-10-24 06:01:02', 'uploads/mlogo.png', 'Letter of Intent, Validated Student\'s Enrollment Copy, Authority to Deduct Form, Original Copy of Certification from the Brgy. Captain as evidence of their relationship', ''),
(29, 'Top 3 with Highest Honor Students', '2024-2025', '2026-01-31', ' (Top 1-100% tuition fee discount; Top 2 -75% tuition fee discount; Top 3- 50% tuition fee discount)', '2024-10-24 06:03:17', 'uploads/mlogo.png', 'Letter of Intent, Validated Student\'s Enrollment Copy, Original Copy of Certification from the SHS Principal as evidence of being Top 3 with Highest Honor Student in their school', ''),
(30, 'Dean\'s Lister', '2026-01-31', '2026-01-31', ' (100% tuition fee discount with an average of 1.0-1.2 with no rating below 1.3 for one semester availment)\r\n( 75% tuition fee discount with an average of 1.3-1.4 with no rating below 1.5 for one semester availment)  \r\n(50% tuition fee discount with an average of 1.5 with no rating below 2.0 for one semester availment)', '2024-10-24 06:05:16', 'uploads/mlogo.png', 'Letter of Intent, Validated Student\'s Enrollment Copy, Rating Card of the two (2) previous semesters, New applicants only. Rating Card of the previous semesters for continuing grantees, Rating Card of the previous semester', ''),
(31, 'NON-ACADEMIC SCHOLARSHIP', '2026-01-31', '2026-01-31', 'Provincial Athlete (10% Tuition Fee Discount)\r\nRegional Athlete (20% Tuition Fee Discount) \r\nNational Athlete (30% Tuition Fee Discount)', '2024-10-24 06:08:24', 'uploads/mlogo.png', 'Letter of Intent, Validated Student\'s Enrollment Copy, Endorsement Letter from the Athletic Coordinator, Rating Card of the previous semester, Proof of Competition in Provincial, Regional, National Level', ''),
(32, 'Sidlak Performing Arts Group and Publication Staff', '2026-01-31', '2026-01-31', '(10% Tuition Fee Discount)', '2024-10-24 06:10:19', 'uploads/mlogo.png', 'Letter of Intent, Validated Student\'s Enrollment Copy, Rating Card of the previous semester, Endorsement Letter from the SIPAG Coordinator and from Publication Adviser with their corresponding Performance Rating', ''),
(48, 'Tertriay Education Subsidy(TES)', '2024-2025', '2025-05-01', 'Php10,000.00 per sem', '2024-11-01 03:00:19', 'uploads/tes.jpg', 'Barangay Residency , School I.D with specimen signature, Valid I.D', ''),
(49, 'Tulong Dunong Program (TDP)', '2024-2025', '2025-02-01', 'PhP 7,500.00', '2024-11-01 03:02:46', 'uploads/tes.jpg', 'Barangay Residency , School I.D with specimen signature, Valid I.D', '');

-- --------------------------------------------------------

--
-- Table structure for table `tbluser`
--

CREATE TABLE `tbluser` (
  `ID` int(10) NOT NULL,
  `SchoolID` varchar(11) DEFAULT NULL,
  `FirstName` varchar(255) NOT NULL,
  `MiddleName` varchar(255) NOT NULL,
  `LastName` varchar(255) NOT NULL,
  `SuffixName` varchar(10) NOT NULL,
  `MobileNumber` bigint(20) DEFAULT NULL,
  `Course` varchar(255) DEFAULT NULL,
  `Citizenship` varchar(100) NOT NULL,
  `CivilStatus` varchar(100) NOT NULL,
  `YearLevel` varchar(100) NOT NULL,
  `DateofBirth` date DEFAULT NULL,
  `Gender` varchar(50) DEFAULT NULL,
  `Address` mediumtext DEFAULT NULL,
  `ZipCode` varchar(10) DEFAULT NULL,
  `Email` varchar(250) DEFAULT NULL,
  `Password` varchar(250) DEFAULT NULL,
  `RegDate` timestamp NULL DEFAULT current_timestamp(),
  `Photo` varchar(255) DEFAULT NULL,
  `department` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data for table `tbluser`
--

INSERT INTO `tbluser` (`ID`, `SchoolID`, `FirstName`, `MiddleName`, `LastName`, `SuffixName`, `MobileNumber`, `Course`, `Citizenship`, `CivilStatus`, `YearLevel`, `DateofBirth`, `Gender`, `Address`, `ZipCode`, `Email`, `Password`, `RegDate`, `Photo`, `department`) VALUES
(55, '20182017', 'Liam', 'Omigan', 'Lingo', '', 9546415455, 'BSCS', 'filipino', 'Single', '1st Year', '2018-05-01', 'Male', 'bibas', '6315', 'liam@gmail.com', '$2y$10$XyofzTwa2K2xgGcUw8HTPexVNyo.Q5cPApE/8fl1uvyQwkqjapIw.', '2024-10-26 14:32:01', 'WIN_20240721_10_15_19_Pro.jpg', ''),
(56, '201801729', 'Dhejay', 'Gwapo', 'Domaun', '', 9505647101, 'BSIT', 'Filipino', 'Married', '4th Year', '1913-01-05', 'Male', 'Poblacion', '6315', 'domaun@gmail.com', '$2y$10$mLqiUOdDTov3lYsqEix8BuDmjtt37QXO8CCsdyT9/Yko9uSynJA06', '2024-10-28 08:27:17', 'images.jpeg', ''),
(58, '20192014', 'ella', 'omigan', 'lingo', '', 9505647101, 'BSCS', 'filipino', 'Single', '3rd Year', '2003-01-29', 'Male', 'bibas', '6315', 'ella21@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2024-11-06 16:06:20', 'stu5.jpg', ''),
(62, '2018201999', 'jovy', 'ad', 'sdf', '', 9055486951, 'BSIT', 'Filipino', 'Single', '1st Year', '2029-01-01', 'Female', 'Fatima, Ubay, Bohol', '6315', 'sdidwio@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2024-11-29 06:20:30', 'constant.jpg', 'College'),
(63, '201820199', 'Dianne Kathlyn', 'Boyles', 'Corrales', '', 9055486951, 'BSIT', 'Filipino', 'Single', '2nd Year', '2000-01-20', 'Female', 'Fatima, Ubay, Bohol', '6315', 'dayankathlyncorales@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2024-11-29 06:44:05', 'dklove.jpg', 'Basic Ed'),
(64, '20172018', 'wilmayz', 's', 'sdff', '', 9505647101, 'BSIT', 'Filipino', 'Single', '2nd Year', '2000-01-20', 'Female', 'Fatima, Ubay, Bohol', '6315', 'alvin100golosino@gmail.com', 'e10adc3949ba59abbe56e057f20f883e', '2024-11-29 06:53:38', 'lovie.jpg', 'College');

-- --------------------------------------------------------

--
-- Table structure for table `user_queries`
--

CREATE TABLE `user_queries` (
  `sr_no` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `email` varchar(150) NOT NULL,
  `mobilenumber` bigint(20) NOT NULL,
  `message` varchar(500) NOT NULL,
  `date` date NOT NULL DEFAULT current_timestamp(),
  `time` time NOT NULL DEFAULT current_timestamp(),
  `seen` tinyint(4) NOT NULL DEFAULT 0,
  `is_archived` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `user_queries`
--

INSERT INTO `user_queries` (`sr_no`, `name`, `email`, `mobilenumber`, `message`, `date`, `time`, `seen`, `is_archived`) VALUES
(96, 'wilmay', 'wilmay@gmail.com', 9505647101, 'asdasdsa', '2024-10-25', '09:59:27', 1, 1),
(97, 'asdasd', 'asd@gmail.com', 95656565656, 'sdfsfdsfdsfsd', '2024-10-28', '16:15:42', 1, 0),
(98, 'wfsdfds', 'sdfs@gmail.com', 945345645, 'sdfsdfsdfsdf\r\n', '2024-10-30', '09:35:51', 0, 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `scholarship_requirements`
--
ALTER TABLE `scholarship_requirements`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tbladmin`
--
ALTER TABLE `tbladmin`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblapply`
--
ALTER TABLE `tblapply`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblpage`
--
ALTER TABLE `tblpage`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tblscheme`
--
ALTER TABLE `tblscheme`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `tbluser`
--
ALTER TABLE `tbluser`
  ADD PRIMARY KEY (`ID`);

--
-- Indexes for table `user_queries`
--
ALTER TABLE `user_queries`
  ADD PRIMARY KEY (`sr_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `scholarship_requirements`
--
ALTER TABLE `scholarship_requirements`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `tbladmin`
--
ALTER TABLE `tbladmin`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblapply`
--
ALTER TABLE `tblapply`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=95;

--
-- AUTO_INCREMENT for table `tblpage`
--
ALTER TABLE `tblpage`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tblscheme`
--
ALTER TABLE `tblscheme`
  MODIFY `ID` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT for table `tbluser`
--
ALTER TABLE `tbluser`
  MODIFY `ID` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=65;

--
-- AUTO_INCREMENT for table `user_queries`
--
ALTER TABLE `user_queries`
  MODIFY `sr_no` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

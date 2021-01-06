-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 06, 2021 at 02:46 PM
-- Server version: 10.4.13-MariaDB
-- PHP Version: 7.4.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `uclone`
--

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cart_id` int(11) NOT NULL,
  `cart_crs_token` varchar(255) COLLATE utf8_bin NOT NULL,
  `uemail` varchar(255) COLLATE utf8_bin NOT NULL,
  `crs_creator` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `cat_id` int(11) NOT NULL,
  `cat_name` varchar(255) COLLATE utf8_bin NOT NULL,
  `cat_img` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`cat_id`, `cat_name`, `cat_img`) VALUES
(1, 'Photography', 'photography.jpg'),
(2, 'Business', 'bussiness.jpg'),
(3, 'Design', 'design.jpg'),
(4, 'Marketing', 'marketing.jpg'),
(5, 'Programming', 'programming.jpg'),
(6, 'Software', 'software.jpg'),
(7, 'UX Design', 'ux.jpg'),
(8, 'Web Development', 'web_development.jpeg');

-- --------------------------------------------------------

--
-- Table structure for table `coupons`
--

CREATE TABLE `coupons` (
  `cpn_id` int(11) NOT NULL,
  `coupon` varchar(255) COLLATE utf8_bin NOT NULL,
  `off` int(11) NOT NULL,
  `exp_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `coupons`
--

INSERT INTO `coupons` (`cpn_id`, `coupon`, `off`, `exp_date`) VALUES
(1, 'MK10', 10, '2021-01-22'),
(2, 'NEWYEAR2021', 20, '2021-01-31');

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

CREATE TABLE `courses` (
  `id` int(255) NOT NULL,
  `crs_creator` varchar(255) COLLATE utf8_bin NOT NULL,
  `crs_nm` varchar(255) COLLATE utf8_bin NOT NULL,
  `crs_tag_ln` varchar(255) COLLATE utf8_bin NOT NULL,
  `crs_lng` varchar(20) COLLATE utf8_bin NOT NULL,
  `crs_cc` varchar(255) COLLATE utf8_bin NOT NULL,
  `stu_lrn` text COLLATE utf8_bin NOT NULL,
  `crs_req` text COLLATE utf8_bin NOT NULL,
  `crs_desc` text COLLATE utf8_bin NOT NULL,
  `crs_dur` varchar(255) COLLATE utf8_bin NOT NULL,
  `crs_art` int(255) NOT NULL,
  `crs_res` int(255) NOT NULL,
  `crs_price` double NOT NULL,
  `crs_org_prc` double NOT NULL,
  `crs_img` varchar(255) COLLATE utf8_bin NOT NULL,
  `crs_token` varchar(255) COLLATE utf8_bin NOT NULL,
  `lst_upt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `crs_cat` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `courses`
--

INSERT INTO `courses` (`id`, `crs_creator`, `crs_nm`, `crs_tag_ln`, `crs_lng`, `crs_cc`, `stu_lrn`, `crs_req`, `crs_desc`, `crs_dur`, `crs_art`, `crs_res`, `crs_price`, `crs_org_prc`, `crs_img`, `crs_token`, `lst_upt`, `crs_cat`) VALUES
(1, 'koushil.webdeveloper@gmail.com', 'PHP', 'Learn PHP Basic to Advanced', 'english', '', 'Basic PHP.\r\nAdvance PHP.\r\nProjects in PHP                                                        ', 'Basic HTML.\r\nBasic CSS.\r\nBasic JavaScript                                                        ', 'PHP is a language written for the Web, quick to learn, easy to deploy and provides substantial functionality required for e-commerce. This course introduces the PHP framework and syntax and covers in depth the most important techniques used to build dynamic Web sites.', '03:57:53', 5, 2, 999, 4000, '5fdedc2930daephp.png', '98ca6c20a2', '2020-12-24 13:35:56', 'Web Development'),
(2, 'koushil.webdeveloper@gmail.com', 'React JS', 'Learn React JS From Basic to Advanced', 'telugu', '', 'Basic React JS Features.\r\nAdvanced React JS.\r\nProject on React JS                            ', 'Basic HTML.\r\nGood Knowledge on CSS.\r\nGood Knowledge on JavaScript                   ', 'React JS is a booming technology in the field of web development it is developed by Facebook and it is based on JavaScript which is used for Frontend development and it has huge features and its a good choice to learn.', '', 50, 8, 1299, 4999, '5fe4164102a46software_design.jpg', 'e7333d079a', '2020-12-24 04:17:05', 'Web Development'),
(3, 'koushil.webdeveloper@gmail.com', 'Laravel Course', 'Learn Laravel From Basic to Advanced', 'hindi', '', 'Basic Concepts of Framework.\r\nBasic to Advanced Concepts of Laravel.\r\nProject in Laravel                         ', 'Basic HTML.\r\nBasic CSS.\r\nGood Knowledge on PHP\r\n                            ', 'Learn PHP most famous and most in demand framework LARAVEL with amazing projects for better understanding of concepts.', '', 26, 17, 679, 987, '5fe41705593e4laravel.jpg', '0bab4d059b', '2020-12-24 04:20:21', 'Web Development'),
(4, 'koushil.webdeveloper@gmail.com', 'Cloud Computing', 'Learn Cloud Computing Basic to Advanced', 'russian', '', 'Introduction to Cloud Computing.\r\nBasic Architectures of CC.\r\nGood Knowledge on CC                         ', 'NO Requirements', 'Learn Cloud Computing', '', 21, 15, 699, 2399, '5fe41856a587ccloud_computing.png', 'd03d0c8239', '2020-12-24 04:25:58', 'Software'),
(5, 'koushil.webdeveloper@gmail.com', 'jQuery Library', 'jQuery from Basics to Advanced', 'tamil', '', 'Basic Understanding of jQuery and library introduction.\r\nBasic to Advanced Concepts of jQuery                           ', 'Basic HTML and CSS.\r\nIntermediate knowledge on JavaScript', 'jQuery...', '', 18, 4, 1799, 3899, '5fe4197a7db15jquery.png', '1443815e61', '2020-12-24 04:30:50', 'Web Development'),
(6, 'nani@gmail.com', 'Node JS', 'Node JS Complete Course', 'french', '', 'Basic JavaScript Concepts.\r\nNode JS Complete A to Z                     ', 'Basic HTML and CSS', 'Node JS', '', 32, 7, 899, 1698, '5fe41b8d8329bnode-js.png', 'e2e23a2b11', '2020-12-24 04:39:41', 'Web Development'),
(7, 'nani@gmail.com', 'Django Course', 'Django Complete Course', 'english', '', 'Basic Python.\r\nComplete Django Concepts.\r\nWebsite Project in Django                          ', 'Basic understanding on Python\r\n                            ', 'Django...', '', 12, 6, 6999, 11250, '5fe41c0bdb4dfdjango.png', 'f47a4056eb', '2020-12-24 04:41:47', 'Web Development'),
(8, 'nani@gmail.com', 'Python 3', 'Learn Python Basic to Advanced', 'telugu', '', 'Python 3 Concepts.\r\nAble to Learn new concepts one self                 ', 'NO Requirements\r\n                            ', 'Python 3 ...', '', 8, 12, 3299, 4000, '5fe41c937829dpython.jpg', '87cc745605', '2020-12-24 04:44:03', 'Programming'),
(9, 'nani@gmail.com', 'JavaScript Course', 'JavaScript From Basic', 'hindi', '', 'Basic to Advanced JavaScript.\r\nProject on JavaScript             ', 'NO Requirements\r\n                            ', 'JavaScript ...', '', 12, 16, 2800, 4300, '5fe41d4fc67efjavascript.jpg', '820292645e', '2020-12-24 04:47:11', 'Programming'),
(10, 'nani@gmail.com', 'Photoshop', 'Advanced Photoshop', 'hindi', '', 'Complete Photoshop Course                         ', 'Basic Computer Knowledge\r\n                            ', 'Photoshop', '', 7, 5, 599, 999, '5fe41df9e60daphotoshop.jpg', '8e14dc8fb8', '2020-12-24 04:50:01', 'Design'),
(11, 'nani@gmail.com', 'Typescript', 'Learn Typescript Basic to Advanced', 'telugu', '', 'Basic to Advanced TypeScript\r\n                            ', 'Basic Understanding of JavaScript                          ', 'Typescript ...', '', 3, 7, 2999, 5599, '5fe41f3304f12typescript.jpeg', 'f86fd7c398', '2020-12-24 04:55:15', 'Programming'),
(12, 'nani@gmail.com', 'UI/UX Design', 'UI / UX From Basic to Advanced', 'french', '', 'Learn UI/UX in depth and about most UI/UX Softwares\r\n                            ', 'Basic Understanding of UI/UX                          ', 'UI/UX ...', '', 7, 34, 1899, 3599, '5fe4201231380uiux.png', '00aab0c1c8', '2020-12-24 04:58:58', 'UX Design'),
(13, 'koushil.webdeveloper@gmail.com', 'Bootstrap 5', 'Learn Bootstrap 5 from Basics', 'tamil', '', 'Basic HTML and CSS.\r\nBootstrap 5  ', 'NO Requirements\r\n                            ', 'Bootstrap 5 ...', '', 4, 6, 2599, 3899, '5fe420b6b4d7fbootstarp.jpg', '62326ca8c0', '2020-12-24 05:01:42', 'Web Development'),
(14, 'koushil.webdeveloper@gmail.com', 'Marketing Course', 'Basic to Advanced Marketing', 'malyalam', '', 'Become Marketing Expert', 'NO Requirements\r\n                            ', 'Marketing ....', '', 2, 0, 999, 1599, '5fe422880c6cdmarketing1.png', '10a5f898ee', '2020-12-24 05:09:28', 'Marketing'),
(15, 'koushil.webdeveloper@gmail.com', 'Marketing Course', 'Basic to Advanced Marketing', 'english', '', 'Become Marketing Expert\r\n                                                        ', 'NO Requirements\r\n                                                        ', 'Marketing ....', '', 12, 4, 1899, 2999, '5fe424625b30cmarketing4.jpg', '4f86ea30c4', '2020-12-24 05:17:22', 'Marketing'),
(16, 'koushil.webdeveloper@gmail.com', 'Marketing Course', 'Basic to Advanced Marketing', 'telugu', '', 'Become Marketing Expert                          ', 'NO Requirements\r\n                            ', 'Marketing ....', '', 8, 0, 1799, 2200, '5fe423bc9d395marketing2.jpg', '84842b3c1c', '2020-12-24 05:14:36', 'Marketing'),
(17, 'koushil.webdeveloper@gmail.com', 'Learn Marketing', 'Basic to Advanced Marketing', 'tamil', '', 'Become Marketing Expert\r\n                            ', 'NO Requirements\r\n                            ', 'Marketing ....', '', 0, 0, 699, 1199, '5fe424a2e1295marketing7.png', '10f0a00eac', '2020-12-24 05:18:26', 'Marketing'),
(18, 'koushil.webdeveloper@gmail.com', 'Marketing Expert', 'Basic to Advanced Marketing', 'french', '', 'Become Marketing Expert\r\n                            ', 'NO Requirements\r\n                            ', 'Marketing ....', '', 9, 4, 1499, 2999, '5fe425083ddc6marketing5.png', 'bbf46c6c31', '2020-12-24 05:20:08', 'Marketing'),
(19, 'koushil.webdeveloper@gmail.com', 'Marketing Course', 'Basic to Advanced Marketing', 'russian', '', 'Become Marketing Expert\r\n                            ', 'NO Requirements\r\n                            ', 'Marketing ....', '', 2, 8, 599, 1299, '5fe425306438amarketing.jpg', 'd18e337bd7', '2020-12-24 05:20:48', 'Marketing'),
(20, 'koushil.webdeveloper@gmail.com', 'Marketing Course', 'Learn Marketing', 'chinese', '', 'Learn Marketing From Basics\r\n                            ', 'NO Requirements\r\n                            ', 'Marketing ...', '', 5, 3, 1399, 3299, '5fe425ab11999marketing6.jpg', '7b5bafcc07', '2020-12-24 05:22:51', 'Marketing'),
(21, 'nani@gmail.com', 'Business Concepts', 'Learn Business Concepts Basic to Advanced', 'english', '', 'Business Tips.\r\nBusiness Concepts                         ', 'NO Requirements\r\n                            ', 'Business ...', '', 7, 2, 1699, 5400, '5fe4296d38402bussiness.jpg', 'aca92cd1c2', '2020-12-24 05:38:53', 'Business'),
(22, 'nani@gmail.com', 'Business Concepts', 'Learn Business Concepts Basic to Advanced', 'telugu', '', 'Business Tips.\r\nBusiness Concepts                            ', 'NO Requirements\r\n                            ', 'Business ...', '', 8, 5, 7999, 12999, '5fe42979c1245bussiness1.jpg', 'd5f8afde6c', '2020-12-24 05:39:05', 'Business'),
(23, 'nani@gmail.com', 'Business Concepts', 'Learn Business Concepts Basic to Advanced', 'tamil', '', 'Business Tips.\r\nBusiness Concepts                           ', 'NO Requirements\r\n                            ', 'Business ...', '', 0, 0, 1899, 4999, '5fe42994e7106bussiness2.jpg', 'f5044dd271', '2020-12-24 05:39:32', 'Business'),
(24, 'nani@gmail.com', 'Business Concepts', 'Learn Business Concepts Basic to Advanced', 'malyalam', '', 'Business Tips.\r\nBusiness Concepts                            ', 'NO Requirements\r\n                            ', 'Business ...', '', 5, 5, 2999, 5999, '5fe429a3b5f84bussiness3.jpg', 'd129e2df57', '2020-12-24 05:39:47', 'Business'),
(25, 'nani@gmail.com', 'Business Concepts', 'Learn Business Concepts Basic to Advanced', 'french', '', 'Business Tips.\r\nBusiness Concepts                            ', 'NO Requirements\r\n                            ', 'Business ...', '', 8, 1, 999, 2399, '5fe429e59ff87bussiness4.jpg', '0820fa38ca', '2020-12-24 05:40:53', 'Business'),
(26, 'nani@gmail.com', 'App Design', 'App UI Design', 'english', '', 'Learn APP UI Design                            ', 'Basic Knowledge on Design                            ', 'App Design', '', 6, 2, 1677, 2389, '5fe42a368054eapp_design.png', '5372c0832d', '2020-12-24 05:42:14', 'Design'),
(27, 'nani@gmail.com', 'APP Development', 'Learn App Development from Basic to Advanced', 'telugu', '', 'Android and IOS Difference.\r\nLanguages used for APP Development.\r\nAPP Development                       ', 'Basic understanding of APP Development         ', 'APP Development ...', '', 7, 4, 1799, 3499, '5fe42b20592e9app_development.jpg', '9d5be1fa53', '2020-12-24 05:46:08', 'Programming'),
(28, 'nani@gmail.com', 'Blogging', 'Learn Blogging and Learn to Earn Money', 'telugu', '', 'Learn Basics of Blogging.\r\nDifference between blogger and wordpress.\r\nSetup Blog.\r\nBasic SEO', 'NO Requirements\r\n                            ', 'Blogging ...', '', 45, 12, 3499, 5999, '5fe42bfc90dedblogging.jpg', '59584d63a4', '2020-12-24 05:49:48', 'Web Development'),
(29, 'nani@gmail.com', 'Handle Camera', 'Camera Handling and Details about Camera', 'english', '', 'Learn how to handle camera.\r\nBasics of Camera.\r\nBasic Photography                        ', 'No Requirements\r\n                            ', 'Camera ...', '', 2, 8, 999, 1499, '5fe42cdf63e9dcamera.jpg', '9074246708', '2020-12-24 05:53:35', 'Photography'),
(30, 'nani@gmail.com', 'Handle Camera', 'Camera Handling and Details about Camera', 'telugu', '', 'Learn how to handle camera.\r\nBasics of Camera.\r\nBasic Photography                             ', 'No Requirements\r\n                            ', 'Camera ...', '', 8, 8, 999, 1499, '5fe42ce7bc887camera_shoot.jpg', '118dbbbe82', '2020-12-24 05:53:43', 'Photography'),
(31, 'nani@gmail.com', 'Web Design', 'Learn Web Layout Design', 'english', '', 'Learn to Design web layouts.\r\nBest Applications to use                            ', 'Basic understanding of web design', 'Web Design ...', '', 5, 4, 1689, 2999, '5fe42d517a74adesign.jpg', 'f23ef3f0d7', '2020-12-24 05:55:29', 'Design'),
(32, 'nani@gmail.com', 'HTML', 'Learn HTML Basic to Advanced', 'telugu', '', 'Basic to Advanced HTML.\r\nIntroduction to CSS                            ', 'Basic Knowledge of Web\r\n                            ', 'HTML ...', '', 3, 6, 399, 600, '5fe42db23697dhtml.gif', '267fbec688', '2020-12-24 05:57:06', 'Web Development'),
(33, 'nani@gmail.com', 'HTML', 'Learn HTML Basic to Advanced', 'english', '', 'Basic to Advanced HTML.\r\nIntroduction to CSS                           ', 'Basic Knowledge of Web\r\n                            ', 'HTML ...', '', 7, 6, 399, 700, '5fe42dc631c01html1.gif', '33d55247df', '2020-12-24 05:57:26', 'Web Development'),
(34, 'nani@gmail.com', 'JavaScript', 'JavaScript From Basic', 'english', '', 'Basic to Advanced JavaScript.\r\nProject on JavaScript                           ', 'NO Requirements', 'JavaScript ...', '', 8, 4, 3599, 5999, '5fe42e3c4ecbdjavascript3.jpg', '8270bcbb90', '2020-12-24 05:59:24', 'Programming'),
(35, 'nani@gmail.com', 'Lens', 'Learn All About Lens', 'english', '', 'Learn All About Lens\r\n                            ', 'No Requirements\r\n                            ', 'Lens ...', '', 7, 3, 799, 1100, '5fe42e8b50e95lens.jpg', '99c924cf78', '2020-12-24 06:00:43', 'Photography'),
(36, 'koushil.webdeveloper@gmail.com', 'Codeignator', 'Learn Codeignator PHP Basic to Advanced', 'telugu', '', 'Basic Understandings of Framework working Methodology.\r\nBasic to Advanced Concepts in Codeignator ', 'Good Knowledge of PHP\r\n                            ', 'Codeignator ...', '', 3, 5, 1299, 4588, '5fe42fa7b38f9codeignator.png', 'a1bf14d0d2', '2020-12-24 06:05:27', 'Web Development'),
(37, 'koushil.webdeveloper@gmail.com', 'Cake PHP', 'Learn Cake PHP Basic to Advanced', 'telugu', '', 'Basic Understandings of Framework working Methodology.\r\nBasic to Advanced Concepts in Cake PHP', 'Good Knowledge of PHP\r\n                            ', 'Cake PHP ...', '', 6, 5, 899, 1399, '5fe42fac7e2cecake_php.png', '9d4063ef85', '2020-12-24 06:05:32', 'Web Development'),
(38, 'koushil.webdeveloper@gmail.com', 'Programming', 'Basics of Programming', 'english', '', 'Programming Introduction.\r\nLogic Building in Programming                         ', 'No Requirements                         ', 'Programming ...', '', 7, 4, 499, 799, '5fe4309cab361programming.jpg', 'b9bbe823b4', '2020-12-24 06:09:32', 'Programming'),
(39, 'koushil.webdeveloper@gmail.com', 'Node JS', 'Node JS Complete Course', 'english', '', 'Basic JavaScript Concepts.\r\nNode JS Complete A to Z                          ', 'Basic HTML and CSS\r\n                            ', 'Node JS...', '', 7, 3, 2399, 5788, '5fe430ebc4023node_js.jpg', '6b1b38ec3b', '2020-12-24 06:10:51', 'Web Development'),
(40, 'koushil.webdeveloper@gmail.com', 'Photography in Hindi', 'Learn Photography Basic to Advanced', 'hindi', '', 'Basics of Photography                             ', 'NO Requirements', 'Photography ...', '', 48, 8, 6000, 7899, '5fe431837adc0photography.jpg', '96382852f5', '2020-12-24 06:13:23', 'Photography'),
(41, 'koushil.webdeveloper@gmail.com', 'Photography in Telugu', 'Learn Photography Basic to Advanced', 'telugu', '', 'Basics of Photography                             ', 'NO Requirements', 'Photography ...', '', 5, 4, 4599, 6000, '5fe43196d4c17photography2.jpg', '7dba3f7560', '2020-12-24 06:13:42', 'Photography'),
(42, 'koushil.webdeveloper@gmail.com', 'Photography ', 'Learn Photography Basic to Advanced', 'english', '', 'Basics of Photography                       ', 'NO Requirements\r\n                            ', 'Photography ...', '', 7, 6, 4577, 6000, '5fe431ab26c3aphotography3.jpg', '16be9c2574', '2020-12-24 06:14:03', 'Photography'),
(43, 'koushil.webdeveloper@gmail.com', 'Software Engineering', 'Learn Software Engineering', 'english', '', 'Software Engineering.\r\nLearn Basics of Software Engineering.\r\nCreate basic Software using Software Engineering Life Cycle', 'Basic Understandings of Software Engineering\r\n                            ', 'Software Engineering ...', '', 6, 2, 3299, 4599, '5fe432a99b6e1software-engineering.jpg', '62ccbbdd75', '2020-12-24 06:18:17', 'Software'),
(44, 'koushil.webdeveloper@gmail.com', 'Software Design', 'Learn Software Design', 'english', '', 'Software Design.\r\nLearn Basics of Software Design                            ', 'Basic Understandings of Software Design\r\n                            ', 'Software Design ...', '', 5, 8, 3429, 4599, '5fe432fad655dsoftware_design.jpg', '425bda1b93', '2020-12-24 06:19:38', 'Software'),
(45, 'koushil.webdeveloper@gmail.com', 'UI Design', 'Learn UI Design', 'english', '', 'Learn Basic UI Design.\r\nCreate Basic Project of APP Design                                                      ', 'NO Requirements\r\n                                                        ', 'UI Design ...', '', 7, 5, 459, 690, '5fe4335b6b842ui_design.jpg', '1a0fe921a4', '2020-12-24 06:22:59', 'UX Design');

-- --------------------------------------------------------

--
-- Table structure for table `course_order`
--

CREATE TABLE `course_order` (
  `crs_ord_id` int(11) NOT NULL,
  `or_id` varchar(255) COLLATE utf8_bin NOT NULL,
  `txn_id` varchar(255) COLLATE utf8_bin NOT NULL,
  `txn_amt` float NOT NULL,
  `py_md` varchar(10) COLLATE utf8_bin NOT NULL,
  `txn_dt` datetime NOT NULL,
  `or_st` varchar(255) COLLATE utf8_bin NOT NULL,
  `or_msg` varchar(255) COLLATE utf8_bin NOT NULL,
  `or_gtw` varchar(255) COLLATE utf8_bin NOT NULL,
  `or_btxn` varchar(255) COLLATE utf8_bin NOT NULL,
  `or_bnm` varchar(255) COLLATE utf8_bin NOT NULL,
  `stu_email` varchar(255) COLLATE utf8_bin NOT NULL,
  `crs_token` varchar(255) COLLATE utf8_bin NOT NULL,
  `crs_creator` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `course_order`
--

INSERT INTO `course_order` (`crs_ord_id`, `or_id`, `txn_id`, `txn_amt`, `py_md`, `txn_dt`, `or_st`, `or_msg`, `or_gtw`, `or_btxn`, `or_bnm`, `stu_email`, `crs_token`, `crs_creator`) VALUES
(1, 'ORDS8152329', '20201224111212800110168327802233426', 459, 'NB', '2020-12-24 20:11:12', 'TXN_SUCCESS', 'Txn Success', 'SBI', '13094700746', 'SBI', 'koushilmankali@gmail.com', '1a0fe921a4', 'koushil.webdeveloper@gmail.com'),
(2, 'ORDS10811373', '20210103111212800110168548602221338', 1689, 'NB', '2021-01-03 13:55:10', 'TXN_SUCCESS', 'Txn Success', 'AXIS', '11730983344', 'AXIS', 'koushilmankali@gmail.com', 'f23ef3f0d7', 'nani@gmail.com'),
(3, 'ORDS72859500', '20210103111212800110168527002253884', 2158.4, 'NB', '2021-01-03 13:57:45', 'TXN_SUCCESS', 'Txn Success', 'ICICI', '17672021618', 'ICICI', 'koushilmankali@gmail.com', '99c924cf78', 'nani@gmail.com'),
(4, 'ORDS72859500', '20210103111212800110168527002253884', 2158.4, 'NB', '2021-01-03 13:57:45', 'TXN_SUCCESS', 'Txn Success', 'ICICI', '17672021618', 'ICICI', 'koushilmankali@gmail.com', '4f86ea30c4', 'koushil.webdeveloper@gmail.com'),
(5, 'ORDS91282634', '20210103111212800110168779802227891', 2150.4, 'NB', '2021-01-03 16:10:50', 'TXN_SUCCESS', 'Txn Success', 'SBI', '10994498856', 'SBI', 'telugufactstv@gmail.com', 'f23ef3f0d7', 'nani@gmail.com'),
(6, 'ORDS91282634', '20210103111212800110168779802227891', 2150.4, 'NB', '2021-01-03 16:10:50', 'TXN_SUCCESS', 'Txn Success', 'SBI', '10994498856', 'SBI', 'telugufactstv@gmail.com', '98ca6c20a2', 'koushil.webdeveloper@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `instructor_data`
--

CREATE TABLE `instructor_data` (
  `id` int(11) NOT NULL,
  `iname` varchar(256) COLLATE utf8_bin NOT NULL,
  `iemail` varchar(256) COLLATE utf8_bin NOT NULL,
  `ipass` varchar(256) COLLATE utf8_bin NOT NULL,
  `idesc` text COLLATE utf8_bin NOT NULL,
  `ipic` varchar(256) COLLATE utf8_bin NOT NULL,
  `r_token` varchar(256) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `instructor_data`
--

INSERT INTO `instructor_data` (`id`, `iname`, `iemail`, `ipass`, `idesc`, `ipic`, `r_token`) VALUES
(1, 'koushil.dev', 'koushil@gmail.com', '$2y$10$/9E9oL0qE0fZ4dbJuG3a1e/fpfTUrQf1MBygkQ.dnCL5UIOjpcQPG', 'I am a Professional Web Developer i have learned all the technologies by my self and love to learn new technologies also love to share my knowledge and i think uclone is the best platform for it.', '5fe49a71551ecinst5.png', ''),
(2, 'nani', 'nani@gmail.com', '$2y$10$FCXkZhvZodkibNYI69MBiuxkR6jKvjIk3KXXBrqeJ25u68lIW3uZa', 'I am a Professional Web Developer i have learned all the technologies by my self and love to learn new technologies also love to share my knowledge and i think uclone is the best platform for it.', '5fe49a957a38cinst3.png', '');

-- --------------------------------------------------------

--
-- Table structure for table `lectures`
--

CREATE TABLE `lectures` (
  `id` int(11) NOT NULL,
  `crs_token` varchar(255) COLLATE utf8_bin NOT NULL,
  `sec_nm` varchar(255) COLLATE utf8_bin NOT NULL,
  `lct_nm` varchar(255) COLLATE utf8_bin NOT NULL,
  `lct_dur` time NOT NULL,
  `lct_vid` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `lectures`
--

INSERT INTO `lectures` (`id`, `crs_token`, `sec_nm`, `lct_nm`, `lct_dur`, `lct_vid`) VALUES
(1, '98ca6c20a2', 'Section1', 'Intro to PHP', '00:15:00', '5fdedaec6a9d6video.m4v'),
(2, '98ca6c20a2', 'Section1', 'Variables', '00:10:00', '5fdedb4c957bevideo.m4v'),
(3, '98ca6c20a2', 'Section1', 'Constants', '00:06:00', '5fe4978c06613video.m4v'),
(4, '98ca6c20a2', 'Section2', 'Functions', '00:23:00', '5fe497a3870b5video.m4v'),
(5, '98ca6c20a2', 'Section2', 'Arrays', '00:18:23', '5fe497b4eb1cavideo.m4v'),
(6, '98ca6c20a2', 'Section3', 'Class', '00:14:54', '5fe497e6721c4video.m4v'),
(7, '98ca6c20a2', 'Section3', 'Object', '00:13:34', '5fe497f8483ccvideo.m4v'),
(8, '98ca6c20a2', 'Section4', 'MySql', '00:34:56', '5fe498251dd5cvideo.m4v'),
(9, '98ca6c20a2', 'Section4', 'PDO', '00:18:32', '5fe49883da0abvideo.m4v'),
(10, '98ca6c20a2', 'Section4', 'PDO Object Oriented', '00:12:07', '5fe4989e0e791video.m4v'),
(11, '98ca6c20a2', 'Section5', 'Arrow Functions', '00:18:27', '5fe498e250eb6video.m4v'),
(12, '98ca6c20a2', 'Section5', 'Array Functions', '00:29:16', '5fe499117788avideo.m4v'),
(13, '98ca6c20a2', 'Section6', 'Exception Handling', '00:23:44', '5fe4993c72623video.m4v');

-- --------------------------------------------------------

--
-- Table structure for table `password_reset`
--

CREATE TABLE `password_reset` (
  `email` varchar(256) COLLATE utf8_bin NOT NULL,
  `code` varchar(8) COLLATE utf8_bin NOT NULL,
  `timestamp` timestamp(6) NOT NULL DEFAULT current_timestamp(6) ON UPDATE current_timestamp(6)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Table structure for table `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_bin NOT NULL,
  `ratings` varchar(5) COLLATE utf8_bin NOT NULL,
  `time` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `comment` text COLLATE utf8_bin NOT NULL,
  `stu_email` varchar(255) COLLATE utf8_bin NOT NULL,
  `crs_token` varchar(255) COLLATE utf8_bin NOT NULL,
  `creator_email` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `review`
--

INSERT INTO `review` (`id`, `name`, `ratings`, `time`, `comment`, `stu_email`, `crs_token`, `creator_email`) VALUES
(1, 'koushil', '5', '2021-01-01 06:40:02', 'awesome content.', 'koushilmankali@gmail.com', '98ca6c20a2', 'koushil.webdeveloper@gmail.com'),
(2, 'koushil', '1', '2021-01-03 09:12:10', 'Need to be improved...', 'koushilmankali@gmail.com', '98ca6c20a2', 'koushil.webdeveloper@gmail.com'),
(3, 'koushil', '5', '2021-01-03 10:30:30', 'Awesome Course...', 'koushilmankali@gmail.com', '98ca6c20a2', 'koushil.webdeveloper@gmail.com');

-- --------------------------------------------------------

--
-- Table structure for table `user_courses`
--

CREATE TABLE `user_courses` (
  `id` int(255) NOT NULL,
  `ucmail` varchar(255) COLLATE utf8_bin NOT NULL,
  `courses_en` varchar(256) COLLATE utf8_bin NOT NULL,
  `payment_id` varchar(255) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user_courses`
--

INSERT INTO `user_courses` (`id`, `ucmail`, `courses_en`, `payment_id`) VALUES
(1, 'koushilmankali@gmail.com', '1a0fe921a4', 'ORDS8152329'),
(2, 'koushilmankali@gmail.com', 'f23ef3f0d7', 'ORDS10811373'),
(3, 'koushilmankali@gmail.com', '99c924cf78', 'ORDS72859500'),
(4, 'koushilmankali@gmail.com', '4f86ea30c4', 'ORDS72859500'),
(5, 'telugufactstv@gmail.com', 'f23ef3f0d7', 'ORDS91282634'),
(6, 'telugufactstv@gmail.com', '98ca6c20a2', 'ORDS91282634');

-- --------------------------------------------------------

--
-- Table structure for table `user_data`
--

CREATE TABLE `user_data` (
  `id` int(11) NOT NULL,
  `uname` varchar(256) COLLATE utf8_bin NOT NULL,
  `uemail` varchar(256) COLLATE utf8_bin NOT NULL,
  `upassword` varchar(256) COLLATE utf8_bin NOT NULL,
  `u_pic` varchar(256) COLLATE utf8_bin NOT NULL,
  `r_token` varchar(256) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user_data`
--

INSERT INTO `user_data` (`id`, `uname`, `uemail`, `upassword`, `u_pic`, `r_token`) VALUES
(1, 'koushil', 'koushilmankali@gmail.com', '$2y$10$YAX/4TlIP8TATcRl6w3O7.V1Sscy3rP4jizRbnrrPa.HXwcnY7QDK', '5fe4998696e2cme.jpg', ''),
(2, 'navya', 'navya@gmail.com', '$2y$10$YCyC1joQzWAD.AttoIjItuP6IFM8LNbgCZ1g9DKxystx/97Fy6PHi', '5ff17e43699c45fe49a71551ecinst5.png', '');

-- --------------------------------------------------------

--
-- Table structure for table `user_verify`
--

CREATE TABLE `user_verify` (
  `id` int(11) NOT NULL,
  `uname` varchar(256) COLLATE utf8_bin NOT NULL,
  `uemail` varchar(256) COLLATE utf8_bin NOT NULL,
  `upassword` varchar(256) COLLATE utf8_bin NOT NULL,
  `token` varchar(256) COLLATE utf8_bin NOT NULL,
  `status` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data for table `user_verify`
--

INSERT INTO `user_verify` (`id`, `uname`, `uemail`, `upassword`, `token`, `status`) VALUES
(1, 'koushil', 'koushilmankali@gmail.com', '$2y$10$YAX/4TlIP8TATcRl6w3O7.V1Sscy3rP4jizRbnrrPa.HXwcnY7QDK', 'f2852f06dd938a97db69', 1),
(2, 'navya', 'navya@gmail.com', '$2y$10$YCyC1joQzWAD.AttoIjItuP6IFM8LNbgCZ1g9DKxystx/97Fy6PHi', 'fe85ea81e7924ccbfc51', 1),
(3, 'koushil.dev', 'koushil@gmail.com', '$2y$10$/9E9oL0qE0fZ4dbJuG3a1e/fpfTUrQf1MBygkQ.dnCL5UIOjpcQPG', 'f47e357b0d27d97c9ffd', 1),
(4, 'nani', 'nani@gmail.com', '$2y$10$FCXkZhvZodkibNYI69MBiuxkR6jKvjIk3KXXBrqeJ25u68lIW3uZa', 'ed7d3b2826103f7cd279', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`cat_id`);

--
-- Indexes for table `coupons`
--
ALTER TABLE `coupons`
  ADD PRIMARY KEY (`cpn_id`);

--
-- Indexes for table `courses`
--
ALTER TABLE `courses`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `crs_token` (`crs_token`);

--
-- Indexes for table `course_order`
--
ALTER TABLE `course_order`
  ADD PRIMARY KEY (`crs_ord_id`);

--
-- Indexes for table `instructor_data`
--
ALTER TABLE `instructor_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `iemail` (`iemail`);

--
-- Indexes for table `lectures`
--
ALTER TABLE `lectures`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_courses`
--
ALTER TABLE `user_courses`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_data`
--
ALTER TABLE `user_data`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uemail` (`uemail`);

--
-- Indexes for table `user_verify`
--
ALTER TABLE `user_verify`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uemail` (`uemail`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `cat_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `coupons`
--
ALTER TABLE `coupons`
  MODIFY `cpn_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `courses`
--
ALTER TABLE `courses`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- AUTO_INCREMENT for table `course_order`
--
ALTER TABLE `course_order`
  MODIFY `crs_ord_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `instructor_data`
--
ALTER TABLE `instructor_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `lectures`
--
ALTER TABLE `lectures`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT for table `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `user_courses`
--
ALTER TABLE `user_courses`
  MODIFY `id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `user_data`
--
ALTER TABLE `user_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_verify`
--
ALTER TABLE `user_verify`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

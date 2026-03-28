-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Mar 28, 2026 at 02:30 PM
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
-- Database: `diglib`
--

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `book_id` varchar(20) NOT NULL,
  `title` varchar(200) NOT NULL,
  `author` varchar(150) DEFAULT NULL,
  `edition` varchar(50) DEFAULT NULL,
  `publisher` varchar(150) DEFAULT NULL,
  `published_date` date DEFAULT NULL,
  `branch` enum('CSE','AIML','ECE','EEE','ME','CIVIL','OTHER') NOT NULL,
  `total_copies` int(11) NOT NULL DEFAULT 1,
  `available_copies` int(11) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`book_id`, `title`, `author`, `edition`, `publisher`, `published_date`, `branch`, `total_copies`, `available_copies`) VALUES
('RYMAIML0001', 'Artificial Intelligence: A Modern Approach', 'Stuart Russell & Peter Norvig', 'FOURTH EDITION', 'Pearson', '2021-02-10', 'AIML', 18, 14),
('RYMAIML0002', 'Machine Learning', 'Tom M. Mitchell', 'SECOND EDITION', 'McGraw Hill', '2019-09-15', 'AIML', 16, 12),
('RYMAIML0003', 'Deep Learning', 'Ian Goodfellow, Yoshua Bengio, Aaron Courville', 'FIRST EDITION', 'MIT Press', '2016-11-10', 'AIML', 15, 10),
('RYMAIML0004', 'Python Machine Learning', 'Sebastian Raschka', 'THIRD EDITION', 'Packt Publishing', '2020-08-01', 'AIML', 17, 11),
('RYMAIML0005', 'Hands-On Machine Learning with Scikit-Learn and TensorFlow', 'Aurélien Géron', 'SECOND EDITION', 'O\'Reilly Media', '2019-10-20', 'AIML', 19, 16),
('RYMAIML0006', 'Practical Natural Language Processing', 'Sowmya Vajjala', 'FIRST EDITION', 'O\'Reilly Media', '2020-05-12', 'AIML', 14, 8),
('RYMAIML0007', 'Reinforcement Learning: An Introduction', 'Richard S. Sutton & Andrew G. Barto', 'SECOND EDITION', 'MIT Press', '2018-03-05', 'AIML', 13, 9),
('RYMAIML0008', 'Data Science from Scratch', 'Joel Grus', 'SECOND EDITION', 'O\'Reilly Media', '2019-04-14', 'AIML', 12, 6),
('RYMAIML0009', 'Neural Networks and Deep Learning', 'Michael Nielsen', 'FIRST EDITION', 'Determination Press', '2015-06-17', 'AIML', 11, 5),
('RYMAIML0010', 'Pattern Recognition and Machine Learning', 'Christopher M. Bishop', 'FIRST EDITION', 'Springer', '2017-01-22', 'AIML', 20, 18),
('RYMCIVIL0001', 'Basic Civil Engineering', 'S.S. Bhavikatti', 'FOURTH EDITION', 'New Age International', '2018-03-15', 'CIVIL', 18, 13),
('RYMCIVIL0002', 'Strength of Materials', 'R.K. Rajput', 'FIFTH EDITION', 'S. Chand Publishing', '2019-07-22', 'CIVIL', 16, 11),
('RYMCIVIL0003', 'Surveying Vol. 1', 'B.C. Punmia', 'SEVENTH EDITION', 'Laxmi Publications', '2017-02-10', 'CIVIL', 15, 10),
('RYMCIVIL0004', 'Concrete Technology', 'M.S. Shetty', 'FIRST EDITION', 'S. Chand Publishing', '2016-01-28', 'CIVIL', 12, 7),
('RYMCIVIL0005', 'Fluid Mechanics', 'R.K. Bansal', 'NINTH EDITION', 'Laxmi Publications', '2020-10-05', 'CIVIL', 19, 16),
('RYMCIVIL0006', 'Transportation Engineering', 'L.R. Kadiyali', 'FOURTH EDITION', 'Khanna Publishers', '2018-06-19', 'CIVIL', 14, 9),
('RYMCIVIL0007', 'Structural Analysis', 'S.S. Bhavikatti', 'SECOND EDITION', 'Vikas Publishing', '2017-11-08', 'CIVIL', 13, 8),
('RYMCIVIL0008', 'Environmental Engineering', 'P.N. Modi', 'THIRD EDITION', 'Standard Book House', '2021-04-11', 'CIVIL', 17, 12),
('RYMCIVIL0009', 'Geotechnical Engineering', 'C.Venkatramaiah', 'FOURTH EDITION', 'New Age International', '2019-05-09', 'CIVIL', 20, 18),
('RYMCIVIL0010', 'Engineering Hydrology', 'K. Subramanya', 'FOURTH EDITION', 'McGraw Hill', '2020-09-14', 'CIVIL', 11, 6),
('RYMCSE0001', 'Introduction to Algorithms', 'Cormen, Leiserson, Rivest, Stein', 'FOURTH EDITION', 'MIT Press', '2022-04-10', 'CSE', 17, 15),
('RYMCSE0002', 'Introduction to Algorithms', 'Cormen, Leiserson, Rivest, Stein', 'FOURTH EDITION', 'MIT Press', '2022-04-10', 'CSE', 18, 14),
('RYMCSE0003', 'Database System Concepts', 'Korth, Sudarshan, Silberschatz', 'SEVENTH EDITION', 'McGraw Hill', '2019-01-20', 'CSE', 19, 15),
('RYMCSE0004', 'Computer Networks', 'Andrew S. Tanenbaum', 'FIFTH EDITION', 'Pearson', '2017-09-12', 'CSE', 16, 12),
('RYMCSE0005', 'Object-Oriented Programming with C++', 'E. Balagurusamy', 'EIGHTH EDITION', 'McGraw Hill', '2020-08-25', 'CSE', 14, 9),
('RYMCSE0006', 'Java: The Complete Reference', 'Herbert Schildt', 'ELEVENTH EDITION', 'McGraw Hill', '2021-03-14', 'CSE', 20, 18),
('RYMCSE0007', 'Software Engineering', 'Ian Sommerville', 'TENTH EDITION', 'Pearson', '2016-05-17', 'CSE', 13, 8),
('RYMCSE0008', 'Compiler Design', 'Aho, Lam, Sethi, Ullman', 'SECOND EDITION', 'Pearson', '2006-06-29', 'CSE', 11, 6),
('RYMCSE0009', 'Data Structures and Algorithms in Java', 'Robert Lafore', 'SECOND EDITION', 'Sams Publishing', '2017-10-09', 'CSE', 12, 7),
('RYMCSE0010', 'Computer Organization and Architecture', 'William Stallings', 'ELEVENTH EDITION', 'Pearson', '2019-02-28', 'CSE', 15, 10),
('RYMCSE0011', 'Programming in ANSI C', 'E. Balagurusamy', 'SIXTH EDITION', 'McGraw Hill', '2019-06-11', 'CSE', 18, 13),
('RYMCSE0012', 'Clean Code', 'Robert C. Martin', 'FIRST EDITION', 'Prentice Hall', '2008-08-01', 'CSE', 16, 12),
('RYMCSE0013', 'Learning Python', 'Mark Lutz', 'FIFTH EDITION', 'O\'Reilly Media', '2013-07-06', 'CSE', 17, 11),
('RYMCSE0014', 'Python Crash Course', 'Eric Matthes', 'SECOND EDITION', 'No Starch Press', '2019-05-03', 'CSE', 14, 9),
('RYMCSE0015', 'Head First Java', 'Kathy Sierra, Bert Bates', 'SECOND EDITION', 'O\'Reilly Media', '2005-02-09', 'CSE', 13, 8),
('RYMCSE0016', 'C Programming Language', 'Kernighan & Ritchie', 'SECOND EDITION', 'Prentice Hall', '1988-04-01', 'CSE', 15, 10),
('RYMCSE0017', 'Design Patterns: Elements of Reusable Object-Oriented Software', 'Gamma, Helm, Johnson, Vlissides', 'FIRST EDITION', 'Addison-Wesley', '1994-10-31', 'CSE', 11, 7),
('RYMCSE0018', 'Computer Graphics with OpenGL', 'Donald Hearn & Pauline Baker', 'THIRD EDITION', 'Pearson', '2014-06-18', 'CSE', 12, 6),
('RYMCSE0019', 'Cloud Computing: Concepts, Technology & Architecture', 'Thomas Erl', 'FIRST EDITION', 'Prentice Hall', '2013-05-20', 'CSE', 19, 17),
('RYMCSE0020', 'Big Data Analytics', 'Seema Acharya & Subhasini Chellappan', 'FIRST EDITION', 'Wiley', '2015-02-11', 'CSE', 20, 18),
('RYMCSE0021', 'Introduction to Java', 'Cormen, Leiserson, Rivest, Stein', 'FOURTH EDITION', 'MIT Press', '2025-12-12', 'CSE', 10, 8),
('RYMECE0001', 'Digital Signal Processing', 'John G. Proakis', 'FIFTH EDITION', 'Pearson', '2019-08-12', 'ECE', 18, 12),
('RYMECE0002', 'Microelectronic Circuits', 'Sedra & Smith', 'SIXTH EDITION', 'Oxford University Press', '2020-02-25', 'ECE', 15, 10),
('RYMECE0003', 'Communication Systems', 'Simon Haykin', 'FOURTH EDITION', 'Wiley', '2018-11-03', 'ECE', 17, 9),
('RYMECE0004', 'Control Systems Engineering', 'Nise Norman', 'THIRD EDITION', 'Wiley India', '2017-06-18', 'ECE', 14, 8),
('RYMECE0005', 'Signals and Systems', 'Alan V. Oppenheim', 'SEVENTH EDITION', 'Pearson', '2021-03-10', 'ECE', 19, 15),
('RYMECE0006', 'Electromagnetic Field Theory', 'U.A. Bakshi', 'SECOND EDITION', 'Technical Publications', '2016-09-29', 'ECE', 12, 6),
('RYMECE0007', 'VLSI Design', 'Kang & Leblebici', 'FIFTH EDITION', 'McGraw Hill', '2019-12-14', 'ECE', 16, 11),
('RYMECE0008', 'Embedded Systems', 'Rajkamal', 'FOURTH EDITION', 'Tata McGraw Hill', '2018-04-22', 'ECE', 13, 7),
('RYMECE0009', 'Analog and Digital Communication', 'H. Taub & D. Schilling', 'SIXTH EDITION', 'McGraw Hill', '2020-07-05', 'ECE', 20, 18),
('RYMECE001', 'Digital Signal Processing', 'John G. Proakis', 'FIFTH EDITION', 'Pearson', '2019-08-12', 'ECE', 18, 12),
('RYMECE0010', 'Power Electronics', 'M.H. Rashid', 'THIRD EDITION', 'Pearson', '2017-10-09', 'ECE', 11, 5),
('RYMECE002', 'Microelectronic Circuits', 'Sedra & Smith', 'SIXTH EDITION', 'Oxford University Press', '2020-02-25', 'ECE', 15, 10),
('RYMECE003', 'Communication Systems', 'Simon Haykin', 'FOURTH EDITION', 'Wiley', '2018-11-03', 'ECE', 17, 8),
('RYMECE004', 'Control Systems Engineering', 'Nise Norman', 'THIRD EDITION', 'Wiley India', '2017-06-18', 'ECE', 14, 8),
('RYMECE005', 'Signals and Systems', 'Alan V. Oppenheim', 'SEVENTH EDITION', 'Pearson', '2021-03-10', 'ECE', 19, 15),
('RYMECE006', 'Electromagnetic Field Theory', 'U.A. Bakshi', 'SECOND EDITION', 'Technical Publications', '2016-09-29', 'ECE', 12, 6),
('RYMECE007', 'VLSI Design', 'Kang & Leblebici', 'FIFTH EDITION', 'McGraw Hill', '2019-12-14', 'ECE', 16, 11),
('RYMECE008', 'Embedded Systems', 'Rajkamal', 'FOURTH EDITION', 'Tata McGraw Hill', '2018-04-22', 'ECE', 13, 7),
('RYMECE009', 'Analog and Digital Communication', 'H. Taub & D. Schilling', 'SIXTH EDITION', 'McGraw Hill', '2020-07-05', 'ECE', 20, 18),
('RYMECE010', 'Power Electronics', 'M.H. Rashid', 'THIRD EDITION', 'Pearson', '2017-10-09', 'ECE', 11, 5),
('RYMEEE0001', 'Electrical Machines', 'P.S. Bimbhra', 'FIFTH EDITION', 'Khanna Publishers', '2019-04-18', 'EEE', 18, 11),
('RYMEEE0002', 'Power System Analysis', 'Hadi Saadat', 'FOURTH EDITION', 'McGraw Hill', '2018-10-25', 'EEE', 16, 9),
('RYMEEE0003', 'Electric Circuits', 'James W. Nilsson', 'SEVENTH EDITION', 'Pearson', '2020-03-11', 'EEE', 19, 15),
('RYMEEE0004', 'Control Systems Engineering', 'I.J. Nagrath & M. Gopal', 'FIFTH EDITION', 'New Age International', '2017-12-06', 'EEE', 14, 8),
('RYMEEE0005', 'Power Electronics', 'M.H. Rashid', 'FOURTH EDITION', 'Pearson', '2019-07-30', 'EEE', 17, 10),
('RYMEEE0006', 'Electrical Measurements', 'A.K. Sawhney', 'THIRD EDITION', 'Dhanpat Rai Publications', '2016-09-20', 'EEE', 12, 6),
('RYMEEE0007', 'Renewable Energy Engineering', 'B.H. Khan', 'SECOND EDITION', 'McGraw Hill', '2021-01-14', 'EEE', 13, 7),
('RYMEEE0008', 'Switchgear and Protection', 'Sunil S. Rao', 'FIFTH EDITION', 'Khanna Publishers', '2018-05-22', 'EEE', 15, 11),
('RYMEEE0009', 'Transmission and Distribution', 'S. Manikandan', 'THIRD EDITION', 'PHI Learning', '2017-08-19', 'EEE', 11, 5),
('RYMEEE0010', 'Electric Power Generation', 'G.D. Rai', 'SIXTH EDITION', 'Khanna Publishers', '2020-11-09', 'EEE', 20, 18),
('RYMME0001', 'Thermodynamics: An Engineering Approach', 'Yunus A. Cengel', 'EIGHTH EDITION', 'McGraw Hill', '2018-02-14', 'ME', 18, 14),
('RYMME0002', 'Strength of Materials', 'F.L. Singer', 'FOURTH EDITION', 'Harper & Row', '2017-06-28', 'ME', 16, 11),
('RYMME0003', 'Theory of Machines', 'R.S. Khurmi & J.K. Gupta', 'FOURTH EDITION', 'S. Chand Publishing', '2019-09-12', 'ME', 17, 12),
('RYMME0004', 'Fluid Mechanics and Hydraulic Machines', 'R.K. Rajput', 'FIFTH EDITION', 'S. Chand Publishing', '2018-04-05', 'ME', 14, 9),
('RYMME0005', 'Engineering Mechanics: Statics and Dynamics', 'A.K. Tayal', 'THIRD EDITION', 'Umesh Publications', '2016-11-22', 'ME', 12, 7),
('RYMME0006', 'Manufacturing Technology', 'P.N. Rao', 'THIRD EDITION', 'McGraw Hill', '2017-03-18', 'ME', 15, 10),
('RYMME0007', 'Heat and Mass Transfer', 'J.P. Holman', 'TENTH EDITION', 'McGraw Hill', '2015-08-10', 'ME', 19, 16),
('RYMME0008', 'Machine Design', 'R.S. Khurmi & J.K. Gupta', 'FIRST EDITION', 'S. Chand Publishing', '2020-01-20', 'ME', 11, 6),
('RYMME0009', 'Automobile Engineering', 'Kripal Singh', 'SECOND EDITION', 'Standard Publishers', '2019-07-14', 'ME', 13, 8),
('RYMME0010', 'Industrial Engineering and Management', 'O.P. Khanna', 'SEVENTH EDITION', 'Dhanpat Rai Publications', '2018-10-29', 'ME', 20, 17),
('RYMOTH0001', 'Principles of Biology', 'Neil Campbell', 'FOURTH EDITION', 'Pearson', '2019-03-14', 'OTHER', 15, 12),
('RYMOTH0002', 'Human Physiology', 'Stuart Fox', 'TENTH EDITION', 'McGraw Hill', '2018-06-20', 'OTHER', 18, 13),
('RYMOTH0003', 'Molecular Biology of the Cell', 'Bruce Alberts', 'SIXTH EDITION', 'Garland Science', '2017-08-05', 'OTHER', 16, 11),
('RYMOTH0004', 'Genetics: A Conceptual Approach', 'Benjamin Pierce', 'FIFTH EDITION', 'Macmillan', '2016-11-12', 'OTHER', 14, 9),
('RYMOTH0005', 'Environmental Biology', 'P.D. Sharma', 'THIRD EDITION', 'Rastogi Publications', '2020-02-25', 'OTHER', 12, 8),
('RYMOTH0006', 'Organic Chemistry', 'Morrison & Boyd', 'SEVENTH EDITION', 'Pearson', '2015-05-18', 'OTHER', 19, 16),
('RYMOTH0007', 'Physical Chemistry', 'P.W. Atkins', 'NINTH EDITION', 'Oxford University Press', '2018-12-09', 'OTHER', 17, 14),
('RYMOTH0008', 'Inorganic Chemistry', 'J.D. Lee', 'FIFTH EDITION', 'Wiley India', '2017-09-03', 'OTHER', 15, 10),
('RYMOTH0009', 'Engineering Chemistry', 'O.G. Palanna', 'SECOND EDITION', 'McGraw Hill', '2016-01-22', 'OTHER', 13, 7),
('RYMOTH0010', 'Chemical Principles', 'Zumdahl', 'EIGHTH EDITION', 'Cengage Learning', '2019-07-28', 'OTHER', 20, 18),
('RYMOTH0011', 'Concepts of Physics Vol 1', 'H.C. Verma', 'FIRST EDITION', 'Bharati Bhawan', '2016-03-10', 'OTHER', 18, 15),
('RYMOTH0012', 'Fundamentals of Physics', 'Halliday & Resnick', 'ELEVENTH EDITION', 'Wiley', '2017-11-14', 'OTHER', 17, 10),
('RYMOTH0013', 'Engineering Physics', 'M.N. Avadhanulu', 'SEVENTH EDITION', 'S. Chand Publishing', '2018-02-04', 'OTHER', 14, 9),
('RYMOTH0014', 'Modern Physics', 'Arthur Beiser', 'FIFTH EDITION', 'McGraw Hill', '2019-06-21', 'OTHER', 12, 6),
('RYMOTH0015', 'Optics and Laser Physics', 'R. Murugeshan', 'FOURTH EDITION', 'S. Chand Publishing', '2020-01-16', 'OTHER', 13, 8),
('RYMOTH0016', 'Engineering Mathematics I', 'B.S. Grewal', 'FORTIETH EDITION', 'Khanna Publishers', '2018-09-07', 'OTHER', 20, 17),
('RYMOTH0017', 'Higher Engineering Mathematics', 'B.V. Ramana', 'FIRST EDITION', 'Tata McGraw Hill', '2015-12-15', 'OTHER', 15, 10),
('RYMOTH0018', 'Advanced Engineering Mathematics', 'Erwin Kreyszig', 'TENTH EDITION', 'Wiley', '2017-04-09', 'OTHER', 18, 14),
('RYMOTH0019', 'Discrete Mathematics and Applications', 'Kenneth Rosen', 'SEVENTH EDITION', 'McGraw Hill', '2016-08-18', 'OTHER', 13, 9),
('RYMOTH0020', 'Probability and Statistics', 'Schaum Series', 'SECOND EDITION', 'McGraw Hill', '2019-10-29', 'OTHER', 11, 6);

-- --------------------------------------------------------

--
-- Table structure for table `feedback`
--

CREATE TABLE `feedback` (
  `feedback_id` int(11) NOT NULL,
  `user_email` varchar(150) NOT NULL,
  `title` varchar(200) DEFAULT NULL,
  `message` text DEFAULT NULL,
  `submitted_on` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `feedback`
--

INSERT INTO `feedback` (`feedback_id`, `user_email`, `title`, `message`, `submitted_on`) VALUES
(12, 'renuka@gmail.com', 'REQUEST\r\n', 'The library needs additional copies of data structures and algorithms books because the existing ones are always issued.', '2025-11-20 15:47:51'),
(13, 'kavya@gmail.com', 'REQUEST', 'Please extend the library closing time to 7:30 PM so we can prepare well for internals.', '2025-11-20 15:48:51'),
(14, 'suma@gmail.com', 'FEEDBACK', 'The book issuing process takes a long time during mornings. If possible, add an extra counter for faster service.', '2025-11-20 15:50:12');

-- --------------------------------------------------------

--
-- Table structure for table `return_requests`
--

CREATE TABLE `return_requests` (
  `request_id` int(11) NOT NULL,
  `transaction_id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `book_id` varchar(20) NOT NULL,
  `request_date` datetime DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected','completed') DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `return_requests`
--

INSERT INTO `return_requests` (`request_id`, `transaction_id`, `user_id`, `book_id`, `request_date`, `status`) VALUES
(17, 9, 'RYMAIMLS0001', 'RYMAIML0001', '2025-11-21 10:31:38', 'approved'),
(18, 8, 'RYMAIMLS0001', 'RYMAIML0001', '2025-11-21 10:31:47', 'approved'),
(19, 12, 'RYMECES0001', 'RYMECE0002', '2025-11-21 11:03:16', 'approved'),
(20, 14, 'RYMECES0001', 'RYMAIML0002', '2025-11-21 11:03:26', 'approved'),
(21, 13, 'RYMAIMLS0001', 'RYMME0004', '2025-11-22 10:21:19', 'approved'),
(22, 15, 'RYMAIMLS0001', 'RYMEEE0001', '2025-11-24 11:24:17', 'pending'),
(23, 16, 'RYMAIMLS0001', 'RYMAIML0009', '2025-12-04 15:35:13', 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `transaction_id` int(11) NOT NULL,
  `user_id` varchar(20) NOT NULL,
  `book_id` varchar(20) NOT NULL,
  `issue_date` date NOT NULL,
  `return_date` date DEFAULT NULL,
  `status` enum('issued','returned','overdue','lost') DEFAULT 'issued',
  `issued_by` enum('admin','user') NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `transactions`
--

INSERT INTO `transactions` (`transaction_id`, `user_id`, `book_id`, `issue_date`, `return_date`, `status`, `issued_by`) VALUES
(8, 'RYMAIMLS0001', 'RYMAIML0001', '2025-11-20', '2025-11-21', 'returned', 'user'),
(9, 'RYMAIMLS0001', 'RYMAIML0001', '2025-11-20', '2025-11-21', 'returned', 'user'),
(10, 'RYMECES0001', 'RYMECE003', '2025-11-20', '2025-11-21', 'issued', 'user'),
(12, 'RYMECES0001', 'RYMECE0002', '2025-11-20', '2025-11-21', 'returned', 'user'),
(13, 'RYMAIMLS0001', 'RYMME0004', '2025-11-21', '2025-11-22', 'returned', 'user'),
(14, 'RYMECES0001', 'RYMAIML0002', '2025-11-21', '2025-11-21', 'returned', 'user'),
(15, 'RYMAIMLS0001', 'RYMEEE0001', '2025-11-22', '2025-12-06', 'issued', 'user'),
(16, 'RYMAIMLS0001', 'RYMAIML0009', '2025-12-04', '2025-12-18', 'issued', 'user'),
(17, 'RYMAIMLS0001', 'RYMAIML0008', '2025-12-04', '2025-12-18', 'issued', 'user');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` varchar(20) NOT NULL,
  `name` varchar(100) NOT NULL,
  `branch` varchar(20) NOT NULL DEFAULT 'other',
  `email` varchar(150) NOT NULL,
  `passwords` varchar(255) NOT NULL,
  `role` enum('admin','faculty','student') NOT NULL DEFAULT 'student',
  `join_date` datetime DEFAULT current_timestamp(),
  `status` enum('pending','approved','rejected') DEFAULT 'pending',
  `last_logout` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `name`, `branch`, `email`, `passwords`, `role`, `join_date`, `status`, `last_logout`) VALUES
('RYMAIMLS0001', 'Renuka K', 'AIML', 'renuka@gmail.com', '$2y$10$GHAFagkmBvazCk//dsw40unwKS8dFfQpZ/0Rj1AtKy7VaHMVyQ.2G', 'student', '2025-11-20 15:38:57', 'approved', '2025-12-06 12:24:27'),
('RYMAIMLS0002', 'Kavya', 'AIML', 'kavya@gmail.com', '$2y$10$RZ5u/HVVTBFE69bNBJoDzOpasGspduBVnQf0nmJWhDDboxnWIFavi', 'student', '2025-11-20 15:39:21', 'approved', '2025-11-24 10:54:45'),
('RYMAIMLS0003', 'Suma', 'AIML', 'suma@gmail.com', '$2y$10$3DDhyLBtcsfpbz8v2Jm2PuPhK097CbftQEDzLb.k94jgc1Cf14fUW', 'student', '2025-11-20 15:39:44', 'approved', '2025-11-20 15:50:26'),
('RYMCSEA0001', 'D.Masira Firdous', 'CSE', 'masifir123@gmail.com', '$2y$10$tm1S291lfFDDZMPjeE2A/OhhxC4BgJ3em/kUMD30J6HulkdYrfrCa', 'admin', '2025-11-20 13:38:21', 'approved', '2025-12-14 22:26:12'),
('RYMCSEA0002', 'Mahek Muskaan', 'CSE', 'mahek@gmail.com', '$2y$10$SWDI6yn.t5.prPZAKJufYektmrNU8fTOBVdk2aONfHpVEDFccLOqa', 'admin', '2025-11-20 14:00:12', 'approved', '2025-11-24 10:49:33'),
('RYMCSEA0003', 'Deepa Bang', 'CSE', 'deepabang@gmail.com', '$2y$10$SXnz4sLrRigTgIvnTbBR8uLgI6l3ijaQmPJCj7YQx78yXcblFZp7e', 'admin', '2025-11-20 14:02:23', 'approved', NULL),
('RYMECES0001', 'Trivedi', 'ECE', 'trivedi@gmail.com', '$2y$10$3ZGU.cUzxk6y71HrHMa9Re5DRV9TtOU7zi9NvFDUz624DsVE3CvFO', 'student', '2025-11-20 15:40:10', 'approved', '2025-11-21 11:03:38'),
('RYMECES0002', 'Bhagya', 'ECE', 'bhagya@gmail.com', '$2y$10$0v7YDpeTVdLNrr13jf94IeV/O7VhntPsRJAE/XT7k8g3b2wkrZOIK', 'student', '2025-11-20 15:40:58', 'approved', NULL),
('RYMEEES0001', 'Basamma', 'EEE', 'basamma@gmail.com', '$2y$10$0Hg4zr4eKhjv/c0juLKdOeuCDV6f41MpiY80VdodW4FTwMdhF9duC', 'student', '2025-11-20 15:40:35', 'pending', NULL),
('RYMEEES0002', 'Harika', 'EEE', 'harika@gmail.com', '$2y$10$0nJ0kL48g5QxFkPbh0EvSOrRJaozofe7MwOxfARaGgpYwg5Qi/QPy', 'student', '2025-11-20 15:41:22', 'pending', NULL),
('RYMMES0001', 'Gayatri', 'ME', 'gayatri@gmail.com', '$2y$10$K44cY0CbavN9lRaGPH8hD.2DT5F3.IvBL5vHhLk9bvYkWd63y58Qi', 'student', '2025-11-20 15:41:50', 'pending', NULL),
('RYMMES0002', 'Kanthi', 'ME', 'kanthi@gmail.com', '$2y$10$wdbXKx8KFM7WR5zjE3v71.TTntET3h.YVM5kNO6kWtfnDNITw7fim', 'student', '2025-11-20 15:42:16', 'pending', NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`book_id`);

--
-- Indexes for table `feedback`
--
ALTER TABLE `feedback`
  ADD PRIMARY KEY (`feedback_id`),
  ADD KEY `fk_feedback_user` (`user_email`);

--
-- Indexes for table `return_requests`
--
ALTER TABLE `return_requests`
  ADD PRIMARY KEY (`request_id`),
  ADD KEY `fk_return_trans` (`transaction_id`),
  ADD KEY `fk_return_book` (`book_id`),
  ADD KEY `fk_return_user` (`user_id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`transaction_id`),
  ADD KEY `fk_trans_book` (`book_id`),
  ADD KEY `fk_trans_user` (`user_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `feedback`
--
ALTER TABLE `feedback`
  MODIFY `feedback_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `return_requests`
--
ALTER TABLE `return_requests`
  MODIFY `request_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `transaction_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `feedback`
--
ALTER TABLE `feedback`
  ADD CONSTRAINT `fk_feedback_user` FOREIGN KEY (`user_email`) REFERENCES `users` (`email`) ON DELETE CASCADE;

--
-- Constraints for table `return_requests`
--
ALTER TABLE `return_requests`
  ADD CONSTRAINT `fk_return_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_return_trans` FOREIGN KEY (`transaction_id`) REFERENCES `transactions` (`transaction_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_return_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `transactions`
--
ALTER TABLE `transactions`
  ADD CONSTRAINT `fk_trans_book` FOREIGN KEY (`book_id`) REFERENCES `books` (`book_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `fk_trans_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

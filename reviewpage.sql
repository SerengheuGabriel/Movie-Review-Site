-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 31, 2022 at 05:11 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `reviewpage`
--

-- --------------------------------------------------------

--
-- Table structure for table `comments`
--

CREATE TABLE `comments` (
  `postID` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `text` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `followed`
--

CREATE TABLE `followed` (
  `theFollowerID` int(11) NOT NULL,
  `theFollowedID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `followed`
--

INSERT INTO `followed` (`theFollowerID`, `theFollowedID`) VALUES
(4, 5),
(4, 6),
(4, 8),
(5, 4),
(12, 4);

-- --------------------------------------------------------

--
-- Table structure for table `mostfollowed`
--

CREATE TABLE `mostfollowed` (
  `userNameID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movieID` int(11) NOT NULL,
  `movieTitle` varchar(255) NOT NULL,
  `moviePic` varchar(255) DEFAULT NULL,
  `movieReleaseYear` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movieID`, `movieTitle`, `moviePic`, `movieReleaseYear`) VALUES
(1, 'Star Wars: A New Hope', 'default-movie.jpg', 1977),
(2, 'Blade Runner', 'default-movie.jpg', NULL),
(3, 'Tick tick boom', 'tick-tick-boom.jpg', 2021),
(4, 'The Adam Project', 'MV5BOWM0YWMwMDQtMjE5NS00ZTIwLWE1NWEtODViMWZjMWI2OTU3XkEyXkFqcGdeQXVyMTEyMjM2NDc2._V1_FMjpg_UX1000_.jpg', 2022),
(5, 'A New Movie', 'default-movie.jpg', 2022);

-- --------------------------------------------------------

--
-- Table structure for table `request`
--

CREATE TABLE `request` (
  `requestID` int(11) NOT NULL,
  `requestText` varchar(255) DEFAULT NULL,
  `requestResolved` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `postID` int(11) NOT NULL,
  `postText` varchar(255) DEFAULT NULL,
  `likes` int(11) DEFAULT NULL,
  `userID` int(11) NOT NULL,
  `movieID` int(11) NOT NULL,
  `score` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`postID`, `postText`, `likes`, `userID`, `movieID`, `score`) VALUES
(24, 'good', NULL, 4, 2, 3),
(25, 'This was a great movie', NULL, 6, 1, 5),
(31, 'fun', NULL, 7, 1, 4),
(32, 'cool', NULL, 7, 2, 4),
(33, 'Definitely a classic, the one that started it all. Can\'t go wrong with it, even after all these years, it\'s a fan favorite for a reason. Even the obsolete effects are endearing and nostalgic', NULL, 8, 1, 5),
(34, 'A good movie, although I feel the sequel far outperformed it in directing, cinematography and acting, but still a solid viewing.', NULL, 8, 2, 3),
(35, 'I really didn\'t like this movie, too old, bad effects, cringe acting, plus it rips off The Force Awakens', NULL, 5, 1, 1),
(36, 'very gud very nice ', NULL, 4, 3, 4),
(37, 'this is a new review', NULL, 4, 4, 3),
(38, 'Was a nice movie', NULL, 12, 1, 4),
(39, 'not good', NULL, 12, 3, 1),
(40, 'Wow cool new movie', NULL, 4, 5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `userID` int(11) NOT NULL,
  `lastName` varchar(255) NOT NULL,
  `firstName` varchar(255) NOT NULL,
  `userName` varchar(255) DEFAULT NULL,
  `profilePicture` varchar(255) DEFAULT NULL,
  `bio` varchar(255) DEFAULT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`userID`, `lastName`, `firstName`, `userName`, `profilePicture`, `bio`, `password`) VALUES
(4, 'Serengheu', 'Gabriel', 'FreddiesPizza', 'profile-3-1.3e702c5.png', NULL, '$2y$10$s0fVmQs27b5crOY1b3QZAu9LQ6yAfpvuoBwGjOEJRIg.4B3.1C6fG'),
(5, 'Serengheu', 'Caylen', 'username1', 'defaultProfilePicture.jpg', NULL, '$2y$10$Z7jc3h/ON8QMiehb3E9pQ.FmHz6.Lfkx.GhhqjQNCNQTpl47cTr7K'),
(6, 'Serengheu', 'Sebastian', 'username2', 'defaultProfilePicture.jpg', NULL, '$2y$10$WoOHrB2PROEnmbVNuGB2cOYNJ7xNZltCxPuZD/HdyPoF/52LizFqi'),
(7, 'Serengheu', 'Mihai', 'Mihai', 'Gull_portrait_ca_usa.jpg', NULL, '$2y$10$Xr7sdvHUP10AAie4hDuzQOFV6LWGhzf/wlttsjiuRfhq9tRWjo5oy'),
(8, 'Serengheu', 'Bethany', 'username4', 'obamalaugh-1024x538.jpg', NULL, '$2y$10$PPUko3cwP5TtfJX4jr.t4ewN9ij1RYlFFPb/ysgSosH/2WasXmW8e'),
(9, 'Serengheu', 'Cineva', 'username5', 'defaultProfilePicture.jpg', NULL, '$2y$10$lNU3h0CF9valtjoLOjNmz.N.W5pTMwc/AWKsfq48XjJ2o2O0QZaNS'),
(10, 'Serengheu', 'Altcineva', 'username6', 'defaultProfilePicture.jpg', NULL, '$2y$10$2iycKYFZoi1EcXw4SOe8iechclz5mE35YRCiGvJ9.3iUOQxVoJNxe'),
(11, 'A', 'User', 'username', 'defaultProfilePicture.jpg', NULL, '$2y$10$Wd1.y66N7cyD71JZFOiJluPxZ0lAou6oZ.Gtao74eeoTw/g1rGKfK'),
(12, 'New', 'User', 'New Username', 'defaultProfilePicture.jpg', NULL, '$2y$10$onV7Z322TssbPLb71Uu8CeJ0eUhW7up7.1XdzZ9P79lKlVldZWy.q');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`postID`,`userID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `followed`
--
ALTER TABLE `followed`
  ADD PRIMARY KEY (`theFollowerID`,`theFollowedID`),
  ADD KEY `theFollowedID` (`theFollowedID`);

--
-- Indexes for table `mostfollowed`
--
ALTER TABLE `mostfollowed`
  ADD PRIMARY KEY (`userNameID`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movieID`);

--
-- Indexes for table `request`
--
ALTER TABLE `request`
  ADD PRIMARY KEY (`requestID`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`postID`),
  ADD KEY `movieID` (`movieID`),
  ADD KEY `userID` (`userID`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`userID`),
  ADD UNIQUE KEY `userName` (`userName`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movieID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `request`
--
ALTER TABLE `request`
  MODIFY `requestID` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `postID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `comments`
--
ALTER TABLE `comments`
  ADD CONSTRAINT `comments_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `comments_ibfk_2` FOREIGN KEY (`postID`) REFERENCES `reviews` (`postID`);

--
-- Constraints for table `followed`
--
ALTER TABLE `followed`
  ADD CONSTRAINT `followed_ibfk_1` FOREIGN KEY (`theFollowerID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `followed_ibfk_2` FOREIGN KEY (`theFollowedID`) REFERENCES `users` (`userID`);

--
-- Constraints for table `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`movieID`) REFERENCES `movies` (`movieID`),
  ADD CONSTRAINT `reviews_ibfk_3` FOREIGN KEY (`userID`) REFERENCES `users` (`userID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

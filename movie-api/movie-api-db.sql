-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 13, 2022 at 08:49 PM
-- Server version: 10.4.22-MariaDB
-- PHP Version: 8.1.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `movie-api-db`
--

-- --------------------------------------------------------

--
-- Table structure for table `actors`
--

CREATE TABLE `actors` (
  `actor_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `biography` varchar(1000) NOT NULL,
  `country` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `actors`
--

INSERT INTO `actors` (`actor_id`, `name`, `biography`, `country`) VALUES
(1, 'Pierre Coffin', 'Pierre-Louis Padang Coffin (born 16 March 1967)[1] is a French animator, voice actor, director, producer, and writer best known for co-directing four films in the Despicable Me franchise and being the voice of the Minions, which won him the Kids Family Award at the 10th Seiyu Awards.', 'France');

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE `characters` (
  `character_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `appearsIn` varchar(255) NOT NULL,
  `type` varchar(255) NOT NULL,
  `actor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `characters`
--

INSERT INTO `characters` (`character_id`, `name`, `appearsIn`, `type`, `actor_id`) VALUES
(1, 'Bob The Minion', 'Minions: The Rise of Gru', 'Main', 1);

-- --------------------------------------------------------

--
-- Table structure for table `directors`
--

CREATE TABLE `directors` (
  `director_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `biography` varchar(1000) DEFAULT NULL,
  `country` varchar(255) NOT NULL,
  `image` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `directors`
--

INSERT INTO `directors` (`director_id`, `name`, `biography`, `country`, `image`) VALUES
(1, 'Kyle Balda', 'Kyle Balda (born March 9, 1971) is an American animator and film director, best known for co-directing the animated films The Lorax (2012), with Chris Renaud, and Minions (2015), with Pierre Coffin.', 'USA', 'https://m.media-amazon.com/images/M/MV5BMWYwNWIwYWMtOGU2OC00OTY3LWI5OGEtZDE1YmNlMTA0YWI0XkEyXkFqcGdeQXVyMTQ1NzI0OTU@._V1_UY1200_CR133,0,630,1200_AL_.jpg'),
(2, 'Mark Cendrowski', 'Mark Cendrowski is an American film and television director. He is best known as the director of most episodes of The Big Bang Theory.', 'USA', 'https://www.dga.org/-/media/Images/DGAQ-Article-Images/1303-Summer-2013/Cendrowski2.ashx?la=en&hash=BBC3D8CDBE4A73A2E2ABEE9AAC0A86C3F8F63C3E');

-- --------------------------------------------------------

--
-- Table structure for table `movies`
--

CREATE TABLE `movies` (
  `movie_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `poster` varchar(255) NOT NULL,
  `release_date` date NOT NULL,
  `budget` varchar(255) DEFAULT NULL,
  `genre` varchar(255) NOT NULL,
  `director_id` int(11) NOT NULL,
  `studio_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `movies`
--

INSERT INTO `movies` (`movie_id`, `title`, `poster`, `release_date`, `budget`, `genre`, `director_id`, `studio_id`) VALUES
(1, 'Minions: The Rise of Gru', 'http://image.tmdb.org/t/p/w500//wKiOkZTN9lUUUNZLmtnwubZYONg.jpg', '2022-09-27', '80 000 000', 'Comedy', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `stars` varchar(10) NOT NULL,
  `review_description` varchar(2000) NOT NULL,
  `movie_id` int(11) DEFAULT NULL,
  `show_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `username`, `stars`, `review_description`, `movie_id`, `show_id`) VALUES
(1, 'vyperlook', '9/10', 'Just loved it, the whole time! There is no time to get bored at all, it\'s full of well-made action and really funny stuff, and the minions are truly lovely.', 1, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `shows`
--

CREATE TABLE `shows` (
  `show_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `release_date` date NOT NULL,
  `budget` varchar(255) DEFAULT NULL,
  `genre` varchar(255) NOT NULL,
  `director_id` int(11) DEFAULT NULL,
  `studio_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shows`
--

INSERT INTO `shows` (`show_id`, `title`, `release_date`, `budget`, `genre`, `director_id`, `studio_id`) VALUES
(1, 'The Big Bang Theory', '2007-09-24', '9 000 000', 'Sitcom', 2, 2);

-- --------------------------------------------------------

--
-- Table structure for table `studios`
--

CREATE TABLE `studios` (
  `studio_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `country` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `studios`
--

INSERT INTO `studios` (`studio_id`, `name`, `address`, `country`) VALUES
(1, 'Illimunation', '2230 Broadway, Santa Monica, CA', 'USA'),
(2, 'Warner Bros.', '3400 Warner Blvd., Burbank, CA 91505', 'USA');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `actors`
--
ALTER TABLE `actors`
  ADD PRIMARY KEY (`actor_id`);

--
-- Indexes for table `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`character_id`),
  ADD KEY `FK_characteractorID` (`actor_id`),
  ADD KEY `FK_appearsInmovieID` (`appearsIn`);

--
-- Indexes for table `directors`
--
ALTER TABLE `directors`
  ADD PRIMARY KEY (`director_id`);

--
-- Indexes for table `movies`
--
ALTER TABLE `movies`
  ADD PRIMARY KEY (`movie_id`),
  ADD KEY `FK_movieStudioID` (`studio_id`),
  ADD KEY `FK_directorID` (`director_id`);

--
-- Indexes for table `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Indexes for table `shows`
--
ALTER TABLE `shows`
  ADD PRIMARY KEY (`show_id`),
  ADD KEY `FK_showstudioID` (`studio_id`),
  ADD KEY `FK_showdirectorID` (`director_id`);

--
-- Indexes for table `studios`
--
ALTER TABLE `studios`
  ADD PRIMARY KEY (`studio_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `actors`
--
ALTER TABLE `actors`
  MODIFY `actor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `characters`
--
ALTER TABLE `characters`
  MODIFY `character_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `directors`
--
ALTER TABLE `directors`
  MODIFY `director_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `shows`
--
ALTER TABLE `shows`
  MODIFY `show_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `studios`
--
ALTER TABLE `studios`
  MODIFY `studio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `characters`
--
ALTER TABLE `characters`
  ADD CONSTRAINT `FK_characteractorID` FOREIGN KEY (`actor_id`) REFERENCES `actors` (`actor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `movies`
--
ALTER TABLE `movies`
  ADD CONSTRAINT `FK_directorID` FOREIGN KEY (`director_id`) REFERENCES `directors` (`director_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `shows`
--
ALTER TABLE `shows`
  ADD CONSTRAINT `FK_showdirectorID` FOREIGN KEY (`director_id`) REFERENCES `directors` (`director_id`),
  ADD CONSTRAINT `FK_showstudioID` FOREIGN KEY (`studio_id`) REFERENCES `studios` (`studio_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

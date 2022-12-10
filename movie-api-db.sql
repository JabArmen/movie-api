-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 10, 2022 at 03:20 AM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

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
(1, 'The Poseidon Adventure', 'Bio', 'France'),
(2, 'Shelly Winters', 'Bio', 'France'),
(3, 'Licia Magiletta', 'Bio', 'France'),
(4, 'Nicole Kidman', 'Bio', 'France'),
(5, 'Anni-Kristiina Juuso', 'Bio', 'USA'),
(6, 'Vincent Bonillo', 'Bio', 'USA'),
(7, 'Tobey Maguire', 'Bio', 'USA'),
(8, 'Joan Bennette', 'Bio', 'USA'),
(9, 'Micheal Redgrave', 'Bio', 'USA'),
(10, 'Barbara O\'Neil', 'Bio', 'USA'),
(11, 'Keanu Reeves', 'Bio', 'Lebanon'),
(12, 'Christian Bale ', 'Bio', 'United Kingdom '),
(13, 'Joaquin Phoenix', 'Bio', 'Puerto Rico'),
(14, 'Hugh Jackman', 'Bio', 'USA'),
(15, 'Sean Connery', 'Bio', 'United Kingdom');

-- --------------------------------------------------------

--
-- Table structure for table `characters`
--

CREATE TABLE `characters` (
  `character_id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `appearsIn` varchar(255) NOT NULL,
  `ttype` varchar(255) NOT NULL,
  `actor_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `characters`
--

INSERT INTO `characters` (`character_id`, `name`, `appearsIn`, `ttype`, `actor_id`) VALUES
(1, 'Reverend Scott', 'the poseidon adventure', 'Main', 1),
(2, 'Belle Rosen', 'the poseidon adventure', 'Secondary', 2),
(3, 'Rpsalba Barletta', 'Pane a tulipani', 'Main', 3),
(4, 'Grace Margeret', 'Dogville', 'Secondary', 4),
(5, 'Кукушка', 'Dogville', 'Secondary', 5),
(6, 'Alex', 'Absolut', 'Secondary', 6),
(7, 'Spider-Man', 'Absolut', 'Main', 7),
(8, 'Celia Lamphere', 'Secret Beyond the Door', 'Main', 8),
(9, 'Michael Redgrave', 'Secret Beyond the Door', 'Secondary', 9),
(10, 'Miss Robey', 'Secret Beyond the Door', 'Secondary', 10),
(11, 'Jhon Constantine', 'Constantine', 'Main', 11);

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
(2, 'Mark Cendrowski', 'Mark Cendrowski is an American film and television director. He is best known as the director of most episodes of The Big Bang Theory.', 'USA', 'https://www.dga.org/-/media/Images/DGAQ-Article-Images/1303-Summer-2013/Cendrowski2.ashx?la=en&hash=BBC3D8CDBE4A73A2E2ABEE9AAC0A86C3F8F63C3E'),
(3, 'Steven Spielberg', 'Steven Allan Spielberg KBE is an American film director, producer, and screenwriter. A major figure of the New Hollywood era and pioneer of the modern blockbuster, he is the most commercially successful director of all time.', 'USA', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHVS2ee6usybjD-SvuXSvnWU2E3qf7-5g5YOTbUK71OHqtPVTY'),
(4, 'Martin Scorsese', 'Martin Charles Scorsese is an American film director, producer, screenwriter and actor. He is the recipient of many major accolades, including an Academy Award, a Grammy Award and three Emmy Awards.', 'USA', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(5, 'Martin Scorsese', 'Martin Charles Scorsese is an American film director, producer, screenwriter and actor. He is the recipient of many major accolades, including an Academy Award, a Grammy Award and three Emmy Awards.', 'USA', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(6, 'Quentin Tarantino', 'Bio', 'USA', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(7, 'Christopher Nolan', 'Bio', 'France', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(8, 'Ridley Scott', 'Bio', 'France', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(9, 'Tim Burton', 'Bio', 'Canada', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(10, 'Stanley Kubrick', 'Bio', 'Canada', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(11, 'Alfred Hitchcock', 'Bio', 'Canada', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(12, 'Sidney Lumet\r\n', 'Bio', 'USA', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(13, 'Billy Wilder', 'Bio', 'USA', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(14, 'Peter Jackson', 'Bio', 'USA', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(15, 'Pedro Almodovar', 'Bio', 'USA', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s');

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
(550, 'Fight Club', '/pB8BM7pdSp6B6Ih7QZ4DrQ3PmJK.jpg', '1999-10-15', '63000000', 'Drama', 1, 1),
(551, 'The Poseidon Adventure', '/6RGiA5BfhelU9zoD0b1GAG4GWWf.jpg', '1972-12-13', '5000000', 'Action', 2, 2),
(552, 'Pane e tulipani', '/vz0THk3uPmYip2U761UqB2D0hRl.jpg', '2000-03-03', '0', 'Comedy', 3, 3),
(553, 'Dogville', '/lraVawavIXh5geMlVjpzCw9TGwR.jpg', '2003-05-19', '10000000', 'Crime', 4, 4),
(554, 'Кукушка', '/jz5u5anVn3PTAjHC1nQehZGQ41C.jpg', '2002-01-01', '0', 'Drama', 5, 5),
(555, 'Absolut', '/cwxOwSDwbwUfceIlaWFoo65SdzX.jpg', '2005-04-20', '0', 'Thriller', 6, 6),
(557, 'Spider-Man', '/gh4cZbhZxyTbgxQPxD0dOudNPTn.jpg', '2002-05-01', '139000000', 'Fantasy', 8, 8),
(558, 'Spider-Man 2', '/olxpyq9kJAZ2NU1siLshhhXEPR7.jpg', '2004-06-25', '200000000', 'Action', 9, 9),
(559, 'Spider-Man 3', '/rmGLCH63IBByBx5SCbsn0pNWHdg.jpg', '2007-05-01', '258000000', 'Fantasy', 10, 10),
(560, 'Secret Beyond the Door', '/uVBEwjzXweHWjCFjAs7eJzH9in6.jpg', '1947-12-24', '0', 'Crime', 11, 11),
(561, 'Constantine', '/vPYgvd2MwHlxTamAOjwVQp4qs1W.jpg', '2005-02-08', '100000000', 'Fantasy', 12, 12),
(562, 'Die Hard', '/yFihWxQcmqcaBR31QM6Y8gT6aYV.jpg', '1988-07-15', '28000000', 'Action', 13, 13),
(563, 'Starship Troopers', '/wlveVIVxvI7AHR4u5X9J0n31gmE.jpg', '1997-11-07', '105000000', 'Adventure', 14, 14),
(564, 'The Mummy', '/yhIsVvcUm7QxzLfT6HW2wLf5ajY.jpg', '1999-04-16', '80000000', 'Adventure', 15, 15),
(565, 'The Ring', '/e2t5CKMox7tjv3iD3Ko7NdFa5lJ.jpg', '2002-10-18', '48000000', 'Horror', 16, 16),
(567, 'Rear Window', '/qitnZcLP7C9DLRuPpmvZ7GiEjJN.jpg', '1954-08-01', '1000000', 'Thriller', 18, 18);

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
(2, 'Warner Bros.', '3400 Warner Blvd., Burbank, CA 91505', 'USA'),
(3, 'Village Roadshow Pictures', '3400 Warner Blvd., Burbank, CA 91505', 'USA'),
(4, 'Pixar Animation Studios', '3400 Warner Blvd., Burbank, CA 91505', 'USA'),
(5, 'Relativity Media', '3400 Warner Blvd., Burbank, CA 91505', 'USA'),
(6, 'Amblin Entertainment, Inc', '3400 Warner Blvd., Burbank, CA 91505', 'USA'),
(7, 'DreamWorks Animation LLC', '3400 Warner Blvd., Burbank, CA 91505', 'USA'),
(8, 'Access Industries, Inc.', '3400 Warner Blvd., Burbank, CA 91505', 'USA'),
(9, 'Legendary Pictures Productions, LLC', '3400 Warner Blvd., Burbank, CA 91505', 'USA'),
(10, 'New Line Cinema', '3400 Warner Blvd., Burbank, CA 91505', 'USA'),
(11, '20th Century Studios', '3400 Warner Blvd., Burbank, CA 91505', 'USA'),
(12, 'Disney', '3400 Warner Blvd., Burbank, CA 91505', 'USA'),
(13, 'CoMix Wave Films', '3400 Warner Blvd., Burbank, CA 91505', 'Japan'),
(14, 'Studio Ghibli', '3400 Warner Blvd., Burbank, CA 91505', 'Japan'),
(15, 'Universal Pictures', '3400 Warner Blvd., Burbank, CA 91505', 'Japan');

-- --------------------------------------------------------

--
-- Table structure for table `ws_log`
--

CREATE TABLE `ws_log` (
  `id` int(10) UNSIGNED NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `user_action` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `logged_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ws_users`
--

CREATE TABLE `ws_users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `last_name` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT '2022-12-01 08:11:50'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `ws_users`
--

INSERT INTO `ws_users` (`user_id`, `first_name`, `last_name`, `email`, `password`, `created_at`) VALUES
(0, 'GEv', 'Org', 'gevorgmarkarov@gmail.com', '$2y$15$3aqozZOQKxeOGsp/boZ2COrR0fjrTwqqMtdgYRfTm/bZVQ35xO/NS', '2022-12-09 14:03:56');

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
  MODIFY `actor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=120;

--
-- AUTO_INCREMENT for table `characters`
--
ALTER TABLE `characters`
  MODIFY `character_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `directors`
--
ALTER TABLE `directors`
  MODIFY `director_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=568;

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
  MODIFY `studio_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `characters`
--
ALTER TABLE `characters`
  ADD CONSTRAINT `FK_characteractorID` FOREIGN KEY (`actor_id`) REFERENCES `actors` (`actor_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints for table `shows`
--
ALTER TABLE `shows`
  ADD CONSTRAINT `FK_showstudioID` FOREIGN KEY (`studio_id`) REFERENCES `studios` (`studio_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

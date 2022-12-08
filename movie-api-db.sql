-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 08, 2022 at 05:34 AM
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
(1, 'Bruce Willis', 'Walter Bruce Willis is a retired American actor. He achieved fame with a leading role on the comedy-drama series Moonlighting and appeared in over a hundred films, gaining recognition as an action hero after his portrayal of John McClane in the Die Hard franchise and other roles.', 'France'),
(2, 'Shelly Winters', 'Shelley Winters was an American actress whose career spanned seven decades. She appeared in numerous films. She won Academy Awards for The Diary of Anne Frank and A Patch of Blue, and received nominations for A Place in the Sun and The Poseidon Adventure', 'France'),
(3, 'Licia Magiletta', 'Licia Maglietta is an Italian actress and stage director, known for her work with Italian director Silvio Soldini. Their collaborations include romances Bread and Tulips - for which Maglietta won multiple awards - and Agata and the Storm. In 2002 she won her second Italian Golden Globe, for Mafia drama Red Moon.', 'Italy'),
(4, 'Nicole Kidman', 'Nicole Mary Kidman AC is an American and Australian actress and producer. Known for her work across various film and television productions from several genres, she has consistently ranked among the world\'s highest-paid actresses.', 'France'),
(5, 'Anni-Kristiina Juuso', 'Anni-Kristiina Juuso is a Sámi actress, who played the leading female role in the movies The Cuckoo and The Kautokeino Rebellion. She was awarded Russia\'s Best Actress award by both the movie academy and the press. Juuso has also received a State Movie Award, which was handed to her by Vladimir Putin.', 'USA'),
(6, 'Vincent Bonillo', 'Vincent Bonillo is known for Absolut (2004), De ce monde (2005) and La vraie vie est ailleurs (2006).', 'USA'),
(7, 'Tobey Maguire', 'Tobias Vincent Maguire is an American actor and film producer. He is best known for playing the title character from Sam Raimi\'s Spider-Man trilogy, a role he later reprised in Spider-Man: No Way Home.', 'USA'),
(8, 'Joan Bennette', 'Joan Geraldine Bennett was an American stage, film, and television actress. She came from a show-business family, one of three acting sisters. Beginning her career on the stage, Bennett appeared in more than 70 films from the era of silent films, well into the sound era.', 'USA'),
(9, 'Micheal Redgrave', 'Sir Michael Scudamore Redgrave CBE was an English stage and film actor, director, manager and author. ', 'USA'),
(10, 'Barbara O\'Neil', 'Barbara O\'Neil was an American film and stage actress. She appeared in the film Gone with the Wind and was nominated for the Academy Award for Best Supporting Actress for her performance in All This, and Heaven Too. ', 'USA'),
(11, 'Keanu Reeves', 'Keanu Charles Reeves is a Canadian actor. Born in Beirut and raised in Toronto, Reeves began acting in theatre productions and in television films before making his feature film debut in Youngblood.', 'Lebanon'),
(12, 'Christian Bale ', 'Christian Charles Philip Bale is an English actor. Known for his versatility and physical transformations for his roles, he has been a leading man in films of several genres. He has received various accolades, including an Academy Award and two Golden Globe Awards.', 'United Kingdom '),
(13, 'Joaquin Phoenix', 'Joaquin Rafael Phoenix is an American actor. He is known for playing dark and unconventional characters in independent films. He has received various accolades, including an Academy Award, a British Academy Film Award, a Grammy Award, and two Golden Globe Awards.', 'Puerto Rico'),
(14, 'Hugh Jackman', 'Hugh Michael Jackman AC is an Australian actor. Beginning in theatre and television, he landed his breakthrough role as James \"Logan\" Howlett / Wolverine in the 20th Century Fox X-Men film serie', 'USA'),
(15, 'Sean Connery', 'Sir Sean Connery was a Scottish actor. He was the first actor to portray fictional British secret agent James Bond on film, starring in seven Bond films between 1962 and 1983. Originating the role in Dr. No, Connery played Bond in six of Eon Productions\' entries and made his final appearance in Never Say Never Again. ', 'United Kingdom');

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
  `country` varchar(255) NOT NULL,
  `image` varchar(500) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `directors`
--

INSERT INTO `directors` (`director_id`, `name`, `country`, `image`) VALUES
(1, 'Kyle Balda', 'USA', 'https://m.media-amazon.com/images/M/MV5BMWYwNWIwYWMtOGU2OC00OTY3LWI5OGEtZDE1YmNlMTA0YWI0XkEyXkFqcGdeQXVyMTQ1NzI0OTU@._V1_.jpg'),
(2, 'Mark Cendrowski', 'USA', 'https://www.dga.org/-/media/Images/DGAQ-Article-Images/1303-Summer-2013/Cendrowski2.ashx?la=en&hash=BBC3D8CDBE4A73A2E2ABEE9AAC0A86C3F8F63C3E'),
(3, 'Steven Spielberg', 'USA', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcRHVS2ee6usybjD-SvuXSvnWU2E3qf7-5g5YOTbUK71OHqtPVTY'),
(4, 'Martin Scorsese', 'USA', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(5, 'Martin Scorsese', 'USA', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(6, 'Quentin Tarantino', 'USA', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(7, 'Christopher Nolan', 'USA', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(8, 'Ridley Scott', 'France', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(9, 'Tim Burton', 'USA', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(10, 'Stanley Kubrick', 'USA', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(11, 'Alfred Hitchcock', 'Canada', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(12, 'Sidney Lumet\r\n', 'USA', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(13, 'Billy Wilder', 'USA', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(14, 'Peter Jackson', 'USA', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s'),
(15, 'Pedro Almodovar', 'USA', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ9SYxycjcugSjWeQCnl-D9rUcXhOQIP9h4oY-6PjcCkw&s');

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
(1, 'The Poseidon Adventure', '/6RGiA5BfhelU9zoD0b1GAG4GWWf.jpg', '1972-12-13', '5000000', 'Action', 0, 0),
(2, 'Pane e tulipani', '/vz0THk3uPmYip2U761UqB2D0hRl.jpg', '2000-03-03', '0', 'Comedy', 1, 1),
(3, 'Dogville', '/lraVawavIXh5geMlVjpzCw9TGwR.jpg', '2003-05-19', '10000000', 'Crime', 0, 0),
(4, 'Кукушка', '/jz5u5anVn3PTAjHC1nQehZGQ41C.jpg', '2002-01-01', '0', 'Drama', 0, 0),
(5, 'Absolut', '/cwxOwSDwbwUfceIlaWFoo65SdzX.jpg', '2005-04-20', '0', 'Thriller', 0, 0),
(7, 'Spider-Man', '/gh4cZbhZxyTbgxQPxD0dOudNPTn.jpg', '2002-05-01', '139000000', 'Fantasy', 0, 0),
(8, 'Spider-Man 2', '/olxpyq9kJAZ2NU1siLshhhXEPR7.jpg', '2004-06-25', '200000000', 'Action', 0, 0),
(9, 'Spider-Man 3', '/rmGLCH63IBByBx5SCbsn0pNWHdg.jpg', '2007-05-01', '258000000', 'Fantasy', 0, 0),
(10, 'Secret Beyond the Door', '/uVBEwjzXweHWjCFjAs7eJzH9in6.jpg', '1947-12-24', '0', 'Crime', 0, 0),
(11, 'Constantine', '/vPYgvd2MwHlxTamAOjwVQp4qs1W.jpg', '2005-02-08', '100000000', 'Fantasy', 0, 0),
(12, 'Die Hard', '/yFihWxQcmqcaBR31QM6Y8gT6aYV.jpg', '1988-07-15', '28000000', 'Action', 0, 0),
(13, 'Starship Troopers', '/wlveVIVxvI7AHR4u5X9J0n31gmE.jpg', '1997-11-07', '105000000', 'Adventure', 0, 0),
(14, 'The Mummy', '/yhIsVvcUm7QxzLfT6HW2wLf5ajY.jpg', '1999-04-16', '80000000', 'Adventure', 0, 0),
(15, 'The Ring', '/e2t5CKMox7tjv3iD3Ko7NdFa5lJ.jpg', '2002-10-18', '48000000', 'Horror', 0, 0),
(17, 'Rear Window', '/qitnZcLP7C9DLRuPpmvZ7GiEjJN.jpg', '1954-08-01', '1000000', 'Thriller', 0, 0);

-- --------------------------------------------------------

--
-- Table structure for table `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `stars` varchar(10) NOT NULL,
  `review_description` varchar(2000) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `reviews`
--

INSERT INTO `reviews` (`review_id`, `username`, `stars`, `review_description`) VALUES
(1, 'ScottD', '4', 'When you first see the absent set, and note the 3 hr runtime, you might feel like giving this a pass. Dont. By the end youll be shaking your head in wonder at the easy cruelty of the human condition.'),
(2, 'DianeM', '5', 'I\'m Speechless & Overwhelmed. No amount of words can describe the emotions i felt today. This is one of the greatest fan service I\'ve ever witnessed. And thus marks one of the greatest MCU movie ever made.'),
(3, 'GeorgeF', '5', 'This is not only the best Spider-Man film but also one of the best superhero films of all time! After all of these years and many new Spider-Man films, I still don’t think any has quite managed to get to this level of sheer awesomeness!!!!'),
(4, 'ShaheB', '4', 'Even if the non-action parts are a tad slow in comparison, that is more than compensated by so many things that makes Die Hard so brilliant.'),
(5, 'DeniseC', '1', 'This movie was not captivating at all and was a waste of the last 11 bucks I had in my savings'),
(6, 'JohnM', '3', 'Rear Window is one of the most famous movies ever done. Directed by Alfred Hitchcock, and starring James Stewart, Rear Window conveys a strong anxiety to the viewer from beginning to end. '),
(7, 'JohnM', '3', 'Rear Window is one of the most famous movies ever done. Directed by Alfred Hitchcock, and starring James Stewart, Rear Window conveys a strong anxiety to the viewer from beginning to end. ');

-- --------------------------------------------------------

--
-- Table structure for table `shows`
--

CREATE TABLE `shows` (
  `show_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `release_date` varchar(255) NOT NULL,
  `end_date` varchar(255) DEFAULT NULL,
  `genre` varchar(255) NOT NULL,
  `network` varchar(255) DEFAULT NULL,
  `image` varchar(255) NOT NULL,
  `director_id` int(11) DEFAULT NULL,
  `studio_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `shows`
--

INSERT INTO `shows` (`show_id`, `title`, `release_date`, `end_date`, `genre`, `network`, `image`, `director_id`, `studio_id`) VALUES
(1, 'Under the Dome', '2013-06-24', '2015-09-10', 'Drama', 'CBS', 'https://static.tvmaze.com/uploads/images/original_untouched/81/202627.jpg', 1, 1),
(2, 'Person of Interest', '2011-09-22', '2016-06-21', 'Action', 'CBS', 'https://static.tvmaze.com/uploads/images/original_untouched/163/407679.jpg', 2, 2),
(3, 'Bitten', '2014-01-11', '2016-04-15', 'Drama', 'CTV Sci-Fi Channel', 'https://static.tvmaze.com/uploads/images/original_untouched/0/15.jpg', 3, 3),
(4, 'Arrow', '2012-10-10', '2020-01-28', 'Drama', 'The CW', 'https://static.tvmaze.com/uploads/images/original_untouched/213/534017.jpg', 4, 4),
(5, 'True Detective', '2014-01-12', NULL, 'Drama', 'HBO', 'https://static.tvmaze.com/uploads/images/original_untouched/178/445621.jpg', 5, 5),
(6, 'The 100', '2014-03-19', '2020-09-30', 'Action', 'The CW', 'https://static.tvmaze.com/uploads/images/original_untouched/257/642675.jpg', 6, 6),
(7, 'Homeland', '2011-10-02', '2020-04-26', 'Drama', 'Showtime', 'https://static.tvmaze.com/uploads/images/original_untouched/230/575652.jpg', 7, 7),
(8, 'Glee', '2009-05-19', '2015-03-20', 'Drama', 'FOX', 'https://static.tvmaze.com/uploads/images/original_untouched/0/73.jpg', 8, 8),
(9, 'Revenge', '2011-09-21', '2015-05-10', 'Drama', 'ABC', 'https://static.tvmaze.com/uploads/images/original_untouched/82/206879.jpg', 9, 9),
(10, 'Grimm', '2011-10-28', '2017-03-31', 'Drama', 'NBC', 'https://static.tvmaze.com/uploads/images/original_untouched/69/174906.jpg', 10, 10),
(11, 'Gotham', '2014-09-22', '2019-04-25', 'Drama', 'FOX', 'https://static.tvmaze.com/uploads/images/original_untouched/189/474715.jpg', 11, 11),
(12, 'Lost Girl', '2010-09-12', '2015-10-25', 'Drama', 'Showcase', 'https://static.tvmaze.com/uploads/images/original_untouched/0/137.jpg', 12, 12),
(13, 'The Flash', '2014-10-07', NULL, 'Drama', 'The CW', 'https://static.tvmaze.com/uploads/images/original_untouched/383/957712.jpg', 13, 13),
(14, 'Continuum', '2012-05-27', '2015-10-09', 'Drama', 'Showcase', 'https://static.tvmaze.com/uploads/images/original_untouched/0/184.jpg', 14, 14),
(15, 'Constantine', '2014-10-24', '2015-02-13', 'Drama', 'NBC', 'https://static.tvmaze.com/uploads/images/original_untouched/0/154.jpg', 15, 15);

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
  MODIFY `actor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=119;

--
-- AUTO_INCREMENT for table `characters`
--
ALTER TABLE `characters`
  MODIFY `character_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `movies`
--
ALTER TABLE `movies`
  MODIFY `movie_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;

--
-- AUTO_INCREMENT for table `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `shows`
--
ALTER TABLE `shows`
  MODIFY `show_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

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
  ADD CONSTRAINT `FK_characteractorID` FOREIGN KEY (`actor_id`) REFERENCES `actors` (`actor_id`) ON DELETE CASCADE ON UPDATE NO ACTION;

--
-- Constraints for table `shows`
--
ALTER TABLE `shows`
  ADD CONSTRAINT `FK_movieDirectorID` FOREIGN KEY (`director_id`) REFERENCES `directors` (`director_id`) ON DELETE CASCADE ON UPDATE NO ACTION,
  ADD CONSTRAINT `FK_movieStudioID` FOREIGN KEY (`studio_id`) REFERENCES `studios` (`studio_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

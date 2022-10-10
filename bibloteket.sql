-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Värd: 127.0.0.1
-- Tid vid skapande: 07 okt 2022 kl 12:00
-- Serverversion: 10.4.24-MariaDB
-- PHP-version: 8.1.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databas: `bibloteket`
--

-- --------------------------------------------------------

--
-- Tabellstruktur `borrow`
--

CREATE TABLE `borrow` (
  `ID` int(11) NOT NULL,
  `mID` int(11) NOT NULL,
  `uID` int(11) NOT NULL,
  `bDate` date NOT NULL COMMENT 'borrow date',
  `rDate` date NOT NULL COMMENT 'Return Date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur `creator`
--

CREATE TABLE `creator` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumpning av Data i tabell `creator`
--

INSERT INTO `creator` (`ID`, `name`) VALUES
(1, 'JK. Rowling'),
(2, 'J. R. R. Tolkien'),
(3, 'George Lucas'),
(4, 'Martin Widmark');

-- --------------------------------------------------------

--
-- Tabellstruktur `genre`
--

CREATE TABLE `genre` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumpning av Data i tabell `genre`
--

INSERT INTO `genre` (`ID`, `name`) VALUES
(1, 'Fantasy'),
(2, 'Magic'),
(3, 'Sci-Fi'),
(4, 'Mystery');

-- --------------------------------------------------------

--
-- Tabellstruktur `media`
--

CREATE TABLE `media` (
  `ID` int(255) NOT NULL,
  `title` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `type` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `ageRestriction` int(11) NOT NULL,
  `length` int(11) NOT NULL COMMENT 'Movie/Audio book = Minutes |\r\nBook = Pages',
  `quality` int(1) NOT NULL COMMENT '0-9 |\r\n0 = Destroyed |\r\n9 = Perfect',
  `price` int(11) NOT NULL COMMENT 'Kr',
  `ISBN` varchar(13) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumpning av Data i tabell `media`
--

INSERT INTO `media` (`ID`, `title`, `type`, `ageRestriction`, `length`, `quality`, `price`, `ISBN`) VALUES
(1, 'Harry Potter and The Sorcerer\'s Stone', 'Book', 12, 223, 9, 50, '9780439362139'),
(2, 'Lord of The Rings Fellowship of the Ring', 'Book', 12, 423, 8, 50, '9789144014630'),
(3, 'Star Wars IV A New Hope', 'Movie', 12, 121, 6, 50, ''),
(4, 'LasseMajas sommarlovsbok. Var är Sylvester? ', 'Audio Book', 3, 30, 9, 20, ''),
(5, 'Uppslagsverk', 'Refrense Book', 0, 679, 7, 100, '976511674581'),
(6, 'The Hunger Games', 'Movie', 13, 142, 4, 0, ''),
(7, 'Jigsaw', 'Movie', 18, 91, 9, 10, ''),
(8, 'Liftarens Guide Till Galaxen', 'Book', 12, 673, 7, 10, '9789134514911'),
(11, 'Programmering 1 C#', 'Refrense Book', 3, 288, 9, 10, '9789140674029'),
(12, 'Java direkt', 'Refrense Book', 3, 721, 5, 10, '9789144038438'),
(13, 'Objekt-orienterad programutveckling med C++', 'Refrense Book', 3, 457, 9, 10, '9789144348018'),
(14, 'Webbprogrammering med PHP', 'Refrense Book', 3, 199, 9, 10, '9789163609732');

-- --------------------------------------------------------

--
-- Tabellstruktur `mediacreator`
--

CREATE TABLE `mediacreator` (
  `ID` int(11) NOT NULL,
  `mID` int(11) NOT NULL,
  `cID` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumpning av Data i tabell `mediacreator`
--

INSERT INTO `mediacreator` (`ID`, `mID`, `cID`) VALUES
(1, 1, 1),
(2, 2, 2),
(3, 3, 3),
(4, 4, 4),
(5, 6, 1);

-- --------------------------------------------------------

--
-- Tabellstruktur `mediagenre`
--

CREATE TABLE `mediagenre` (
  `ID` int(11) NOT NULL,
  `gID` int(11) NOT NULL COMMENT 'Genre ID',
  `mID` int(11) NOT NULL COMMENT 'Media ID'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumpning av Data i tabell `mediagenre`
--

INSERT INTO `mediagenre` (`ID`, `gID`, `mID`) VALUES
(1, 1, 1),
(2, 2, 1),
(3, 1, 2),
(4, 2, 2),
(5, 3, 3),
(6, 2, 3),
(7, 4, 4),
(8, 2, 6);

-- --------------------------------------------------------

--
-- Tabellstruktur `queue`
--

CREATE TABLE `queue` (
  `ID` int(11) NOT NULL,
  `uID` int(11) NOT NULL COMMENT 'User ID',
  `mID` int(11) NOT NULL COMMENT 'Media ID',
  `qDate` date NOT NULL COMMENT 'Queue Date'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

-- --------------------------------------------------------

--
-- Tabellstruktur `user`
--

CREATE TABLE `user` (
  `ID` int(11) NOT NULL,
  `name` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_swedish_ci NOT NULL,
  `dob` varchar(10) COLLATE utf8_swedish_ci NOT NULL,
  `adress` varchar(255) COLLATE utf8_swedish_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_swedish_ci;

--
-- Dumpning av Data i tabell `user`
--

INSERT INTO `user` (`ID`, `name`, `password`, `dob`, `adress`) VALUES
(0, 'root', 'root', '1995-01-01', 'biblioteket'),
(1, 'Theodore', 'ormbook123', '2003-04-28', 'Regementsgatan 2D'),
(2, 'Albin', 'asd123', '2003-01-01', 'Billingen'),
(3, 'Elidon', 'smajli', '2003-12-28', 'Regementsgatan 2I'),
(4, 'Leif GW Persson', 'tolkien', '1985-11-07', 'Stockholm');

--
-- Index för dumpade tabeller
--

--
-- Index för tabell `borrow`
--
ALTER TABLE `borrow`
  ADD PRIMARY KEY (`ID`);

--
-- Index för tabell `creator`
--
ALTER TABLE `creator`
  ADD PRIMARY KEY (`ID`);

--
-- Index för tabell `genre`
--
ALTER TABLE `genre`
  ADD PRIMARY KEY (`ID`);

--
-- Index för tabell `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`ID`);

--
-- Index för tabell `mediacreator`
--
ALTER TABLE `mediacreator`
  ADD PRIMARY KEY (`ID`);

--
-- Index för tabell `mediagenre`
--
ALTER TABLE `mediagenre`
  ADD PRIMARY KEY (`ID`);

--
-- Index för tabell `queue`
--
ALTER TABLE `queue`
  ADD PRIMARY KEY (`ID`);

--
-- Index för tabell `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`ID`);

--
-- AUTO_INCREMENT för dumpade tabeller
--

--
-- AUTO_INCREMENT för tabell `borrow`
--
ALTER TABLE `borrow`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT för tabell `creator`
--
ALTER TABLE `creator`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT för tabell `genre`
--
ALTER TABLE `genre`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT för tabell `media`
--
ALTER TABLE `media`
  MODIFY `ID` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT för tabell `mediacreator`
--
ALTER TABLE `mediacreator`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT för tabell `mediagenre`
--
ALTER TABLE `mediagenre`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT för tabell `queue`
--
ALTER TABLE `queue`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=74;

--
-- AUTO_INCREMENT för tabell `user`
--
ALTER TABLE `user`
  MODIFY `ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 15. Mai 2024 um 12:10
-- Server-Version: 10.4.32-MariaDB
-- PHP-Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `urlaubsverwaltung`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `krankheit`
--

CREATE TABLE `krankheit` (
  `kid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `kanfang` date NOT NULL,
  `kende` date NOT NULL,
  `kgesamt` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `krankheit`
--

INSERT INTO `krankheit` (`kid`, `pid`, `kanfang`, `kende`, `kgesamt`) VALUES
(4, 110, '2024-05-16', '2024-05-18', 3);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `personal`
--

CREATE TABLE `personal` (
  `pid` int(11) NOT NULL,
  `vorname` varchar(30) NOT NULL,
  `nachname` char(30) NOT NULL,
  `passwort` varchar(65) NOT NULL,
  `status` char(30) NOT NULL,
  `urlaubstage` int(11) NOT NULL DEFAULT 30,
  `resturlaub` int(11) NOT NULL DEFAULT 30
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `personal`
--

INSERT INTO `personal` (`pid`, `vorname`, `nachname`, `passwort`, `status`, `urlaubstage`, `resturlaub`) VALUES
(105, 'Maximilian', 'Chadman', '$2y$10$ak8zZqPC8U6XS8Hud9w.7On7u0SAz87XEewOj2Qas5Pb1Nu5M5yPK', 'Abteilungsleiter', 30, 30),
(106, 'Maxim', 'Musterbro', '$2y$10$AE/k/X9N3sfC9CkiP5BzNecznXxrh94rimp0USP00/nY71wCwNyx2', 'Angestellter', 30, 30),
(107, 'Broda', 'de Rgroßartige', '$2y$10$RATuA.ObU.6dOqy/LJU1h.PCaV5NmhzRAbi432bzfWzaBlQsGCKCa', 'Angestellter', 30, 30),
(108, 'Klares ', 'Passwort', '$2y$10$V/.DH47s6OooHAbIXrCXyO.d6ZnTOSoE6iicFa1WEz4Qw0WX1t3Mq', 'Admin', 30, 30),
(109, 'Serj', 'Admin', '$2y$10$zoWvrhvR4VCAyLlOBvG0Wudsfzt1aWtoMo0BlukKtqPO/QizU.POO', 'Admin', 30, 30),
(110, '110', 'Dude', '$2y$10$d9cDd17IyIiq1uVrUyR3NOAt7Lb/DcsnyHWBvIDBmcDZ4TbpGOre.', 'Admin', 30, 32),
(111, 'Neuer', 'Abteilungsleiter', '$2y$10$uRkIXBzezzyEP.ZfwG0Zv.HbZfhM5.1dYEpWtfloe2WMik/oChHrG', 'Abteilungsleiter', 30, 0),
(112, 'Neuer', 'Angestellter', '$2y$10$TQuVuQU5pAn8reA2hYIC9OQkWmT995DSmQoIfY5hULnmmCJ838X2a', 'Angestellter', 30, 30),
(113, 'Test', 'User', '$2y$10$yal6USgN/i9rdL/ARC1wE.L/GSGVrqYvqme4XlSh4uk09kcIL7z1K', 'Angestellter', 30, 30);

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `urlaubsantrag`
--

CREATE TABLE `urlaubsantrag` (
  `uid` int(11) NOT NULL,
  `pid` int(11) NOT NULL,
  `uanfang` date NOT NULL,
  `uende` date NOT NULL,
  `ubeantragt` int(11) NOT NULL,
  `ugesamt` int(11) NOT NULL,
  `ustatus` char(30) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `urlaubsantrag`
--

INSERT INTO `urlaubsantrag` (`uid`, `pid`, `uanfang`, `uende`, `ubeantragt`, `ugesamt`, `ustatus`) VALUES
(32, 108, '2024-05-17', '2024-05-31', 11, 30, 'genehmigt'),
(34, 108, '2024-10-07', '2024-10-11', 4, 30, 'abgelehnt'),
(35, 108, '2024-05-17', '2024-05-31', 11, 30, 'genehmigt'),
(36, 108, '2024-05-17', '2024-05-31', 11, 30, 'abgelehnt'),
(37, 108, '2024-05-17', '2024-05-31', 11, 30, 'genehmigt'),
(38, 108, '2024-05-17', '2024-05-31', 11, 30, 'abgelehnt'),
(43, 110, '2024-05-17', '2024-05-24', 6, 30, 'abgelehnt'),
(44, 110, '2024-05-17', '2024-05-22', 4, 30, 'beantragt'),
(45, 111, '2024-05-16', '2024-05-18', 3, 30, 'beantragt'),
(46, 111, '2024-05-16', '2024-05-18', 3, 30, 'beantragt'),
(47, 112, '2024-05-29', '2024-05-31', 2, 30, 'beantragt');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `krankheit`
--
ALTER TABLE `krankheit`
  ADD PRIMARY KEY (`kid`),
  ADD KEY `pid` (`pid`) USING BTREE;

--
-- Indizes für die Tabelle `personal`
--
ALTER TABLE `personal`
  ADD PRIMARY KEY (`pid`),
  ADD KEY `passwort` (`passwort`) USING BTREE;

--
-- Indizes für die Tabelle `urlaubsantrag`
--
ALTER TABLE `urlaubsantrag`
  ADD PRIMARY KEY (`uid`),
  ADD KEY `pid` (`pid`) USING BTREE;

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `krankheit`
--
ALTER TABLE `krankheit`
  MODIFY `kid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT für Tabelle `personal`
--
ALTER TABLE `personal`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=114;

--
-- AUTO_INCREMENT für Tabelle `urlaubsantrag`
--
ALTER TABLE `urlaubsantrag`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `krankheit`
--
ALTER TABLE `krankheit`
  ADD CONSTRAINT `krankheit_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `personal` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints der Tabelle `urlaubsantrag`
--
ALTER TABLE `urlaubsantrag`
  ADD CONSTRAINT `urlaubsantrag_ibfk_1` FOREIGN KEY (`pid`) REFERENCES `personal` (`pid`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Erstellungszeit: 08. Mai 2024 um 09:18
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
(1, 2, '2024-09-16', '2024-09-27', 10),
(2, 1, '2024-07-25', '2024-08-07', 10);

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
  `urlaubstage` int(11) NOT NULL,
  `resturlaub` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Daten für Tabelle `personal`
--

INSERT INTO `personal` (`pid`, `vorname`, `nachname`, `passwort`, `status`, `urlaubstage`, `resturlaub`) VALUES
(1, 'Max', 'Mustermann', 'likeaboss', 'Personalleiter', 30, 25),
(2, 'Jesus', 'Christus', 'DasGebet', 'Admin', 30, 30),
(6, 'Leon', 'Bauer', 'internetkuh', 'Angestellter', 30, 28),
(7, 'Mohammed', 'Ali', 'wallahbrudah', 'Angestellter', 30, 14),
(8, 'Son', 'Goku', 'kamehameha', 'Angestellter', 30, 21),
(9, 'Bobby', 'Rogers', 'americaisgreat', 'Angestellter', 30, 21),
(10, 'Leonardo', 'Diekabrio', 'ichbinderechte', 'Angestellter', 30, 17);

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
(15, 7, '2024-02-12', '2024-02-23', 10, 30, 'genehmigt'),
(18, 7, '2024-06-14', '2024-06-21', 6, 30, 'genehmigt'),
(19, 6, '2024-05-13', '2024-05-14', 2, 30, 'genehmigt'),
(20, 1, '2024-08-01', '2024-08-16', 12, 30, 'beantragt'),
(21, 2, '2024-09-02', '2024-09-20', 15, 30, 'beantragt'),
(22, 10, '2024-10-14', '2024-10-18', 5, 30, 'abgelehnt');

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
  MODIFY `kid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT für Tabelle `personal`
--
ALTER TABLE `personal`
  MODIFY `pid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=102;

--
-- AUTO_INCREMENT für Tabelle `urlaubsantrag`
--
ALTER TABLE `urlaubsantrag`
  MODIFY `uid` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

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

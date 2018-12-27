-- phpMyAdmin SQL Dump
-- version 4.7.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Dic 24, 2018 alle 12:43
-- Versione del server: 10.1.28-MariaDB
-- Versione PHP: 7.1.11

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mymvc`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `usr_users`
--

CREATE TABLE `usr_users` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` int(11) UNSIGNED NOT NULL,
  `user_email` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `user_password` text COLLATE utf8_unicode_ci NOT NULL,
  `user_status` tinyint(1) UNSIGNED DEFAULT NULL,
  `user_approved` tinyint(1) UNSIGNED DEFAULT NULL,
  `remember_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `activation_code` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `last_ip` varchar(40) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `user_created` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dump dei dati per la tabella `usr_users`
--

INSERT INTO `usr_users` (`user_id`, `group_id`, `user_email`, `user_password`, `user_status`, `user_approved`, `remember_code`, `activation_code`, `last_ip`, `last_login`, `user_created`) VALUES
(1, 1, 'info@mytest.it', '356a192b7913b04c54574d18c28d46e6395428ab37431af0b25654ca21ddbd5b3fd3961ba4876f274d3fe51b5da4866eaab3501d30a410a65125ec208ea0978455d977fca8a615a7e968eaa0ced595692d9f16d3', 1, 1, '59eb9163ed92bf1d32a14d7d0831c326f7837e59', '', '127.0.0.1', '2018-12-22 09:58:46', '0000-00-00 00:00:00');

-- --------------------------------------------------------

--
-- Struttura della tabella `usr_user_groups`
--

CREATE TABLE `usr_user_groups` (
  `group_id` int(11) UNSIGNED NOT NULL,
  `group_name` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `group_description` varchar(100) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dump dei dati per la tabella `usr_user_groups`
--

INSERT INTO `usr_user_groups` (`group_id`, `group_name`, `group_description`) VALUES
(1, 'admin', 'Super Administrator'),
(2, 'grp1', 'Gruppo 1'),
(3, 'grp2', 'Gruppo 2'),
(4, 'gruppo 3', 'ciao');

-- --------------------------------------------------------

--
-- Struttura della tabella `usr_user_profiles`
--

CREATE TABLE `usr_user_profiles` (
  `profile_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `ragione_sociale` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `nome` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cognome` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `indirizzo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `citta` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cap` varchar(5) COLLATE utf8_unicode_ci DEFAULT NULL,
  `provincia` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `paese` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `telefono` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `cellulare` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `data_nascita` date DEFAULT NULL,
  `codice_fiscale` varchar(250) COLLATE utf8_unicode_ci DEFAULT NULL,
  `partita_iva` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=DYNAMIC;

--
-- Dump dei dati per la tabella `usr_user_profiles`
--

INSERT INTO `usr_user_profiles` (`profile_id`, `user_id`, `ragione_sociale`, `nome`, `cognome`, `indirizzo`, `citta`, `cap`, `provincia`, `paese`, `telefono`, `cellulare`, `data_nascita`, `codice_fiscale`, `partita_iva`) VALUES
(1, 1, 'Ragione sociale', 'Nome', 'Cognome', NULL, NULL, NULL, NULL, '', NULL, NULL, NULL, '', NULL);

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `usr_users`
--
ALTER TABLE `usr_users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`);

--
-- Indici per le tabelle `usr_user_groups`
--
ALTER TABLE `usr_user_groups`
  ADD PRIMARY KEY (`group_id`);

--
-- Indici per le tabelle `usr_user_profiles`
--
ALTER TABLE `usr_user_profiles`
  ADD PRIMARY KEY (`profile_id`),
  ADD KEY `user_id` (`user_id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `usr_users`
--
ALTER TABLE `usr_users`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT per la tabella `usr_user_groups`
--
ALTER TABLE `usr_user_groups`
  MODIFY `group_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT per la tabella `usr_user_profiles`
--
ALTER TABLE `usr_user_profiles`
  MODIFY `profile_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `usr_user_profiles`
--
ALTER TABLE `usr_user_profiles`
  ADD CONSTRAINT `usr_user_profiles_usr_users_fk` FOREIGN KEY (`user_id`) REFERENCES `usr_users` (`user_id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

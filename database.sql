-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Set 28, 2024 alle 11:00
-- Versione del server: 10.4.25-MariaDB
-- Versione PHP: 7.4.30
SET
    SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

START TRANSACTION;

SET
    time_zone = "+00:00";

--
-- Database: `my_pixelbook`
--
-- --------------------------------------------------------
--
-- Struttura della tabella `categorie`
--
CREATE TABLE `categorie` (
    `id` int(11) NOT NULL,
    `nome` varchar(255) DEFAULT NULL,
    `descrizione` text DEFAULT NULL,
    `banner` varchar(255) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Dump dei dati per la tabella `categorie`
--
INSERT INTO
    `categorie` (`id`, `nome`, `descrizione`, `banner`)
VALUES
    (
        1,
        'asd',
        'asd',
        'Screenshot 2024-05-07 085445.png'
    ),
    (
        3,
        'Test',
        'asd',
        'Screenshot 2024-07-17 152221.png'
    ),
    (
        4,
        'Test',
        'asd',
        'Screenshot 2024-07-17 152221.png'
    ),
    (
        5,
        'Test',
        'asd',
        'Screenshot 2024-07-17 152221.png'
    ),
    (
        6,
        'Test',
        'asd',
        'Screenshot 2024-07-17 152221.png'
    ),
    (
        7,
        'Test',
        'asd',
        'Screenshot 2024-07-17 152221.png'
    ),
    (
        8,
        'Test',
        'asd',
        'Screenshot 2024-07-17 152221.png'
    ),
    (
        9,
        'Test',
        'asd',
        'Screenshot 2024-07-17 152221.png'
    );

-- --------------------------------------------------------
--
-- Struttura della tabella `galleria`
--
CREATE TABLE `galleria` (
    `id` int(11) NOT NULL,
    `categoria_id` int(11) DEFAULT NULL,
    `file` varchar(255) DEFAULT NULL,
    `descrizione` text DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Dump dei dati per la tabella `galleria`
--
INSERT INTO
    `galleria` (`id`, `categoria_id`, `file`, `descrizione`)
VALUES
    (1, 1, 'Screenshot 2024-05-14 114329.png', 'ds'),
    (2, 1, 'Screenshot 2024-05-31 144922.png', 'd');

-- --------------------------------------------------------
--
-- Struttura della tabella `prenotazioni`
--
CREATE TABLE `prenotazioni` (
    `id` int(11) NOT NULL,
    `nome` varchar(255) DEFAULT NULL,
    `email` varchar(255) DEFAULT NULL,
    `telefono` varchar(255) DEFAULT NULL,
    `data_prenotazione` date DEFAULT NULL,
    `categoria_id` int(11) DEFAULT NULL
) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4;

--
-- Indici per le tabelle scaricate
--
--
-- Indici per le tabelle `categorie`
--
ALTER TABLE
    `categorie`
ADD
    PRIMARY KEY (`id`);

--
-- Indici per le tabelle `galleria`
--
ALTER TABLE
    `galleria`
ADD
    PRIMARY KEY (`id`),
ADD
    KEY `categoria_id` (`categoria_id`);

--
-- Indici per le tabelle `prenotazioni`
--
ALTER TABLE
    `prenotazioni`
ADD
    PRIMARY KEY (`id`),
ADD
    KEY `categoria_id` (`categoria_id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--
--
-- AUTO_INCREMENT per la tabella `categorie`
--
ALTER TABLE
    `categorie`
MODIFY
    `id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 10;

--
-- AUTO_INCREMENT per la tabella `galleria`
--
ALTER TABLE
    `galleria`
MODIFY
    `id` int(11) NOT NULL AUTO_INCREMENT,
    AUTO_INCREMENT = 3;

--
-- AUTO_INCREMENT per la tabella `prenotazioni`
--
ALTER TABLE
    `prenotazioni`
MODIFY
    `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Limiti per le tabelle scaricate
--
--
-- Limiti per la tabella `galleria`
--
ALTER TABLE
    `galleria`
ADD
    CONSTRAINT `galleria_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorie` (`id`);

--
-- Limiti per la tabella `prenotazioni`
--
ALTER TABLE
    `prenotazioni`
ADD
    CONSTRAINT `prenotazioni_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categorie` (`id`);

COMMIT;
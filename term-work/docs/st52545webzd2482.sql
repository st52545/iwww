-- phpMyAdmin SQL Dump
-- version 4.3.12
-- http://www.phpmyadmin.net
--
-- Počítač: 185.64.219.6:3306
-- Vytvořeno: Ned 03. úno 2019, 16:49
-- Verze serveru: 5.5.37-MariaDB
-- Verze PHP: 5.6.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Databáze: `st52545webzd2482`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `autori`
--

CREATE TABLE IF NOT EXISTS `autori` (
  `id` int(11) NOT NULL,
  `jmeno` varchar(40) NOT NULL,
  `prijmeni` varchar(40) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `autori`
--

INSERT INTO `autori` (`id`, `jmeno`, `prijmeni`) VALUES
(1, 'Karel', 'Čapek'),
(2, 'Božena', 'Němcová'),
(6, 'K. J.', 'Erben'),
(7, 'Václav', 'Havel'),
(8, 'Ernest', 'Hemingway'),
(9, 'Antoine de Saint', 'Exupéry');

-- --------------------------------------------------------

--
-- Struktura tabulky `knihy`
--

CREATE TABLE IF NOT EXISTS `knihy` (
  `id` int(11) NOT NULL,
  `autor_id` int(11) NOT NULL,
  `nazev` varchar(40) NOT NULL,
  `zanr` varchar(30) NOT NULL,
  `popis` varchar(400) DEFAULT NULL,
  `skladem` int(11) NOT NULL,
  `pocetKs` int(11) NOT NULL,
  `rokVydani` int(11) DEFAULT NULL,
  `disabled` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `knihy`
--

INSERT INTO `knihy` (`id`, `autor_id`, `nazev`, `zanr`, `popis`, `skladem`, `pocetKs`, `rokVydani`, `disabled`) VALUES
(6, 1, 'R.U.R.', 'Speculation fiction', 'Autor zde varuje před případnými negativními vlivy techniky na lidstvo. Je ovlivněn svým zájmem o techniku, ale také obavami o budoucnost lidstva. V této hře poprvé zaznělo slovo robot, které na Karlovu výzvu navrhl jeho bratr Josef.', 5, 5, 1921, 0),
(7, 1, 'Bílá nemoc', 'Drama', 'Dílo varuje před nastupujícím fašismem. Jde o jedno z děl varujících před nástupem nacismu v Německu a stalo se posléze i jedním z důvodů plánované autorovy perzekuce gestapem.', 1, 1, 1937, 0),
(8, 2, 'Babička', 'Fiction', 'Kniha má podobu idealizovaného vzpomínání na dětství v Ratibořickém údolí, popisuje lidové zvyky, vesnický způsob života a obyčejné i výjimečné události, přičemž jednotlivé epizody spojuje postava babičky, laskavé, moudré a zbožné ženy, které si váží všichni v okolí.', 1, 2, 1855, 0),
(16, 9, 'Malý princ', 'Dětská literatura', '0', 3, 3, 1943, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `pujcky`
--

CREATE TABLE IF NOT EXISTS `pujcky` (
  `id` int(11) NOT NULL,
  `datumVypujceni` date NOT NULL,
  `datumVraceni` date DEFAULT NULL,
  `prodlouzeno` int(11) NOT NULL,
  `vraceno` int(11) NOT NULL,
  `sankce` int(11) NOT NULL,
  `kniha_id` int(11) NOT NULL,
  `uzivatel_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=91 DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `pujcky`
--

INSERT INTO `pujcky` (`id`, `datumVypujceni`, `datumVraceni`, `prodlouzeno`, `vraceno`, `sankce`, `kniha_id`, `uzivatel_id`) VALUES
(70, '2019-01-30', '2019-05-05', 1, 1, 0, 7, 1),
(71, '2018-12-30', '2019-01-30', 1, 1, 30, 6, 1),
(78, '2019-02-01', '2019-01-28', 1, 1, 60, 8, 1),
(79, '2019-02-02', '2019-03-08', 0, 1, 0, 8, 1),
(80, '2019-02-02', '2019-03-08', 0, 1, 0, 8, 1),
(81, '2019-02-02', '2019-03-08', 0, 1, 0, 8, 10),
(82, '2019-02-02', '2019-03-08', 0, 1, 0, 8, 10),
(83, '2019-02-02', '2019-04-08', 1, 1, 0, 7, 1),
(84, '2019-02-02', '2019-04-08', 1, 1, 0, 7, 10),
(85, '2019-02-02', '2019-04-08', 1, 1, 0, 7, 1),
(86, '2019-02-02', '2019-04-08', 1, 1, 0, 7, 10),
(87, '2019-02-02', '2019-04-08', 1, 1, 0, 7, 1),
(88, '2019-02-02', '2019-03-08', 0, 1, 0, 8, 10),
(89, '2019-02-02', '2019-04-08', 1, 1, 0, 7, 1),
(90, '2019-02-03', '2019-04-09', 1, 0, 0, 8, 16);

-- --------------------------------------------------------

--
-- Struktura tabulky `recenze`
--

CREATE TABLE IF NOT EXISTS `recenze` (
  `id` int(11) NOT NULL,
  `hodnoceni` int(2) NOT NULL,
  `text` varchar(500) DEFAULT NULL,
  `uzivatel_id` int(11) NOT NULL,
  `kniha_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `recenze`
--

INSERT INTO `recenze` (`id`, `hodnoceni`, `text`, `uzivatel_id`, `kniha_id`) VALUES
(15, 10, NULL, 1, 8),
(23, 6, NULL, 10, 8),
(24, 7, NULL, 10, 7),
(25, 8, NULL, 10, 6),
(26, 5, NULL, 1, 7),
(27, 8, NULL, 1, 6);

-- --------------------------------------------------------

--
-- Struktura tabulky `rezervace`
--

CREATE TABLE IF NOT EXISTS `rezervace` (
  `id` int(11) NOT NULL,
  `uzivatel_id` int(11) NOT NULL,
  `kniha_id` int(11) NOT NULL,
  `datumRezervace` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=181 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatele`
--

CREATE TABLE IF NOT EXISTS `uzivatele` (
  `id` int(11) NOT NULL,
  `role` varchar(20) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `datumRegistrace` date NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `uzivatele`
--

INSERT INTO `uzivatele` (`id`, `role`, `username`, `email`, `password`, `datumRegistrace`) VALUES
(1, 'admin', 'admin', 'admin@admin.cz', '21232f297a57a5a743894a0e4a801fc3', '2019-01-02'),
(2, 'spravce', 'spravce', 'spravce@spravce.cz', '192a2929e714275bee587d280d596eeb', '2019-01-02'),
(10, 'zakaznik', 'jparizek1', 'parizek14@gmail.com', '955db0b81ef1989b4a4dfeae8061a9a6', '2019-01-17'),
(16, 'zakaznik', 'lorent', 'l@l', 'fa2bfd96894bdc50698c997f78dc93bd', '2019-02-03');

-- --------------------------------------------------------

--
-- Struktura tabulky `zpravy`
--

CREATE TABLE IF NOT EXISTS `zpravy` (
  `id` int(11) NOT NULL,
  `zprava` varchar(500) NOT NULL,
  `datum` date NOT NULL,
  `precteno` int(11) NOT NULL,
  `odesilatel_id` int(11) NOT NULL,
  `adresat_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=24 DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `zpravy`
--

INSERT INTO `zpravy` (`id`, `zprava`, `datum`, `precteno`, `odesilatel_id`, `adresat_id`) VALUES
(1, 'čau', '2019-02-01', 1, 2, 1),
(3, 'asdadsasd', '2019-01-31', 1, 2, 1),
(4, 'test', '2019-02-01', 1, 1, 2),
(5, 'zprava', '2019-02-01', 1, 2, 1),
(6, 'zzzzzzz', '2019-02-01', 1, 10, 1),
(7, 'zzzzzzz', '2019-02-01', 0, 10, 2),
(8, 'zzzfff', '2019-02-01', 0, 1, 2),
(9, 'zzzzaaa', '2019-02-01', 0, 1, 2),
(10, 'aaa', '2019-02-01', 0, 1, 1),
(11, 'aaa', '2019-02-01', 1, 1, 1),
(15, 'Vámi rezervovaná kniha Babička vám byla propůjčena ', '2019-02-02', 1, 2, 1),
(16, 'Vámi rezervovaná kniha Bílá nemoc vám byla propůjčena ', '2019-02-02', 1, 1, 10),
(17, 'Vámi rezervovaná kniha Babička vám byla propůjčena ', '2019-02-02', 0, 1, 10),
(18, 'Vámi rezervovaná kniha Bílá nemoc vám byla propůjčena ', '2019-02-02', 0, 1, 1),
(19, 'asd', '2019-02-03', 0, 10, 1),
(20, 'asd', '2019-02-03', 0, 10, 2),
(21, 'ahoj', '2019-02-03', 0, 1, 10),
(22, 'Hi elwen\r\n', '2019-02-03', 0, 16, 1),
(23, 'Hi elwen\r\n', '2019-02-03', 0, 16, 2);

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `autori`
--
ALTER TABLE `autori`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `knihy`
--
ALTER TABLE `knihy`
  ADD PRIMARY KEY (`id`), ADD KEY `autor_id` (`autor_id`);

--
-- Klíče pro tabulku `pujcky`
--
ALTER TABLE `pujcky`
  ADD PRIMARY KEY (`id`), ADD KEY `kniha_id` (`kniha_id`,`uzivatel_id`), ADD KEY `pujcky_uzivatel` (`uzivatel_id`);

--
-- Klíče pro tabulku `recenze`
--
ALTER TABLE `recenze`
  ADD PRIMARY KEY (`id`), ADD KEY `uzivatel_id` (`uzivatel_id`,`kniha_id`), ADD KEY `hodnoceni_kniha` (`kniha_id`);

--
-- Klíče pro tabulku `rezervace`
--
ALTER TABLE `rezervace`
  ADD PRIMARY KEY (`id`), ADD KEY `uzivatel_id` (`uzivatel_id`), ADD KEY `kniha_id` (`kniha_id`);

--
-- Klíče pro tabulku `uzivatele`
--
ALTER TABLE `uzivatele`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `zpravy`
--
ALTER TABLE `zpravy`
  ADD PRIMARY KEY (`id`), ADD KEY `odesilatel_id` (`odesilatel_id`,`adresat_id`), ADD KEY `adresat_zprava` (`adresat_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `autori`
--
ALTER TABLE `autori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pro tabulku `knihy`
--
ALTER TABLE `knihy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pro tabulku `pujcky`
--
ALTER TABLE `pujcky`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=91;
--
-- AUTO_INCREMENT pro tabulku `recenze`
--
ALTER TABLE `recenze`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=28;
--
-- AUTO_INCREMENT pro tabulku `rezervace`
--
ALTER TABLE `rezervace`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=181;
--
-- AUTO_INCREMENT pro tabulku `uzivatele`
--
ALTER TABLE `uzivatele`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT pro tabulku `zpravy`
--
ALTER TABLE `zpravy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=24;
--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `knihy`
--
ALTER TABLE `knihy`
ADD CONSTRAINT `knihy_autor` FOREIGN KEY (`autor_id`) REFERENCES `autori` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `pujcky`
--
ALTER TABLE `pujcky`
ADD CONSTRAINT `pujcky_kniha` FOREIGN KEY (`kniha_id`) REFERENCES `knihy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `pujcky_uzivatel` FOREIGN KEY (`uzivatel_id`) REFERENCES `uzivatele` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `recenze`
--
ALTER TABLE `recenze`
ADD CONSTRAINT `hodnoceni_kniha` FOREIGN KEY (`kniha_id`) REFERENCES `knihy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `hodnoceni_uzivatel` FOREIGN KEY (`uzivatel_id`) REFERENCES `uzivatele` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `rezervace`
--
ALTER TABLE `rezervace`
ADD CONSTRAINT `rezervace_kniha` FOREIGN KEY (`kniha_id`) REFERENCES `knihy` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `rezervace_uzivatel` FOREIGN KEY (`uzivatel_id`) REFERENCES `uzivatele` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Omezení pro tabulku `zpravy`
--
ALTER TABLE `zpravy`
ADD CONSTRAINT `adresat_zprava` FOREIGN KEY (`adresat_id`) REFERENCES `uzivatele` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
ADD CONSTRAINT `odesilatel_zprava` FOREIGN KEY (`odesilatel_id`) REFERENCES `uzivatele` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

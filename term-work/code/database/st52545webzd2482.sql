-- phpMyAdmin SQL Dump
-- version 4.3.12
-- http://www.phpmyadmin.net
--
-- Počítač: 185.64.219.6:3306
-- Vytvořeno: Čtv 17. led 2019, 15:49
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
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `autori`
--

INSERT INTO `autori` (`id`, `jmeno`, `prijmeni`) VALUES
(1, 'Karel', 'Čapek'),
(2, 'Božena', 'Němcová');

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
  `rokVydani` int(11) DEFAULT NULL,
  `dostupnost` int(1) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `knihy`
--

INSERT INTO `knihy` (`id`, `autor_id`, `nazev`, `zanr`, `popis`, `rokVydani`, `dostupnost`) VALUES
(6, 1, 'R.U.R.', 'Spekulativní fikce', 'Autor zde varuje před případnými negativními vlivy techniky na lidstvo. Je ovlivněn svým zájmem o techniku, ale také obavami o budoucnost lidstva. V této hře poprvé zaznělo slovo robot, které na Karlovu výzvu navrhl jeho bratr Josef.', 1921, 1),
(7, 1, 'Bílá nemoc', 'Drama', 'Dílo varuje před nastupujícím fašismem. Jde o jedno z děl varujících před nástupem nacismu v Německu a stalo se posléze i jedním z důvodů plánované autorovy perzekuce gestapem.', 1937, 1),
(8, 2, 'Babička', 'Fikce', 'Kniha má podobu idealizovaného vzpomínání na dětství v Ratibořickém údolí, popisuje lidové zvyky, vesnický způsob života a obyčejné i výjimečné události, přičemž jednotlivé epizody spojuje postava babičky, laskavé, moudré a zbožné ženy, které si váží všichni v okolí.', 1855, 1);

-- --------------------------------------------------------

--
-- Struktura tabulky `pujcky`
--

CREATE TABLE IF NOT EXISTS `pujcky` (
  `id` int(11) NOT NULL,
  `datumVypujceni` date NOT NULL,
  `datumVraceni` date DEFAULT NULL,
  `kniha_id` int(11) NOT NULL,
  `uzivatel_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `recenze`
--

CREATE TABLE IF NOT EXISTS `recenze` (
  `id` int(11) NOT NULL,
  `hodnoceni` int(11) DEFAULT NULL,
  `text` varchar(500) DEFAULT NULL,
  `uzivatel_id` int(11) NOT NULL,
  `kniha_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Struktura tabulky `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL,
  `nazev` varchar(20) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `role`
--

INSERT INTO `role` (`id`, `nazev`) VALUES
(1, 'admin'),
(2, 'spravce'),
(3, 'zakaznik');

-- --------------------------------------------------------

--
-- Struktura tabulky `uzivatele`
--

CREATE TABLE IF NOT EXISTS `uzivatele` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(32) NOT NULL,
  `datumRegistrace` date NOT NULL,
  `role_id` int(11) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `uzivatele`
--

INSERT INTO `uzivatele` (`id`, `username`, `email`, `password`, `datumRegistrace`, `role_id`) VALUES
(4, 'admin', 'admin@admin.cz', '21232f297a57a5a743894a0e4a801fc3', '2019-01-02', 1),
(5, 'spravce', 'spravce@spravce.cz', '192a2929e714275bee587d280d596eeb', '2019-01-02', 2),
(6, 'zakaznik', 'zakaznik@zakaznik.cz', '85d59187e77365b2b77f309fdc57c8fc', '2019-01-02', 3),
(9, 'test', 'test@test.cz', '098f6bcd4621d373cade4e832627b4f6', '2019-01-17', 3),
(10, 'jparizek', 'parizek14@gmail.com', '955db0b81ef1989b4a4dfeae8061a9a6', '2019-01-17', 3);

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
-- Klíče pro tabulku `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `uzivatele`
--
ALTER TABLE `uzivatele`
  ADD PRIMARY KEY (`id`), ADD KEY `uzivatel_role` (`role_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `autori`
--
ALTER TABLE `autori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pro tabulku `knihy`
--
ALTER TABLE `knihy`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT pro tabulku `pujcky`
--
ALTER TABLE `pujcky`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pro tabulku `recenze`
--
ALTER TABLE `recenze`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pro tabulku `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pro tabulku `uzivatele`
--
ALTER TABLE `uzivatele`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=11;
--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `knihy`
--
ALTER TABLE `knihy`
ADD CONSTRAINT `knihy_autor` FOREIGN KEY (`autor_id`) REFERENCES `autori` (`id`);

--
-- Omezení pro tabulku `pujcky`
--
ALTER TABLE `pujcky`
ADD CONSTRAINT `pujcky_kniha` FOREIGN KEY (`kniha_id`) REFERENCES `knihy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `pujcky_uzivatel` FOREIGN KEY (`uzivatel_id`) REFERENCES `uzivatele` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `recenze`
--
ALTER TABLE `recenze`
ADD CONSTRAINT `hodnoceni_kniha` FOREIGN KEY (`kniha_id`) REFERENCES `knihy` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
ADD CONSTRAINT `hodnoceni_uzivatel` FOREIGN KEY (`uzivatel_id`) REFERENCES `uzivatele` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Omezení pro tabulku `uzivatele`
--
ALTER TABLE `uzivatele`
ADD CONSTRAINT `uzivatel_role` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;

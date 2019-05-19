-- Zweck: Webshop - PHP
-- Autor: DEHL
-- Datum: 2019-04-06

DROP DATABASE IF EXISTS webshop;
CREATE DATABASE webshop;
USE webshop;

DROP TABLE IF EXISTS user;
CREATE TABLE user (
       uname         VARCHAR(100),
       vname         VARCHAR(100),
       nname         VARCHAR(100),
       email         VARCHAR(100),
       password      VARCHAR(100),
       admin         BOOLEAN,
       PRIMARY KEY (uname)
) ENGINE=INNODB;

DROP TABLE IF EXISTS artikel;
CREATE TABLE artikel (
       abez             VARCHAR(100),
       abes             VARCHAR(100),
       preis            DECIMAL(6,2),
       verfuegbar       BOOLEAN,
       anzVer           INTEGER,
       pathPic          VARCHAR(100),
       PRIMARY KEY (abez, preis)
) ENGINE=INNODB;

DROP TABLE IF EXISTS auswahl;
CREATE TABLE auswahl (
       id               INTEGER,
       user             VARCHAR(100),
       abez             VARCHAR(100),
       aanz             INTEGER,
       preis            DECIMAL(6,2),
       preisG           DECIMAL(6,2),
       PRIMARY KEY (id, user),
       FOREIGN KEY (user) REFERENCES user(uname) ON UPDATE CASCADE ON DELETE CASCADE ,
       FOREIGN KEY (abez, preis) REFERENCES artikel(abez, preis) ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=INNODB;

CREATE USER 'brec'@'localhost' IDENTIFIED BY 'blabla';
GRANT ALL ON webshop.* TO 'brec'@'localhost';




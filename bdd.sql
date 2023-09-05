CREATE DATABASE IF NOT EXISTS trt_conseil CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- CREATION DES TABLES --

CREATE TABLE administrateurs (
    Id_Administrateur INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    Nom VARCHAR(60) NOT NULL,
    Prenom VARCHAR(60) NOT NULL,
    Email VARCHAR(255) UNIQUE NOT NULL,
    Mot_De_Passe VARCHAR(60) NOT NULL,
    Salt VARCHAR(60) NOT NULL,
    Statut VARCHAR(60) NOT NULL
) ENGINE=INNODB;

CREATE TABLE consultants (
    Id_Consultant INTEGER PRIMARY KEY AUTO_INCREMENT NOT NULL,
    Nom VARCHAR(60) NOT NULL,
    Prenom VARCHAR(60) NOT NULL,
    Email VARCHAR(255) UNIQUE NOT NULL,
    Mot_De_Passe VARCHAR(60) NOT NULL,
    Salt VARCHAR(60) NOT NULL,
    Id_Administrateur INTEGER NOT NULL,
    FOREIGN KEY (Id_Administrateur) REFERENCES administrateurs(Id_Administrateur)
) ENGINE=INNODB;


/************************************************
*    Auteur : BELLO Noah
*    Date du projet : 16/03/2023 - 25/03/2023
*    Nom du fichier : creationbdd.sql
************************************************/

CREATE DATABASE Historique; -- Permet de créer la base de donnée

-- Permet de créer un utilisateur de type administrateur avec certains droits (pas tous les droits)
CREATE USER "historique1adm" @"%" IDENTIFIED BY "historique1adm";

GRANT
SELECT
,
INSERT
,
UPDATE
,
    DELETE,
    CREATE,
    DROP,
    INDEX,
    ALTER ON `historique`.* TO "historique1adm" @"%";

-- Permet de créer un utilisateur de type utilisateur avec certains droits (pas tous les droits)
CREATE USER "historique1usr" @"%" IDENTIFIED BY "historique1usr";

GRANT
SELECT
,
INSERT
,
UPDATE
,
    DELETE,
    CREATE,
    DROP,
    INDEX,
    ALTER ON `historique`.* TO "historique1usr" @"%";

FLUSH PRIVILEGES; 

-- Permet d'utiliser la base de donnée pour ensuite l'utiliser
USE historique;

-- Permet de créer une table dans la base de donnée
CREATE TABLE IF NOT EXISTS historique(

    id_historique INT UNSIGNED NOT NULL AUTO_INCREMENT, -- Colonne de numéro pour chaque calcul
    date_heure_calcul DATETIME, -- Colonne qui contient la date et l'heure
    calcul VARCHAR(255), -- Colonne qui contient le calcul
    resultat VARCHAR(255), -- Colonne qui contient le résultat
    PRIMARY KEY(id_historique) -- La colonne de numéro pour chaque calcul est une clé primaire
    
);
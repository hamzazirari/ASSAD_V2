-- CREATION DE DATA BASE

CREATE DATABASE ASSAD;
USE ASSAD;


-- creation des tableaux


CREATE TABLE habitats (
id_hab INT AUTO_INCREMENT PRIMARY KEY, 
nom_hab VARCHAR(100) NOT NULL ,              
typeclimat VARCHAR(100) NOT NULL, 
description VARCHAR(300), 
zonezoo VARCHAR(100)
);

CREATE TABLE animaux (
    id_animal INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL,
    espece VARCHAR(100),
    alimentation VARCHAR(100),
    image VARCHAR(255),
    paysorigine VARCHAR(50),
    descriptioncourte TEXT,
    id_habitat INT,
    FOREIGN KEY (id_habitat) REFERENCES habitats(id)
);






CREATE TABLE utilisateurs (
    id_utilisateur INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(50) NOT NULL, 
    email VARCHAR(150) NOT NULL, 
    role VARCHAR(50) NOT NULL, 
    motpasse_hash VARCHAR(150) NOT NULL
);



CREATE TABLE visitesguidees (
    id_visite INT AUTO_INCREMENT PRIMARY KEY,
    titre VARCHAR(100) NOT NULL,
    dateheure DATETIME NOT NULL,
    langue VARCHAR(30),
    capacite_max INT NOT NULL,
    statut VARCHAR(20),
    duree INT NOT NULL,    
    prix FLOAT NOT NULL
);




CREATE TABLE etapesvisite (
    id_etape INT AUTO_INCREMENT PRIMARY KEY,
    titreetape VARCHAR(100) NOT NULL,
    descriptionetape VARCHAR(200),
    ordreetape INT,
    id_visite INT,
    FOREIGN KEY (id_visite) REFERENCES visitesguidees(id_visite)
);




CREATE TABLE reservations (
id INT AUTO_INCREMENT PRIMARY KEY, 
idvisite_reservation INT, 
idutilisateur_reservation INT, 
nbpersonnes INT, 
datereservation DATETIME,
FOREIGN KEY (idvisite_reservation) REFERENCES visitesguidees(id_visite),
FOREIGN KEY (idutilisateur_reservation) REFERENCES utilisateurs(id_utilisateur)
);


-- INSERTION

INSERT INTO utilisateurs() VALUES()
CREATE TABLE Niveaux (
    id INT PRIMARY KEY,
    nom VARCHAR(100)
);

CREATE TABLE Cours (
    id VARCHAR(50) PRIMARY KEY,
    nom VARCHAR(100)
);

CREATE TABLE Salles (
    id VARCHAR(50) PRIMARY KEY,
    nom VARCHAR(100)
);

CREATE TABLE Personnes (
    id VARCHAR(50) PRIMARY KEY,
    nom VARCHAR(50),
    prenom VARCHAR(50),
    tel INT,
    mail VARCHAR(50),
    dateInscription DATE
);

CREATE TABLE Etudiants (
    id VARCHAR(50) PRIMARY KEY,
    niveauId INT,
    FOREIGN KEY (niveauId) REFERENCES Niveaux(id),
    FOREIGN KEY (id) REFERENCES Personnes(id)
);

CREATE TABLE Professeurs (
    id VARCHAR(50) PRIMARY KEY,
    metier VARCHAR(50),
    FOREIGN KEY (id) REFERENCES Personnes(id)
);

CREATE TABLE Groupes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255),
    coursId VARCHAR(50),
    professeurId VARCHAR(50),
    FOREIGN KEY (coursId) REFERENCES Cours(id),
    FOREIGN KEY (professeurId) REFERENCES Professeurs(id)
);

CREATE TABLE Paiements (
    etudiantId VARCHAR(50),
    coursId VARCHAR(50),
    montant FLOAT,
    datePaiement DATE,
    PRIMARY KEY (etudiantId, coursId),
    FOREIGN KEY (etudiantId) REFERENCES Etudiants(id),
    FOREIGN KEY (coursId) REFERENCES Cours(id)
);

CREATE TABLE GroupesEtudiants (
    groupeId INT,
    etudiantId VARCHAR(50),
    FOREIGN KEY (groupeId) REFERENCES Groupes(id),
    FOREIGN KEY (etudiantId) REFERENCES Etudiants(id)
);

CREATE TABLE reservations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    salleId VARCHAR(50),
    jour VARCHAR(20),
    groupeId INT,
    heure INT,
    FOREIGN KEY (groupeId) REFERENCES Groupes(id),
    FOREIGN KEY (salleId) REFERENCES Salles(id)
);

CREATE TABLE Formations (
    id VARCHAR(50) PRIMARY KEY,
    prix FLOAT,
    FOREIGN KEY (id) REFERENCES Cours(id)
);

CREATE TABLE Matieres (
    id VARCHAR(50) PRIMARY KEY,
    niveauId INT,
    prix FLOAT,
    FOREIGN KEY (id) REFERENCES Cours(id),
    FOREIGN KEY (niveauId) REFERENCES Niveaux(id)
);


INSERT INTO Niveaux (id, nom)
VALUES
    (1, 'First year (elementary)'),
    (2, 'Second year (elementary)'),
    (3, 'Third year (elementary)'),
    (4, 'Fourth year (elementary)'),
    (5, 'Fifth year (elementary)'),
    (6, 'Sixth year (elementary)'),
    (7, 'First year (middle school)'),
    (8, 'Second year (middle school)'),
    (9, 'Third year (middle school)'),
    (10, 'Fifth year (high school)'),
    (11, 'First year of Bac (high school)'),
    (12, 'Second year of Bac (high school)'),
    (13, 'Other');

INSERT INTO Salles (id, nom)
VALUES
    ('1', 'Small room 1'),
    ('2', 'Small room 2'),
    ('3', 'Large room'),
    ('4', 'TP room');

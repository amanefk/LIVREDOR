ALTER TABLE Signatures ADD COLUMN Sexe ENUM('Homme', 'Femme', 'Autre') DEFAULT 'Autre';
ALTER TABLE Signatures ADD COLUMN Email VARCHAR(150);

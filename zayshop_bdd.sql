# Create schemas

# Create tables
CREATE TABLE IF NOT EXISTS Produit
(
    id INT NOT NULL AUTO_INCREMENT,
    Nom VARCHAR(100),
    Description VARCHAR(500),
    Marque VARCHAR(100),
    Prix FLOAT(2),
    Couleur VARCHAR(100),
    Specification VARCHAR(100),
    idTaille INT,
    idCategorie INT,
    PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Avis
(
    id INT NOT NULL AUTO_INCREMENT,
    Note INT,
    Commentaire VARCHAR(100),
    idUser INT,
    idProduit INT,
    PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Taille
(
    id INT NOT NULL AUTO_INCREMENT,
    libelle VARCHAR(100),
    PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Image
(
    id INT NOT NULL AUTO_INCREMENT,
    Nom VARCHAR(100),
    URL VARCHAR(100),
    PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS ImageProduit
(
    id INT NOT NULL,
    idProduit INT,
    idImage INT,
    PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Genre
(
    id INT NOT NULL AUTO_INCREMENT,
    Genre VARCHAR(100),
    idProduit INT,
    PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Categorie
(
    id INT NOT NULL AUTO_INCREMENT,
    Nom VARCHAR(100),
    PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Users
(
    id INT NOT NULL AUTO_INCREMENT,
    Nom VARCHAR(100),
    Prenom VARCHAR(100),
    Telephone VARCHAR(10),
    Email VARCHAR(100),
    Mdp VARCHAR(100),
    Adresse VARCHAR(100),
    Complementadresse VARCHAR(100),
    Codepostal INT,
    Ville VARCHAR(100),
    idPays INT,
    PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Panier
(
    id INT NOT NULL AUTO_INCREMENT,
    Quantite INT,
    idUser INT,
    idProduit INT,
    PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS Pays
(
    id INT NOT NULL AUTO_INCREMENT,
    Nom VARCHAR(100),
    PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


# Create FKs
ALTER TABLE Panier
    ADD CONSTRAINT fk_idProduit_Panier
    FOREIGN KEY (idProduit)
    REFERENCES Produit(id)
;
    
ALTER TABLE Panier
    ADD CONSTRAINT fk_idUser_Panier
    FOREIGN KEY (idUser)
    REFERENCES Users(id)
;
    
ALTER TABLE Avis
    ADD CONSTRAINT fk_idUser_Avis 
    FOREIGN KEY (idUser)
    REFERENCES Users(id)
;
    
ALTER TABLE Avis
    ADD CONSTRAINT fk_idProduit_Avis   
    FOREIGN KEY (idProduit)
    REFERENCES Produit(id)
;
    
ALTER TABLE Users
    ADD CONSTRAINT fk_idPays_Users 
    FOREIGN KEY (idPays)
    REFERENCES Pays(id)
;
    
ALTER TABLE Produit
    ADD CONSTRAINT fk_idCategorie_Produit 
    FOREIGN KEY (idCategorie)
    REFERENCES Categorie(id)
;
    
ALTER TABLE ImageProduit
    ADD CONSTRAINT fk_idProduit_ImageProduit  
    FOREIGN KEY (idProduit)
    REFERENCES Produit(id)
;
    
ALTER TABLE Genre
    ADD CONSTRAINT fk_idProduit_Genre   
    FOREIGN KEY (idProduit)
    REFERENCES Produit(id)
;
    
ALTER TABLE Produit
    ADD CONSTRAINT fk_idTaille_Produit    
    FOREIGN KEY (idTaille)
    REFERENCES Taille(id)
;
    
ALTER TABLE ImageProduit
    ADD CONSTRAINT fk_idImage_ImageProduit    
    FOREIGN KEY (idImage)
    REFERENCES Image(id)
;
    

# Create Indexes


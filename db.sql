create database GameVault;
use GameVault;

create table users(
users_id int primary key auto_increment,
username varchar(100),
email varchar(250),
user_password varchar(250)
)

create table Admins(
admin_id int primary key auto_increment,
users_id int,
foreign key (users_id) references users(users_id)
)

create table Joueurs(
joueur_id int primary key auto_increment,
users_id int,
foreign key (users_id) references users(users_id)
)

CREATE TABLE bannes (
    banne_id INT PRIMARY KEY AUTO_INCREMENT,
    joueur_id INT NOT NULL,
    banne_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (joueur_id) REFERENCES joueur(joueur_id)
)

CREATE TABLE jeu (
    jeu_id INT PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    type VARCHAR(50),
    nb_joueur INT,
    rating FLOAT,
    status VARCHAR(50),
	temps_jeu int,
    date_sortie DATE,
    create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)

CREATE TABLE notation (
    notation_id INT PRIMARY KEY AUTO_INCREMENT,
    joueur_id INT NOT NULL,
    jeu_id INT NOT NULL,
    rating FLOAT,
    content TEXT,
    create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (joueur_id) REFERENCES joueur(joueur_id),
    FOREIGN KEY (jeu_id) REFERENCES jeu(jeu_id)
)

CREATE TABLE favoris (
    favoris_id INT PRIMARY KEY AUTO_INCREMENT,
    joueur_id INT NOT NULL,
    jeu_id INT NOT NULL,
    add_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (joueur_id) REFERENCES joueur(joueur_id),
    FOREIGN KEY (jeu_id) REFERENCES jeu(jeu_id)
)

CREATE TABLE bibliotheque (
    bib_id INT PRIMARY KEY AUTO_INCREMENT,
    joueur_id INT NOT NULL,
    jeu_id INT NOT NULL,
    FOREIGN KEY (joueur_id) REFERENCES joueur(joueur_id),
    FOREIGN KEY (jeu_id) REFERENCES jeu(jeu_id)
)

CREATE TABLE chat (
    chat_id INT PRIMARY KEY AUTO_INCREMENT,
    joueur_id INT NOT NULL,
    content TEXT NOT NULL,
    create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (joueur_id) REFERENCES joueur(joueur_id)
)

CREATE TABLE historique (
    historique_id INT PRIMARY KEY AUTO_INCREMENT,
    joueur_id INT NOT NULL,
    jeu_id INT NOT NULL,
    add_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (joueur_id) REFERENCES joueur(joueur_id),
    FOREIGN KEY (jeu_id) REFERENCES jeu(jeu_id)
)


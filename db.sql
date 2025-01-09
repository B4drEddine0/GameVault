create database GameVault;
use GameVault;

create table users(
users_id int primary key auto_increment,
username varchar(100),
email varchar(250),
user_password varchar(250),
role_user enum('admin','joueur') DEFAULT 'joueur' 
)

create table Admins(
admin_id int primary key auto_increment,
users_id int,
foreign key (users_id) references users(users_id)
)


CREATE TABLE bannes (
    banne_id INT PRIMARY KEY AUTO_INCREMENT,
    users_id INT NOT NULL,
    banne_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (users_id) REFERENCES users(users_id)
)

CREATE TABLE jeu (
    jeu_id INT PRIMARY KEY AUTO_INCREMENT,
    admin_id int,
    title VARCHAR(100) NOT NULL,
    description TEXT,
    type VARCHAR(50),
    nb_users INT,
    rating FLOAT,
    status VARCHAR(50),
	temps_jeu int,
    date_sortie DATE,
    create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    FOREIGN KEY (admin_id) REFERENCES Admins(admin_id)
)

CREATE TABLE notation (
    notation_id INT PRIMARY KEY AUTO_INCREMENT,
    users_id INT NOT NULL,
    jeu_id INT NOT NULL,
    rating FLOAT,
    content TEXT,
    create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (users_id) REFERENCES users(users_id),
    FOREIGN KEY (jeu_id) REFERENCES jeu(jeu_id)
)

CREATE TABLE favoris (
    favoris_id INT PRIMARY KEY AUTO_INCREMENT,
    users_id INT NOT NULL,
    jeu_id INT NOT NULL,
    add_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (users_id) REFERENCES users(users_id),
    FOREIGN KEY (jeu_id) REFERENCES jeu(jeu_id)
)

CREATE TABLE bibliotheque (
    bib_id INT PRIMARY KEY AUTO_INCREMENT,
    users_id INT NOT NULL,
    jeu_id INT NOT NULL,
    FOREIGN KEY (users_id) REFERENCES users(users_id),
    FOREIGN KEY (jeu_id) REFERENCES jeu(jeu_id)
)

CREATE TABLE chat (
    chat_id INT PRIMARY KEY AUTO_INCREMENT,
    users_id INT NOT NULL,
    content TEXT NOT NULL,
    create_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (users_id) REFERENCES users(users_id)
)


CREATE TABLE historique (
    historique_id INT PRIMARY KEY AUTO_INCREMENT,
    users_id INT NOT NULL,
    jeu_id INT NOT NULL,
    add_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (users_id) REFERENCES users(users_id),
    FOREIGN KEY (jeu_id) REFERENCES jeu(jeu_id)
)

alter table jeu add COLUMN image VARCHAR(250);
alter table users add COLUMN image VARCHAR(250); 


ALTER TABLE users
MODIFY COLUMN image VARCHAR(255) DEFAULT 'images/profil.webp';

ALTER TABLE users
MODIFY COLUMN image VARCHAR(255) DEFAULT 'images/profil.webp';


INSERT INTO users (username, email, user_password, role_user, image) 
VALUES ('utilisateur', 'nouvel_utilisateur@example.com', 'motdepasse', 'joueur', 'https://th.bing.com/th/id/OIP.tLotgCDtzgTdwJcTiXWRCwHaEK?rs=1&pid=ImgDetMain');

ALTER TABLE users
Add COLUMN statut VARCHAR(50) DEFAULT 'Active';

alter table jeu add COLUMN vues int;
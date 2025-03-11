# GameVault

GameVault est une application web permettant aux joueurs de gérer leur collection de jeux vidéo de manière organisée et sociale. Les utilisateurs peuvent suivre leurs jeux, partager leurs expériences, et interagir avec d'autres joueurs via un système de chat intégré.

## 🎮 Fonctionnalités

- Gestion de bibliothèque de jeux
- Système utilisateur avec profils personnalisables
- Base de données détaillée des jeux
- Système de chat par jeu
- Panel d'administration complet

## 🛠 Technologies Utilisées

- PHP 8.0
- MySQL
- HTML5
- TailwindCSS
- JavaScript

## 📁 Structure du Projet

- `BibliotheClass.php`: Gestion de la bibliothèque de jeux
- `ChatClass.php`: Fonctionnalités de chat
- `GameClass.php`: Classe principale pour les jeux
- `HistoriqueClass.php`: Suivi de l'historique des jeux
- `UserClass.php`: Gestion des utilisateurs
- `collectionProcess.php`: Traitement des collections
- `gameProcess.php`: Traitement des jeux
- `connexion.php`: Gestion de la connexion utilisateur
- `dashboard.php`: Interface d'administration

## 🚀 Installation

1. Clonez le dépôt :
git clone [https://github.com/B4drEddine0/GameVault.git](https://github.com/B4drEddine0/GameVault.git)
2. Configurez votre serveur web (Apache/Nginx) pour pointer vers le dossier du projet
3. Importez la structure de base de données depuis `db.sql`
4. Configurez les paramètres de connexion à la base de données dans le fichier approprié

## 👥 Rôles Utilisateurs

- **Utilisateur**: Peut gérer sa collection, partager des critiques, et utiliser le chat
- **Administrateur**: Gère les jeux, les utilisateurs, et modère le contenu

## 👨‍💻 Pour les Développeurs

- Utilisation de PHP8 orienté objet
- Implémentation sécurisée de PDO
- Documentation du code incluse
- Rapports quotidiens envoyés à hamza@bouchikhi.com

## 🤝 Contribution

Ce projet a été développé dans un cadre éducatif. Les contributions sont les bienvenues via pull requests.

Développé par Badr Eddine Massa Al Khayr et imanechadli-02 dans le cadre d'un projet de formation en développement backend PHP.

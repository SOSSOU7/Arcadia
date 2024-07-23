# ZooArcadia

ZooArcadia est une application de gestion de zoo permettant de suivre les informations des animaux, les comptes rendus des vétérinaires, les habitats, et bien plus encore.

## Table des matières
1. [Fonctionnalités](#fonctionnalités)
2. [Technologies utilisées](#technologies-utilisées)
3. [Prérequis](#prérequis)
4. [Installation](#installation)
5. [Utilisation](#utilisation)
6. [Contribuer](#contribuer)
7. [Licence](#licence)

## Fonctionnalités
- Gestion des utilisateurs avec différents rôles (Administrateur, Vétérinaire, Employé, Visiteur)
- Suivi des animaux avec des détails tels que la race, l'état de santé, et les consultations vétérinaires
- Gestion des habitats et de la nourriture des animaux
- Historique des comptes rendus des vétérinaires
- Statistiques des consultations des animaux

## Technologies utilisées
- **Backend** : PHP
- **Base de données relationnelle** : MySQL
- **Base de données non relationnelle** : MongoDB
- **Frontend** : HTML, CSS, JavaScript
- **Serveur web** : Apache (via XAMPP)

## Prérequis
- PHP 7.4 ou plus récent
- MySQL 5.7 ou plus récent
- MongoDB 4.4 ou plus récent
- Composer
- XAMPP pour un environnement de développement local

## Installation

### Cloner le dépôt
1. Clonez le dépôt GitHub de l'application :
    ```bash
    git clone https://github.com/SOSSOU7/zooarcadia.git
    cd zooarcadia
    ```

### Configuration de la base de données MySQL
1. Créez une base de données MySQL pour l'application.
2. Importez les tables depuis le fichier `database.sql` dans votre base de données MySQL :
    ```sql
    SOURCE arcadia.sql;
    ```

### Configuration de l'application
1. ouvrez le fichier db.php:
   
2. Modifiez le fichier `db.php` avec vos informations de configuration MySQL et MongoDB :
    ```php
  

### Installation des dépendances PHP
1. Installez les dépendances PHP avec Composer :
    ```bash
    composer install
    ```

### Lancer le serveur
1. Si vous utilisez XAMPP, placez le projet dans le répertoire `htdocs` :
    ```bash
    mv zooarcadia xampp/htdocs/
    ```
2. Démarrez Apache et MySQL à partir de XAMPP Control Panel.

3. Accédez à l'application via votre navigateur à l'adresse :
    ```http
    http://localhost/zooarcadia
    ```

## Utilisation
- **Administrateur** : Gère les utilisateurs, les animaux, les habitats, et visualise les statistiques.
- **Vétérinaire** : Ajoute des comptes rendus pour les animaux.
- **Employé** : Gère les tâches quotidiennes du zoo.
- **Visiteur** : Consulte les informations des animaux.

## Contribuer
1. Fork le projet.
2. Créez une branche pour votre fonctionnalité .
3. Commitez vos modifications .
4. Poussez la branche .
5. Ouvrez une Pull Request.

## Licence
Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

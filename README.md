# Outil-JLL

Ce projet est un outil développé par Mateo, pour l'entreprise JLL - objet de stage

## Table des matières

- [Description](#description)
- [Fonctionnalités](#fonctionnalités)
- [Technologies utilisées](#technologies-utilisées)
- [Prérequis](#prérequis)
- [Installation](#installation)
- [Utilisation](#utilisation)
- [Tests](#tests)
- [Contributions](#contributions)
- [Licence](#licence)

## Description

**Outil-JLL** est une application qui permet aux utilisateurs de gérer les données json / isochrones.

## Fonctionnalités

- Gestion des utilisateurs avec mysql.- Stockage relationnel des données avec MySQL.
- compteur de téléchargement de fichiers avec Mongodb - Nosql
- Interface web responsive développée avec HTML, CSS, et Bootstrap.
- Support des opérations CRUD (Créer, Lire, Mettre à jour, Supprimer) sur les données.

## Technologies utilisées

- **PHP** - Langage de programmation côté serveur.
- **MongoDB** - Base de données NoSQL orientée documents.
- **MySQL** - Système de gestion de base de données relationnelle.
- **Node.js** - Environnement d'exécution JavaScript pour certaines parties du projet.
- **HTML/CSS** - Langages de balisage et de style pour la structure et la présentation des pages.
- **Bootstrap** - Framework CSS pour des designs responsives et modernes.
- **Composer** - Gestionnaire de dépendances pour PHP.
- **Python** - Convertisseur de données .json en "Shapefile".


## Prérequis

Avant de commencer, assurez-vous d'avoir les éléments suivants installés :

- [PHP](https://www.php.net/downloads) (version 7.0 ou supérieure)
- [Composer](https://getcomposer.org/download/) (pour la gestion des dépendances)
- [MongoDB](https://www.mongodb.com/try/download/community) (version 4.0 ou supérieure)
- [MySQL](https://www.mysql.com/downloads/) (version 5.7 ou supérieure)
- [Node.js](https://nodejs.org/en/download/) (version 14 ou supérieure, si utilisé)
- [Python] et les dépendances suivantes : flask ,flask_cors ,geopandas ,os,shutil,zipfile.


## Installation

1. Clonez ce dépôt sur votre machine locale :

   ```bash
   git clone <URL_DU_DEPOT>
   cd <NOM_DU_DOSSIER>
   ```

2. Installez les dépendances via Composer :

   ```bash
   composer install
   ```

3. Assurez-vous que MongoDB et MySQL sont en cours d'exécution. Vous pouvez démarrer MongoDB avec la commande suivante :

   ```bash
   mongod
   ```

   Et pour MySQL, assurez-vous que votre serveur MySQL est en marche (souvent via un service comme XAMPP, MAMP, ou directement à partir de votre terminal).

## Utilisation

1. Pour démarrer le serveur PHP intégré, utilisez la commande suivante (assurez-vous d'être dans le répertoire du projet) :

   ```bash
   php -S localhost:8000 -t public
   ```

2. Accédez à votre application via votre navigateur :

   ```
   http://localhost:8000
   ```

3. Si vous utilisez Node.js pour certaines fonctionnalités, démarrez-le également :

   ```bash
   node server.js
   ```

## Tests

Pour exécuter les tests unitaires avec PHPUnit, utilisez la commande suivante :

```bash
composer test
```

Cela exécutera tous les tests définis dans le répertoire de tests.

## Contributions

Les contributions pro sont les bienvenues ! Si vous souhaitez contribuer à ce projet, veuillez suivre ces étapes :

1. Fork ce dépôt.
2. Créez une nouvelle branche (`git checkout -b ma-branche`).
3. Apportez vos modifications et enregistrez-les (`git commit -m 'Ajoute une nouvelle fonctionnalité'`).
4. Poussez vos modifications (`git push origin ma-branche`).
5. Ouvrez une Pull Request.

## Licence

Ce projet est sous la licence [MIT](LICENSE).

## Auteurs

- **Mateo** - [mateosouquet@gmail.com](mailto:mateosouquet@gmail.com)

**Remarque : Les bases de données utilisées dans ce projet contiennent des informations confidentielles. Veuillez les manipuler avec soin et respecter les réglementations en matière de protection des données.**

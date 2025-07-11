# Jordan E-Commerce (Projet CDA)

## Présentation

Ce projet est un exercice réalisé dans le cadre de la formation Concepteur Développeur d'Applications (CDA). Il s'agit d'un site e-commerce fictif dédié à la marque Jordan, permettant de mettre en pratique le développement web avec Symfony et les bonnes pratiques d'intégration.

## Objectifs pédagogiques

-   Découvrir et manipuler le framework Symfony
-   Mettre en place une architecture MVC
-   Utiliser Bootstrap pour un design responsive et moderne
-   Gérer l'authentification et la sécurité
-   Manipuler des entités Doctrine (produits, types, utilisateurs)
-   Pratiquer l'intégration de templates Twig

## Fonctionnalités principales

-   Page d'accueil dynamique avec présentation de la marque
-   Catalogue de produits Jordan
-   Filtrage par type de produit
-   Gestion du stock, prix, description
-   Authentification utilisateur (connexion/inscription)
-   Interface d'administration (EasyAdmin)
-   Design respectant la charte graphique Jordan (noir, rouge, blanc)

## Technologies utilisées

-   Symfony (PHP)
-   Twig
-   Bootstrap 5
-   Doctrine ORM
-   EasyAdmin

## Installation (en local)

1. **Cloner le dépôt**
    ```bash
    git clone "https://github.com/Scheila59/CDA_EcommerceJordan.git"
    cd EcommerceJordan
    ```
2. **Installer les dépendances PHP**
    ```bash
    composer install
    ```
3. **Configurer la base de données**
    - Modifier le fichier `.env` pour adapter la connexion à votre base locale
    - Créer la base et lancer les migrations :
        ```bash
        php bin/console doctrine:database:create
        php bin/console doctrine:migrations:migrate
        ```
4. **Lancer le serveur Symfony**
    ```bash
    symfony server:start
    # ou
    php -S localhost:8000 -t public
    ```

## Structure du projet

-   `src/` : code source PHP (contrôleurs, entités, repository)
-   `templates/` : vues Twig (pages, partials)
-   `assets/` : JS/CSS personnalisés
-   `public/` : fichiers accessibles publiquement (images, index.php)
-   `migrations/` : scripts de migration de la base
-   `config/` : configuration Symfony

## Charte graphique

-   Couleurs : Noir (`#000`), Rouge Jordan (`#DC143C`), Blanc (`#FFF`)
-   Police : Roboto
-   Style : Minimaliste, élégant, sportif
-   Utilisation du logo Jumpman (usage pédagogique uniquement)

## Remarques

-   Ce projet est un exercice pédagogique et ne doit pas être utilisé à des fins commerciales.
-   Les images officielles de la marque sont utilisées uniquement dans le cadre de la formation.

## Auteur

Laura Beaugrand (formation CDA)

# Kanalablag
KKanalablag est un projet fictif créé dans le but de formation chez IFR pour pouvoir créer une interface d'administration en PHP sous symfony 6.3.1 .

## Installation
Téléchargez le projet avec la commande :

    git clone https://github.com/emmat974/kanalablag-ifr.git
Et exécutez les commandes suivantes :

    composer install 
    composer prepare
    symfony console d:m:m
    composer fixture
Et lancer le serveur avec :

    symfony server:start
Rendez vous sur http://localhost:8000 pour accéder au projet.

## Testez
Pour pouvoir tester le projet, vous possédez deux utilisateurs :

Un utilisateur administration : 
Email : admin@admin.com
Mot de passe : adminadmin

Et un utilisateur normal :
Email : test@test.com
Mot de passe : testtest


Les administrateurs peuvent créer, modérer les blagues, ils peuvent aussi créer des catégories.

Les utilisateurs normaux peuvent créer et éditent leur blague. Ils ne peuvent pas créer de nouvelles catégories n'y supprimer leur propre blague.

## Aperçu de l'application

Vous pouvez voir un aperçu de l'application depuis le dossier screenshot_app.

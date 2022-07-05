# Read me

## Installer le projet 
Faire les commandes suivantes : <br>
1.  docker compose up -d
2.  docker compose up -d phpmyadmin
3.  docker compose build
4.  docker compose run --rm symfony check:requirements
5.  docker compose run --rm composer install
6.  docker compose run --rm symfony console doctrine:database:create
7.  docker compose run --rm symfony console make:migration
8.  docker compose run --rm symfony console doctrine:migration:migrate
9.  docker compose require --dev orm-fixtures
10.  docker compose run --rm symfony console doctrine:fixtures:load

Après cela rendez vous sur http://localhost:8080/ pour vérifier que le php my admin est bien activé et que la base a bienété créer.
Puis vous pouvez aller sur http://localhost:8000/ pour consulter le site.

## Lancer le projet
1. docker compose up -d

## Vérifier que le projet est bien fonctionnel

## Commandes utiles
### Commande pour ftavailler avec fixtures
docker compose run --rm composer require --dev orm-fixtures
### Commande pour travailler avec facker php
docker compose run --rm composer require --dev fakerphp/faker
# Read me

## Installer le projet 
### Pré-requis
- Docker

### Configuration

#### Cloner le projet : 
```
cd emplacement
git clone https://github.com/Oxino/synfony-forum
```

#### Faire les commandes suivantes : <br>
```
docker compose up -d
docker compose run --rm symfony check:requirements
docker compose run --rm composer install
docker compose run --rm symfony console doctrine:database:create
docker compose run --rm symfony console doctrine:migration:migrate
docker compose require --dev orm-fixtures
docker compose run --rm symfony console doctrine:fixtures:load
```

Après cela rendez vous sur http://localhost:8080/ pour vérifier que le php my admin est bien activé et que la base a bienété créer.
Puis vous pouvez aller sur http://localhost:8000/ pour consulter le site.

## Test
### Connexion utilisateur
    Identifiant : 'testuser@gmail.com'
    Password : '123456'

### Connexion administrateur
    Identifiant : 'testadministrator@gmail.com'
    Password : '123456'
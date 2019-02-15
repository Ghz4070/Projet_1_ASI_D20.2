## Intallation

Comment installer le projet : 

#### Automatique :

Avec make:
```bash
make install
```
#### Manuel :
- Lancer docker : `docker-compose up -d`
- Accéder au container nginx : `docker-compose exec web bash`
- Installer les dépendances avec composer : `composer install`
- Modifier le .env :
```bash
DATABASE_URL=mysql://root:root@database/symfonyprojet
MAILER_URL=smtp://mailhog:1025
```
- Installer la bdd (si non créée) : `php bin/console doctrine:database:create`
- Update la bdd : `php bin/console d:s:u --force`
- Générer les fixtures : `php bin/console hautelook:fixtures:load --purge-with-truncate -q`


## Commande
Créer un Admin en ligne de commande (2 arguments requis: email et mot de passe) : 

- Accéder au container nginx : `docker-compose exec web bash`
```bash
php bin/console app:create-admin admin@admin admin
```

## Run 

##### Pour accéder au Projet : 

```bash
http://127.0.0.1:81
```
##### Pour acceder à la BDD :
```bash
vous avez le choix exemple : PhpStorm
```
##### Pour acceder à MailHog :
```bash
127.0.0.1:8025
```

## Description
##### En general :

- pagination, fixtures, makefile, mail etc ... 
- tous les utilisateur on pour MDP : "admin" via les fixtures
- Voter une conférence de 1 à 5 si connecté 

##### utilisateur lambda : 

- Accéder à la home et voir toutes les conférences en ligne
Voir toutes les conférences notées et celles non notées
Créer un compte, voir les conferences noté et non noté 
 
##### admin :

- Un admin peut tous faire ! 
- Uniquement l'admin peut créer les conferences 
- CRUD un utilisateur sauf le mot de passe
- CRUD Conferences
- CRUD sont profil

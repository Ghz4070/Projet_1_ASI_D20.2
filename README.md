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

##### Pour acceder à phpMyAdmin :
```bash
127.0.0.1:8080
```
- Utilisateur : root
- Mot de passe :  root

##### Pour acceder à MailHog :
```bash
127.0.0.1:8025
```

## Description


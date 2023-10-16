# Portfolio Thibault Delgrande

## Installer le site

### Pré-requis

1. PHP 8.1 ou supérieur (https://www.php.net/downloads.php) 
2. MySQL/MariaDB (https://www.mysql.com/fr/downloads/ | https://mariadb.org/download/), SQLite (https://www.sqlite.org/download.html) ou PostgreSQL (https://www.postgresql.org/download/)
3. Composer (https://getcomposer.org/download/)

### Installation

2. Téléchargez et décompressez le projet, ou clonez le
3. Ouvrez un terminal dans le dossier du projet et effectuez la commande `composer install` pour installez les dépendances
4. Créez un fichier .env.local
5. Si vous utilisez MySQL ou MariaDB, placez cette ligne dans le fichier .env.local :
`DATABASE_URL="mysql://app:!ChangeMe!@127.0.0.1:3306/app?serverVersion=8&charset=utf8mb4"`
Si vous utilisez SQLite, placez cette ligne dans le fichier .env.local :
`DATABASE_URL="sqlite:///%kernel.project_dir%/var/data.db"`
Si vous utilisez PostgreSQL, placez cette ligne dans le fichier .env.local :
`DATABASE_URL="postgresql://app:!ChangeMe!@127.0.0.1:5432/app?serverVersion=15&charset=utf8"`
6. Remplacez le premier `app` par le nom d'utilisateur de la base de donnée (par défaut, root). Remplacez `!ChangeMe!` par le mot de passe de la base de donnée. Changez `127.0.0.1` par l'url de votre base de donnée. Si elle est hebergée sur la même machine que le reste du site, laissez `127.0.0.1`. Si le port est différent, changez le port après `:`. Changez le deuxième `app` par le nom de la base de donnée. Elle ne doit pas exister. Remplacez `%kernel.project_dir%` par le chemin de votre projet.
7. Si elle n'existe pas encore, créez la base de donnée `php bin/console doctrine:database:create`
9. Appliquez les migrations à la base de donnée `php bin/console doctrine:migrations:migrate`

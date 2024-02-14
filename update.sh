#!/bin/bash

# Update the project from GitHub
git pull

# Update Symfony
composer install --no-dev --optimize-autoloader

# Update database schema
php bin/console doctrine:migrations:migrate --no-interaction

# Clear the cache
php bin/console cache:clear --env=prod

# Update Node.js dependencies
npm install --production

# Build the frontend assets
npm run build

# Étape 1 : Utiliser une image PHP officielle avec extensions nécessaires
FROM php:8.1-fpm

# Étape 2 : Installer des extensions PHP requises
RUN apt-get update && apt-get install -y \
    git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Étape 3 : Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Étape 4 : Créer et définir le répertoire de l'application
WORKDIR /var/www

# Étape 5 : Copier les fichiers Laravel
COPY . .

# Étape 6 : Installer les dépendances Laravel
RUN composer install --no-dev --optimize-autoloader

# Étape 7 : Configurer les permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Étape 8 : Exposer le port
# EXPOSE 9000

# Commande par défaut
CMD ["php-fpm"]

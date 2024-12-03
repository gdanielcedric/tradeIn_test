FROM php:8.1-fpm

# Installer les dépendances
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Installer Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Définir le dossier de travail
WORKDIR /var/www

# Copier les fichiers
COPY . .

# Installer les dépendances Laravel
RUN composer install --optimize-autoloader --no-dev

# Donner les permissions nécessaires
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Exposer le port
EXPOSE 8000

# Commande par défaut
CMD ["php-fpm"]

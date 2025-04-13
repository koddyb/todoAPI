FROM php:8.2-fpm

# Mettre à jour les listes de paquets et installer les dépendances nécessaires
RUN apt-get update \
    && apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip\
    && docker-php-ext-install intl pdo pdo_mysql \
    && docker-php-ext-enable pdo_mysql \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

# Copier Composer depuis son image officielle vers le conteneur
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Définir le répertoire de travail à l'intérieur du conteneur
WORKDIR /var/www

# Exécuter l'installation de Composer et démarrer PHP-FPM comme commande par défaut
CMD composer install ; php-fpm

# Installer l'outil Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash
# Déplacer Symfony CLI vers un répertoire dans le PATH
RUN mv /root/.symfony5/bin/symfony /usr/local/bin/symfony

# Exposer le port 9000 pour PHP-FPM
EXPOSE 9000
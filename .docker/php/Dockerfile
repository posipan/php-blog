FROM php:8-apache

RUN apt-get update \
    && apt-get install -y vim libonig-dev libzip-dev unzip \
    && docker-php-ext-install pdo_mysql mysqli mbstring zip bcmath \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug \
    && mv /etc/apache2/mods-available/rewrite.load /etc/apache2/mods-enabled

COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN /bin/sh -c a2enmod rewrite

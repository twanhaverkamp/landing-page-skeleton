FROM php:7.4-fpm

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

COPY / /var/www/project
WORKDIR /var/www/project/

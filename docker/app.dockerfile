FROM php:7-fpm

RUN apt-get update && apt-get install -y libmcrypt-dev && docker-php-ext-install mcrypt

WORKDIR /var/www
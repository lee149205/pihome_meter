FROM php:7.2-fpm

# install PHP extensions
RUN docker-php-ext-install mysqli pdo_mysql

RUN curl -sS https://getcomposer.org/installer | \
    php -- --install-dir=/usr/bin/ --filename=composer

RUN apt-get update && apt-get install -y \
    zip \
    nano \
    unzip \
    curl \
    git \
    npm \
    libpng-dev

RUN docker-php-ext-install zip
RUN docker-php-ext-install gd

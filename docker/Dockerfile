FROM node:lts as nodebuild
FROM composer:lts as composerbuild
FROM php:8.2.2-apache

LABEL Maintainer="Gopibabu Srungavarapu <s.gopibabu@gmail.com>" \
      Description="Docker Image for raptor development environment"

###############################################################################
# environment variables and arguments
###############################################################################
ENV COMPOSER_ALLOW_SUPERUSER 1
ENV COMPOSER_PROCESS_TIMEOUT 2000

###############################################################################
# configuring proxy
###############################################################################
RUN pear config-set php_ini "$PHP_INI_DIR"/php.ini

###############################################################################
# installing essential programs
###############################################################################
RUN apt-get -yqq update \
    && apt-get -yqq install --no-install-recommends zip unzip \
        build-essential \
        libzip-dev \
        libicu-dev \
        libjpeg62-turbo-dev \
        libfreetype6-dev \
        libonig-dev \
        locales \
        libpq-dev \
        libssl-dev \
        libcurl4-openssl-dev \
        curl \
        wget \
    && docker-php-ext-configure intl \
    && docker-php-ext-configure zip \
    && docker-php-ext-install mysqli pdo pdo_mysql pgsql pdo_pgsql pcntl intl zip sockets \
    && a2enmod rewrite

###############################################################################
# copy configuration files
###############################################################################
COPY docker/vhost.conf /etc/apache2/sites-available/000-default.conf
COPY docker/config/php/php.ini /usr/local/etc/php/php.ini

###############################################################################
# copy helper files
###############################################################################
COPY docker/start.sh /usr/local/bin/start
RUN chmod +x /usr/local/bin/start

###############################################################################
# installing node and npm
###############################################################################
COPY --from=nodebuild /usr/local /usr/local

###############################################################################
# installing composer
###############################################################################
COPY --from=composerbuild /usr/bin/composer /usr/bin/composer

###############################################################################
# project files
###############################################################################
WORKDIR /var/www/html
COPY . /var/www/html
RUN chown -R www-data:www-data /var/www/html
RUN find /var/www/html -type f -exec chmod 644 {} \;
RUN find /var/www/html -type d -exec chmod 755 {} \;

WORKDIR /var/www/html
RUN chown -R $USER:www-data .
RUN chgrp -R www-data storage bootstrap/cache

EXPOSE 80

CMD ["/usr/local/bin/start"]

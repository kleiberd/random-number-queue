FROM php:7.2-fpm-alpine3.7

LABEL maintainer="David Kleiber <kleiberd93@gmail.com>"

RUN docker-php-ext-install -j$(nproc) bcmath mysqli pdo_mysql

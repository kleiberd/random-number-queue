FROM php:7.2-cli-alpine3.7

LABEL maintainer="David Kleiber <kleiberd93@gmail.com>"

RUN docker-php-ext-install -j$(nproc) bcmath mysqli pdo_mysql

RUN apk update && apk add -u python py-pip && \
    pip install supervisor

COPY "supervisor/supervisord.conf" "/etc/supervisord.conf"

COPY "supervisor/worker.conf" "/etc/supervisor/conf.d/worker.conf"

RUN mkdir /var/log/supervisor && touch /var/log/supervisor/supervisord.log

ENTRYPOINT ["supervisord", "--nodaemon", "--configuration", "/etc/supervisord.conf"]
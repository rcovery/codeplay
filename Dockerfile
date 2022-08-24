FROM composer:latest

RUN mkdir /conf.d
RUN apk add sudo \
    autoconf \
    zlib-dev \
    icu-dev \
    g++
RUN adduser -D user sudo
RUN echo "user:123" | chpasswd
RUN echo "user    ALL=(ALL:ALL) ALL" >> /etc/sudoers

RUN docker-php-ext-configure intl && \
    docker-php-ext-install intl mysqli pdo pdo_mysql && \
    docker-php-ext-enable intl

USER user
WORKDIR /home/user/app

ENTRYPOINT src/bin/cake server -H 0.0.0.0 -p 80
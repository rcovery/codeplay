FROM composer:latest

RUN mkdir /conf.d
RUN apk add sudo \
    autoconf \
    zlib-dev \
    icu-dev \
    nodejs \
    npm \
    g++
RUN adduser -D user sudo
RUN echo "user:123" | chpasswd
RUN echo "user    ALL=(ALL:ALL) ALL" >> /etc/sudoers

# SWOOLE
RUN pecl install swoole
RUN docker-php-ext-enable swoole
#

# PDO & INTL
RUN docker-php-ext-configure intl
RUN docker-php-ext-install intl mysqli pdo pdo_mysql
RUN docker-php-ext-enable intl
#

# PCNTL
RUN docker-php-ext-install pcntl
#

USER user
WORKDIR /home/user/app

COPY ./source .
RUN composer install
RUN npm install

ENTRYPOINT ["sh", "entrypoint.sh"]
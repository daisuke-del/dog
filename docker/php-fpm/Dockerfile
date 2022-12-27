FROM php:7.4.16-fpm-alpine3.13 as app
RUN docker-php-ext-install opcache
RUN apk --no-cache add autoconf make g++ gcc
RUN pecl install redis
RUN docker-php-ext-install pdo_mysql

#タイムゾーンをJSTに設定
RUN apk --update add tzdata && \
    cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && \
    apk del tzdata && \
    rm -rf /var/cache/apk/*

WORKDIR /var/www/html
COPY ../src /var/www/html

COPY ./docker/php-fpm/php.ini /usr/local/etc/php/php.ini
COPY ./docker/php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN chmod -R 777 storage
RUN chmod -R 777 bootstrap/cache

RUN rm -rf frontend
RUN rm -rf public
COPY ../src/public/ /var/www/html/public/

#src配下の不要ファイルの削除
RUN rm -rf .idea
RUN rm -rf tests
RUN rm -rf .editorconfig
RUN rm -rf .env.example
RUN rm -rf .gitattributes
RUN rm -rf .gitignore
RUN rm -rf .styleci.yml
RUN rm -rf _ide_helper.ph
RUN rm -rf README.md

FROM php:7.4.16-fpm-alpine3.13 as db
RUN docker-php-ext-install opcache
RUN apk --no-cache add autoconf make g++ gcc
RUN pecl install redis
RUN docker-php-ext-install pdo_mysql

#タイムゾーンをJSTに設定
RUN apk --update add tzdata && \
    cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && \
    apk del tzdata && \
    rm -rf /var/cache/apk/*

WORKDIR /var/www/html
COPY ../src /var/www/html
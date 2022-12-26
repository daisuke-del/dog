FROM php:7.4.16-fpm-alpine3.13 as app
RUN docker-php-ext-install opcache
RUN apk --no-cache add postgresql-dev autoconf make g++ gcc libmemcached-dev zlib-dev
RUN pecl install redis
RUN docker-php-ext-install pgsql pdo_pgsql

#タイムゾーンをJSTに設定
RUN apk --update add tzdata && \
    cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && \
    apk del tzdata && \
    rm -rf /var/cache/apk/*

#libxml2:2.9.10-r6 脆弱性対応
RUN sed -e '2a https://dl-cdn.alpinelinux.org/alpine/v3.14/main' -i /etc/apk/repositories && \
    apk update && \
    apk search libxml2 && \
    apk add libxml2=2.9.14-r0

#openssl:1.1.1k-r0 脆弱性対応
RUN apk search openssl && \
    apk add openssl=1.1.1q-r0

WORKDIR /var/www/html
COPY ../src /var/www/html

COPY ./php-fpm/php.ini /usr/local/etc/php/php.ini
COPY ./php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf

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
RUN apk --no-cache add postgresql-dev autoconf make g++ gcc libmemcached-dev zlib-dev
RUN pecl install redis
RUN docker-php-ext-install pgsql pdo_pgsql

#タイムゾーンをJSTに設定
RUN apk --update add tzdata && \
    cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && \
    apk del tzdata && \
    rm -rf /var/cache/apk/*

#libxml2:2.9.10-r6 脆弱性対応
RUN sed -e '2a https://dl-cdn.alpinelinux.org/alpine/v3.14/main' -i /etc/apk/repositories && \
    apk update && \
    apk search libxml2 && \
    apk add libxml2=2.9.14-r0

#openssl:1.1.1k-r0 脆弱性対応
RUN apk search openssl && \
    apk add openssl=1.1.1q-r0

WORKDIR /var/www/html
COPY ../src /var/www/html

COPY ./php-fpm/php.ini /usr/local/etc/php/php.ini
COPY ./php-fpm/www.conf /usr/local/etc/php-fpm.d/www.conf

RUN rm -rf admin
RUN rm -rf frontend_admin
RUN rm -rf public/admin
RUN rm -rf public/web
RUN rm -rf app/Console/Commands/Admin
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
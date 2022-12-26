FROM nginx:1.19.7-alpine

#タイムゾーンをJSTに設定
RUN apk --update add tzdata && \
    cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && \
    apk del tzdata && \
    rm -rf /var/cache/apk/*

#defult.conf削除
#RUN rm -f /etc/nginx/conf.d/default.conf

#libxml2:2.9.10-r6 脆弱性対応
RUN sed -e '2a https://dl-cdn.alpinelinux.org/alpine/v3.14/main' -i /etc/apk/repositories && \
    apk update && \
    apk search libxml2 && \
    apk add libxml2=2.9.14-r0

#WORKDIR /etc/nginx/conf.d
COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY ./docker/src/public/ /var/www/html/public/
RUN rm -rf /var/www/html/public
COPY ./src/public/ /var/www/html/public/
COPY ./docker/nginx/index.html /var/www/html/public/index.html


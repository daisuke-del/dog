FROM nginx:1.19.7-alpine

#タイムゾーンをJSTに設定
RUN apk --update add tzdata && \
    cp /usr/share/zoneinfo/Asia/Tokyo /etc/localtime && \
    apk del tzdata && \
    rm -rf /var/cache/apk/*

#WORKDIR /etc/nginx/conf.d
COPY ./src/public/ /var/www/html/public/
COPY ./docker/nginx/index.html /var/www/html/public/index.html

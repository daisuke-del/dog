FROM nginx:1.19-alpine

ENV TZ=UTC

# default.conf削除
# RUN rm -f /etc/nginx/conf.d/default.conf

# nginx config file
COPY ./docker/nginx/nginx.conf /etc/nginx/conf.d/default.conf
COPY ./src/public /var/www/html/public

WORKDIR /var/www/html
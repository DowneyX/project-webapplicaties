FROM composer:latest AS composer_stage

RUN rm -rf /var/app && mkdir /var/app
WORKDIR /var/app

COPY composer.json composer.lock symfony.lock .env ./
COPY public public/

RUN composer install --ignore-platform-reqs --prefer-dist --no-scripts

RUN composer dump-autoload --optimize --apcu --no-dev

COPY bin bin/
COPY config config/
COPY src src/

FROM node:latest AS npm_stage

COPY --from=composer_stage /var/app /var/app

WORKDIR /var/app
COPY package.json package-lock.json webpack.config.js ./
COPY assets ./assets

RUN npm install

FROM php:latest AS php_stage

COPY --from=npm_stage /var/app /var/app

WORKDIR /var/app
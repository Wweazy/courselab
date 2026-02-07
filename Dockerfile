FROM php:8.4-apache

RUN apt-get update && apt-get install -y \
    git unzip \
    libicu-dev \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        intl \
        zip \
        opcache \
    && a2enmod rewrite \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/*.conf \
    /etc/apache2/apache2.conf

WORKDIR /var/www/html

COPY composer.json composer.lock symfony.lock ./

RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --optimize-autoloader

COPY . .

RUN php bin/console cache:clear --env=prod \
 && php bin/console cache:warmup --env=prod \
 && php bin/console asset-map:compile \
 && chown -R www-data:www-data var

EXPOSE 80

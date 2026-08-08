FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

RUN apt-get update && apt-get install -y git unzip libssl-dev pkg-config \
    && pecl install mongodb \
    && docker-php-ext-enable mongodb


RUN composer install --no-dev --optimize-autoloader

RUN chown -R www-data:www-data /var/www/html

EXPOSE 80

CMD ["apache2-foreground"]

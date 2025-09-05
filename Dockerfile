# --- ステージ1: ビルドステージ ---
FROM composer/composer:2-bin as composer
FROM php:8.2-cli as builder

COPY --from=composer /composer /usr/bin/composer

RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo_pgsql

WORKDIR /var/www/html

COPY composer.json composer.lock ./

RUN composer install --no-interaction --no-dev --optimize-autoloader --ignore-platform-reqs

COPY . .

# --- ステージ2: 本番ステージ ---
FROM php:8.2-apache
WORKDIR /var/www/html
RUN apt-get update && apt-get install -y \
        libzip-dev \
        unzip \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_pgsql zip
RUN a2enmod rewrite
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf
COPY --from=builder /var/www/html .
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]
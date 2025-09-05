# PHP 8.2 と Apache が入った公式イメージをベースにする
FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
        unzip \
        libzip-dev \
        libpq-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_pgsql zip

# Composer をグローバルにインストールする
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Apache の設定
RUN a2enmod rewrite
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# 作業ディレクトリを設定
WORKDIR /var/www/html

# まず composer.json と composer.lock だけをコピー
COPY composer.json composer.lock ./

# 依存関係をインストール
RUN composer install --no-interaction --no-dev --optimize-autoloader

# アプリケーションの残りのファイルをコピー
COPY . .

# パーミッションを設定
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# エントリーポイントを設定
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]
# Docker Hubの公式PHPイメージを使用 (Apacheサーバー付き)
FROM php:8.2-fpm-apache

# Laravelが必要とするPHP拡張機能をインストール
# (gdは画像処理、zipはファイル圧縮によく使われるため追加)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_pgsql zip gd

# Apacheのrewriteモジュールを有効化 (LaravelのURLルーティングに必須)
RUN a2enmod rewrite

# ApacheのドキュメントルートをLaravelのpublicディレクトリに設定
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# composerの依存関係をコピーしてインストール
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-dev --prefer-dist --optimize-autoloader

# アプリケーションのコード全体をコピー
COPY . .

# Laravelのディレクトリパーミッションを設定
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# ポートを公開
EXPOSE 80
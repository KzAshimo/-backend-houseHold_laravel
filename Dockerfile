# PHP 8.2 と Apache が入った公式イメージをベースにする
FROM php:8.2-apache

# 必要なライブラリとPHP拡張機能（pdo_pgsql と composer に必要なもの）を一度にすべてインストールする
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

# 【最重要変更点】先にアプリケーションの全ファイルをコピーする
COPY . .

# Artisanコマンドが参照できるよう、.env.example から .env ファイルを作成する
RUN cp .env.example .env

# 依存関係をインストール（--ignore-platform-reqs は不要）
# この時点ではartisanコマンドが実行できるので、スクリプトは成功する
RUN composer install --no-interaction --no-dev --optimize-autoloader

# パーミッションを設定
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# エントリーポイントを設定
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]
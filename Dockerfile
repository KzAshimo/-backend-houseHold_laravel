# PHP 8.2 と Apache が入った公式イメージをベースにする
FROM php:8.2-apache

# 【変更点】intl拡張機能に必要なライブラリ(libicu-dev)を追加
RUN apt-get update && apt-get install -y \
        unzip \
        libzip-dev \
        libpq-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    # 【変更点】intl拡張機能をインストール
    && docker-php-ext-install -j$(nproc) gd intl \
    && docker-php-ext-install pdo pdo_pgsql zip

# Composer をグローバルにインストールする
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Apache の設定
RUN a2enmod rewrite
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# 作業ディレクトリを設定
WORKDIR /var/www/html

# 先にアプリケーションの全ファイルをコピーする
COPY . .

# Artisanコマンドが参照できるよう、.env.example から .env ファイルを作成する
# 注意: Renderの環境変数で上書きされるため、ここでの内容は一時的なものです
RUN cp .env.example .env

# 依存関係をインストール
# intl拡張機能がインストールされたので、artisanスクリプトは成功するはず
RUN composer install --no-interaction --no-dev --optimize-autoloader

# パーミッションを設定
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# エントリーポイントを設定
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh
ENTRYPOINT ["entrypoint.sh"]
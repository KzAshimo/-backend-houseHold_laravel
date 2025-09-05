# --- ステージ1: ビルドステージ ---
# composerがプリインストールされたイメージを "builder" と名付ける
FROM composer:2 as builder

# 作業ディレクトリを設定
WORKDIR /var/www/html

# まずは依存関係ファイルだけコピーする
COPY composer.json composer.lock ./

# 【変更点】installをupdateに変更し、Renderの環境で依存関係を再解決させる
RUN composer update --no-interaction --no-dev --optimize-autoloader -vvv

RUN cat composer.lock

# アプリケーションの全ファイルをコピーする
COPY . .


# --- ステージ2: 本番ステージ ---
# 軽量なPHP+Apacheイメージをベースにする
FROM php:8.2-apache

# 作業ディレクトリを設定
WORKDIR /var/www/html

# Laravelに必要なPHP拡張（PostgreSQL用）と、画像処理用のgdをインストール
RUN apt-get update && apt-get install -y \
        libzip-dev \
        unzip \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_pgsql zip

# ApacheのURL書き換えモジュールを有効化
RUN a2enmod rewrite

# Apacheの設定ファイルをコンテナ内にコピー
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# ビルドステージから、インストール済みのファイル一式をコピーしてくる
COPY --from=builder /var/www/html .

# Laravelのストレージとキャッシュディレクトリの所有者をWebサーバー(www-data)に変更
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# エントリーポイントスクリプトをコピーして実行権限を付与
COPY entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/entrypoint.sh

# コンテナ起動時にエントリーポイントスクリプトを実行する
ENTRYPOINT ["entrypoint.sh"]
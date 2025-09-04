# Renderが提供する公式のPHPイメージを使用
FROM render/php:8.2-fpm

# Laravelが必要とするPHP拡張機能をインストール
# もし他に何か必要な拡張機能があれば、ここに追加できます
RUN docker-php-ext-install pdo pdo_pgsql

# ApacheのドキュメントルートをLaravelのpublicディレクトリに設定
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# composerの依存関係をコピーしてインストール
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-dev --prefer-dist

# アプリケーションのコード全体をコピー
COPY . .

# ファイルの所有権をWebサーバーユーザーに変更
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
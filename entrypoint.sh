#!/bin/sh

# エラーが発生したらスクリプトを終了する
set -e

# データベースのマイグレーションを実行
echo "Running database migrations..."
php artisan migrate --force

# Apacheサーバーをフォアグラウンドで起動
# exec を使うことで、このスクリプトのプロセスがApacheのプロセスに置き換わる
# これにより、Dockerがコンテナを正しく管理できるようになる
exec apache2-foreground
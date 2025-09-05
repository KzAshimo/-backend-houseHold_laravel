#!/bin/sh

# エラーが発生したらスクリプトを終了する
set -e

# --- デバッグとマイグレーション ---

echo "Clearing configuration cache..."
# 古い設定キャッシュを完全に削除します（最重要）
php artisan config:clear

echo "Caching configuration..."
# Renderの環境変数を読み込んで設定をキャッシュします
php artisan config:cache

echo "Testing database connection..."
# データベースに接続できるかテストし、その結果をログに出力します
php artisan db:show

echo "Running database migrations..."
# データベースマイグレーションを実行します
php artisan migrate --force

# --- サーバー起動 ---
echo "Starting Apache server..."
exec apache2-foreground
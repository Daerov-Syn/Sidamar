#!/bin/sh
set -e

echo "=== Memulai SiDamar ==="

mkdir -p /app/storage/framework/sessions \
         /app/storage/framework/views \
         /app/storage/framework/cache/data \
         /app/storage/logs \
         /app/bootstrap/cache

php artisan storage:link --quiet || true

if [ -n "$DB_HOST" ] || [ -n "$MYSQLHOST" ] || [ -n "$DB_URL" ] || [ -n "$MYSQL_URL" ]; then
    echo "Memeriksa koneksi database..."
    MAX_TRIES=15
    COUNT=0
    until php artisan db:show >/dev/null 2>&1 || [ $COUNT -ge $MAX_TRIES ]; do
        echo "Menunggu database siap ($COUNT/$MAX_TRIES)..."
        sleep 2
        COUNT=$((COUNT + 1))
    done

    echo "Menjalankan migrasi & data awal (app:setup)..."
    php artisan app:setup || echo "Peringatan: Database setup selesai dengan catatan."
fi

if [ "$APP_ENV" = "production" ]; then
    echo "Mengoptimasi cache Laravel..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

echo "FrankenPHP berjalan pada port ${PORT:-80}..."
exec frankenphp run --config /etc/frankenphp/Caddyfile

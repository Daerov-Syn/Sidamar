#!/bin/sh
set -e

echo "=== Memulai SiDamar ==="

mkdir -p /app/storage/framework/sessions \
         /app/storage/framework/views \
         /app/storage/framework/cache/data \
         /app/storage/logs \
         /app/bootstrap/cache \
         /app/database \
         /tmp/views \
         /tmp/storage 2>/dev/null || true

# Buat file sqlite jika menggunakan driver sqlite
if [ "$DB_CONNECTION" = "sqlite" ] || [ -z "$DB_CONNECTION" ]; then
    touch /app/database/database.sqlite 2>/dev/null || true
fi

php artisan storage:link --quiet || true

# Jika MySQL dikonfigurasi, tunggu koneksi
if [ "$DB_CONNECTION" = "mysql" ]; then
    echo "Memeriksa koneksi database MySQL..."
    MAX_TRIES=15
    COUNT=0
    until php artisan db:show >/dev/null 2>&1 || [ $COUNT -ge $MAX_TRIES ]; do
        echo "Menunggu MySQL siap ($COUNT/$MAX_TRIES)..."
        sleep 2
        COUNT=$((COUNT + 1))
    done
fi

echo "Menjalankan migrasi & data awal (app:setup)..."
php artisan app:setup || echo "Peringatan: Database setup selesai dengan catatan."

if [ "$APP_ENV" = "production" ]; then
    echo "Mengoptimasi cache Laravel..."
    php artisan config:cache || true
    php artisan route:cache || true
    php artisan view:cache || true
fi

echo "FrankenPHP berjalan pada port ${PORT:-80}..."
exec frankenphp run --config /etc/frankenphp/Caddyfile

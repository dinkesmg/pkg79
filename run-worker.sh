#!/bin/bash

# Jalankan queue worker Laravel di background
php artisan queue:work --sleep=3 --tries=3 --timeout=90 > storage/logs/worker.log 2>&1 &

# Jalankan PHP-FPM sebagai proses utama
php-fpm

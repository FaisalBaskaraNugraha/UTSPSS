# Gunakan image dasar PHP dengan FPM (FastCGI Process Manager)
FROM php:8.1-fpm-alpine AS base

# Set working directory
WORKDIR /var/www/html

# Install dependensi sistem yang umum dibutuhkan Laravel dan ekstensi PHP.
# Jika Anda ingin menjalankan Nginx dan PHP-FPM dalam satu container, 
# pastikan untuk menginstall nginx dan supervisor.
RUN apk update && apk add --no-cache \
    nginx \
    supervisor \
    libzip-dev \
    zip \
    unzip \
    postgresql-dev \
    build-base && \
    docker-php-ext-install pdo pdo_pgsql zip bcmath && \
    rm -rf /var/cache/apk/*

# Install Composer (dependency manager PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Jika ada file konfigurasi khusus (misalnya untuk Nginx atau Supervisor), 
# Anda dapat meng-copy-nya di sini:
# COPY docker/app/supervisord.conf /etc/supervisord.conf
# COPY docker/app/nginx.conf /etc/nginx/nginx.conf

# Copy file composer terlebih dahulu untuk caching layer Docker
COPY composer.json composer.lock ./

# Install dependensi PHP (tanpa package development dan dengan optimasi autoloader)
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Copy seluruh kode aplikasi ke container
COPY . .

# Ubah kepemilikan dan izin pada direktori storage dan bootstrap/cache agar sesuai dengan user www-data
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache && \
    chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port yang digunakan oleh PHP-FPM
EXPOSE 9000

# Perintah default saat container dijalankan.
# Jika Anda menggunakan Nginx + PHP-FPM pada container yang sama dengan Supervisor, gunakan:
# CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
# Jika hanya menggunakan PHP-FPM (Nginx dijalankan pada container terpisah), gunakan:
CMD ["php-fpm"]

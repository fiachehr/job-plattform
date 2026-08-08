FROM php:8.5-fpm

# نصب dependency ها
RUN apt-get update && apt-get install -y \
    libpq-dev \
    git \
    unzip \
    curl

# نصب extension های PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql pgsql

# نصب Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www
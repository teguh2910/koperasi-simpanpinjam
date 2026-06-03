FROM php:8.4-fpm-alpine

WORKDIR /var/www/html

# Install dependencies
RUN apk add --no-cache \
    git \
    curl \
    libpng-dev \
    oniguruma-dev \
    libxml2-dev \
    postgresql-dev \
    zip \
    unzip

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_pgsql pgsql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy existing application
COPY . /var/www/html

# Set permissions
RUN chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

CMD ["php-fpm"]
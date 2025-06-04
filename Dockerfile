# Stage 1: Composer build stage
FROM composer:2.6 AS builder

WORKDIR /app

# Copy only necessary files for composer
COPY composer.json composer.lock ./

# Install dependencies without dev packages
RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --prefer-dist \
    --optimize-autoloader \
    --no-dev

# Copy only necessary directories
COPY app/ app/
COPY bootstrap/ bootstrap/
COPY config/ config/
COPY database/ database/
COPY public/ public/
COPY resources/ resources/
COPY routes/ routes/
COPY .env .

# Stage 2: Production image
FROM php:8.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    libzip-dev \
    zip \
    unzip \
    libonig-dev \
    libxml2-dev \
    default-mysql-client \
    && docker-php-ext-configure gd --with-jpeg --with-webp \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    zip \
    gd \
    opcache \
    && a2enmod rewrite

WORKDIR /var/www/html

# Copy from builder
COPY --from=builder /app .

# Install Composer in production image
COPY --from=composer:2.6 /usr/bin/composer /usr/bin/composer

# Configure Apache
RUN echo "<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/public\n\
    <Directory /var/www/html/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>" > /etc/apache2/sites-available/000-default.conf

# Create storage directories and set permissions
RUN mkdir -p storage/framework/{sessions,views,cache} \
    && mkdir -p bootstrap/cache \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 80

CMD ["apache2-foreground"]

# Use official PHP-FPM image for PHP 8.4
FROM php:8.4-fpm

# install dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install pdo pdo_mysql mbstring zip gd

# Install Xdebug via PECL
RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

# Install Composer (copy from official composer image)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy php config files
COPY docker/php.ini /usr/local/etc/php/conf.d/99-php.ini
COPY docker/xdebug.ini /usr/local/etc/php/conf.d/20-xdebug.ini

# Copy application files
COPY . /var/www/html

# Ensure web user owns files (optional)
RUN chown -R www-data:www-data /var/www/html

# Expose FPM port (internal)
EXPOSE 9000

# Default command — php-fpm
CMD ["php-fpm"]

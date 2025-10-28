FROM php:8.4-cli

# Install system dependencies and Composer
RUN apt-get update && apt-get install -y \
    git unzip curl \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /app

# Copy project files
COPY . /app

# Optional: custom php.ini
COPY docker/php.ini /usr/local/etc/php/conf.d/php.ini

# Install dependencies
RUN composer install

CMD ["php", "-S", "0.0.0.0:8000", "index.php"]

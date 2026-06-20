# Base image: PHP 8.3.25
FROM php:8.3.25

# Install system dependencies and PHP extensions
RUN apt-get update -y && apt-get install -y openssl zip unzip git

# Install Composer (PHP package manager)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PostgreSQL client
RUN apt-get update && apt-get install -y libpq-dev

# Install PHP extensions for PostgreSQL
RUN docker-php-ext-install pdo pdo_pgsql

# Check if mbstring extension is installed (for debugging purposes)
RUN php -m | grep mbstring

# Set working directory
WORKDIR /app

# Copy the application code to the container
COPY . /app

# Install PHP dependencies
RUN composer install

# Command to run the laravel development server
CMD php artisan serve --host=0.0.0.0 --port=8000

# Expose port 8000
EXPOSE 8000

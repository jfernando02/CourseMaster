# Use an official PHP runtime as a parent image
# Build Node.js in a separate stage
FROM node:latest AS node_builder

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm install

# Add your source files
COPY . .

# Build PHP
FROM php:8.1-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libonig-dev \
    libzip-dev \
    curl \
    unzip \
    git

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory permissions
COPY --chown=www-data:www-data . /var/www/html

# Copy built Node.js files from node_builder stage
COPY --from=node_builder /app/public /var/www/html/public

# Install Composer Dependencies
RUN composer install

# Change current user to www
USER www-data

# Expose port 9000 and start the application
EXPOSE 9000
CMD ["php-fpm"]

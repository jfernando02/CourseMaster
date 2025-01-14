# Use an official PHP runtime as a parent image
FROM php:8.1-fpm

# Use the official image from Docker Hub
FROM node:latest AS node

# Define environment variables
ENV APP_HOME /var/www/html/

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    zip \
    curl \
    unzip

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR $APP_HOME

# Install Node.js dependencies
COPY package.json package-lock.json ./
RUN npm install

# Build for production
RUN npm run production

# Copy existing application directory
COPY . $APP_HOME

# Install Composer Dependencies
RUN composer install

# Change current user to www
USER www-data

# Expose port 9000 and start the application
EXPOSE 9000
CMD ["php-fpm"]
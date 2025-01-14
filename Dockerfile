# Build Node.js in a separate stage
FROM node:latest AS node_builder

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm install

# Add your source files
COPY . .

# Use your actual build script
# RUN npm run your-build-command

# Build PHP
FROM php:8.2-fpm

# Install system dependencies
RUN apt-get update && apt-get upgrade -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libzip-dev \
    curl \
    unzip \
    git

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
  && docker-php-ext-install -j "$(nproc)" gd pdo_mysql mbstring zip exif pcntl

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy existing application directory
COPY . /var/www/html

# Copy built Node.js files from node_builder stage
# COPY --from=node_builder /path/to/your/assets /var/www/html/public

# Install Composer Dependencies
RUN composer install

# Change current user to www-data
USER www-data

# Expose port 9000 and start the application
EXPOSE 9000
CMD ["php-fpm"]

# Use official PHP image with FPM (FastCGI Process Manager) for better performance
FROM php:8.1-fpm

# Install system dependencies required by Laravel
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql

# Install Composer (dependency manager for PHP)
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set the working directory in the container
WORKDIR /var/www

# Copy the application code into the container
COPY . /var/www

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port 80 to the host machine
EXPOSE 80

# Command to run the Laravel application in production mode
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=80"]

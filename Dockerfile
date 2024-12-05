# Use the official PHP image with Apache
FROM php:7.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd zip pdo_mysql

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set the working directory
WORKDIR /var/www/html

# Copy Laravel files to the container
COPY . /var/www/html

# Set file permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache

# Update Apache DocumentRoot to point to Laravel public directory
RUN echo 'DocumentRoot /var/www/html/public' > /etc/apache2/sites-available/000-default.conf
RUN echo '<Directory /var/www/html/public>' >> /etc/apache2/sites-available/000-default.conf
RUN echo '    AllowOverride All' >> /etc/apache2/sites-available/000-default.conf
RUN echo '    Require all granted' >> /etc/apache2/sites-available/000-default.conf
RUN echo '</Directory>' >> /etc/apache2/sites-available/000-default.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Run Composer to install dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port 80
EXPOSE 80

CMD ["apache2-foreground"]

FROM php:8.2-apache

# Install MySQL drivers
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copy app files
COPY . /var/www/html/

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Enable Apache rewrite module
RUN a2enmod rewrite
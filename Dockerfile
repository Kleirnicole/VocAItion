FROM php:8.2-apache

# Install MySQL drivers
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copy your app files
COPY . /var/www/html/

# Enable Apache rewrite module
RUN a2enmod rewrite
FROM php:8.2-apache

# Install MySQL drivers
RUN docker-php-ext-install pdo pdo_mysql mysqli

# Copy only php-app contents into Apache root
COPY php-app/ /var/www/html/

# Enable Apache rewrite module
RUN a2enmod rewrite
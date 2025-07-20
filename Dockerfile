# Use official PHP with Apache
FROM php:8.1-apache

# Install MySQL extension
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache rewrite (if needed)
RUN a2enmod rewrite

# Copy all files into the container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html

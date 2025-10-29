# Dockerfile
FROM php:8.3-apache

# Install PDO MySQL
RUN docker-php-ext-install pdo pdo_mysql mysqli

# (optional) Enable Apache modules
RUN a2enmod rewrite
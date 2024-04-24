# Use an official PHP runtime as the base image
FROM php:7.4-apache

# Set the working directory in the container
WORKDIR /var/www/html

# Copy the current directory contents into the container at /var/www/html
COPY . /var/www/html

# Install any dependencies your application requires
RUN apt-get update \
    && apt-get install -y \
        zlib1g-dev \
        libpng-dev \
    && docker-php-ext-install \
        pdo_mysql \
        gd \
    && a2enmod rewrite

# Expose port 80 to the outside world
EXPOSE 80

# Start Apache service
CMD ["apache2-foreground"]
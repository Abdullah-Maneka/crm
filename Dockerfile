# Use an official PHP runtime as a parent image
FROM php:7.4-apache

# Set the working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && \
    apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libicu-dev \
        wget \
        unzip

# Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install -j$(nproc) \
        mysqli \
        gd \
        intl

# Install Composer globally
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install PHPUnit globally
RUN wget https://phar.phpunit.de/phpunit-9.phar && \
    chmod +x phpunit-9.phar && \
    mv phpunit-9.phar /usr/local/bin/phpunit

# Set the timezone (replace "Your/Timezone" with your actual timezone)
RUN echo "date.timezone = Your/Timezone" > /usr/local/etc/php/conf.d/timezone.ini

# Copy only the necessary files into the container
COPY . /var/www/html

# Set writable permissions for specific folders/files
RUN chmod -R 777 /var/www/html/files /var/www/html/index.php /var/www/html/app/Config

# Expose Apache port
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]



FROM php:7.4-apache

# Install required packages and extensions
RUN apt-get update && \
    apt-get install -y \
        curl \
        file \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libtidy-dev \
        nano \
        libonig-dev \
        libzip-dev \
        libicu-dev \
        unzip \
    && docker-php-ext-install \
        fileinfo \
        gd \
        iconv \
        json \
        mbstring \
        mysqli \
        pdo_mysql \
        tidy \
        zip \
        intl

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

COPY apache.conf /etc/apache2/sites-available/000-default.conf

# Enable mod_rewrite and mod_headers modules
RUN a2enmod rewrite headers

# Enable SSL module
RUN a2enmod ssl

# Copy PHP application files and Composer file
COPY --chown=www-data:www-data . /var/www/html/
COPY --chown=www-data:www-data composer.json /var/www/html/

# Set ownership and permissions for application files
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Install Composer dependencies
RUN su -s /bin/bash -c "composer install" www-data

# Expose ports for HTTP and HTTPS
EXPOSE 80
#EXPOSE 443

# Start Apache
CMD apachectl -D FOREGROUND

FROM php:8.1-apache

# Install ekstensi PHP untuk CI4
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Aktifkan rewrite
RUN a2enmod rewrite

# Copy semua file ke container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Ubah document root ke folder public (WAJIB untuk CI4)
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Set permission
RUN chown -R www-data:www-data /var/www/html

EXPOSE 80
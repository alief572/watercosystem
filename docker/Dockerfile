FROM php:7.4-apache

# Install extensions untuk MySQL dan lainnya
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Install ekstensi GD (untuk menangani gambar PNG dengan alpha channel)
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Install Imagick (jika lebih memilih Imagick daripada GD)
RUN apt-get update && apt-get install -y libmagickwand-dev \
    && pecl install imagick \
    && docker-php-ext-enable imagick

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Allow .htaccess overrides
RUN sed -i 's/AllowOverride None/AllowOverride All/g' /etc/apache2/apache2.conf
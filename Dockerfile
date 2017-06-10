FROM php:7.0-apache

RUN apt-get update && apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng12-dev \
        msmtp \
        ca-certificates \
        git zip unzip \
    && docker-php-ext-configure gd --with-freetype-dir=/usr/include/ --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install -j$(nproc) zip gd pdo pdo_mysql mysqli \
    && a2enmod rewrite \
    && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN usermod -u 1000 www-data
RUN groupmod -g 1000 www-data

COPY msmtp.conf /etc/

RUN chmod 600 /etc/msmtp.conf && chown www-data:www-data /etc/msmtp.conf

COPY php.ini /usr/local/etc/php/
COPY camagru/ /var/www/html/

RUN chmod +x /var/www/html/composerinstall.sh && cd /var/www/html/ && ./composerinstall.sh

EXPOSE 80
CMD ["apache2-foreground"]

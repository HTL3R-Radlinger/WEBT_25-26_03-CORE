FROM php:8.2-apache

RUN apt-get update -y && apt-get install -y openssl curl libpng-dev nano git cron sqlite3 zip unzip zlib1g-dev libpq-dev libicu-dev libzip-dev inetutils-ping graphicsmagick inkscape
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin/ --filename=composer

RUN docker-php-ext-install pdo pdo_pgsql pdo_mysql zip gd exif

COPY httpd-vhosts.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite

RUN echo "max_execution_time = 1200" > /usr/local/etc/php/conf.d/execution.ini
RUN echo "memory_limit = 2048M" >> /usr/local/etc/php/conf.d/execution.ini
RUN echo "post_max_size = 100M" >> /usr/local/etc/php/conf.d/execution.ini
RUN echo "upload_max_filesize = 100M" >> /usr/local/etc/php/conf.d/execution.ini

WORKDIR /var/www/html/

COPY . /var/www/html/

RUN rm 15_digital_meal_plan.pdf dockerfile docker-compose.yaml httpd-vhosts.conf README.md

RUN chown -R www-data:www-data *

ENTRYPOINT ["/usr/sbin/apache2ctl", "-D", "FOREGROUND"]
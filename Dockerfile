FROM php:8.2-apache
RUN docker-php-ext-install bcmath
COPY index.php /var/www/html/index.php
EXPOSE 80
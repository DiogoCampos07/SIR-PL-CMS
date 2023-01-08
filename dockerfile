FROM php:8.1-apache
RUN apt-get update && apt upgrade -y
RUN docker-php-ext-install pdo pdo_mysql

# start Apache2 on image start
CMD ["/usr/sbin/apache2ctl","-DFOREGROUND"]
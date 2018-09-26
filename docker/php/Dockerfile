FROM php:7.2-apache

# timezone Asia/Tokyo (https://qiita.com/prg_yukke/items/c23419d779d7f6972258)
ENV TZ Asia/Tokyo
RUN echo "${TZ}" > /etc/timezone \
  && dpkg-reconfigure -f noninteractive tzdata
ADD ./php.ini /usr/local/etc/php/php.ini

# document root (https://hub.docker.com/_/php/)
ENV APACHE_DOCUMENT_ROOT /php/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# install extensions (https://stackoverflow.com/questions/36674667/png-h-file-not-found-linux)
RUN apt-get update
RUN apt-get install -y libpng-dev
RUN docker-php-ext-install pdo_mysql mysqli mbstring gd

# enable mod_rewrite (http://murayama.hatenablog.com/entry/2015/09/10/081522)
RUN a2enmod rewrite

WORKDIR /php

CMD ["apache2-foreground"]

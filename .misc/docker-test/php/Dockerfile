FROM php:7.2

COPY php.ini /usr/local/etc/php/

RUN apt-get update -y
RUN apt-get install -y git zip
RUN rm -r /var/lib/apt/lists/*

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug
RUN docker-php-ext-install pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_ALLOW_SUPERUSER=1

COPY start.sh /opt/docker/
CMD ["/opt/docker/start.sh"]

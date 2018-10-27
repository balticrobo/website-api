FROM php:7.2

RUN apt-get update -y
RUN apt-get install -y zip git
RUN rm -r /var/lib/apt/lists/*

RUN docker-php-ext-install pdo_mysql

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ENV COMPOSER_ALLOW_SUPERUSER=1

CMD ["tail", "-F", "/dev/null"]

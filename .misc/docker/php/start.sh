#!/usr/bin/env bash

composer install

wait-for-it db:3306 -t 600
bin/console doctrine:migrations:migrate --no-interaction

php-fpm

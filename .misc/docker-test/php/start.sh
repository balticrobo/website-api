#!/usr/bin/env bash

composer install

bin/console lint:yaml config
vendor/bin/phpcs -p
vendor/bin/var-dump-check --symfony --laravel --doctrine src

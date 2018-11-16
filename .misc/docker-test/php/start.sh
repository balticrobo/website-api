#!/usr/bin/env bash

function run {
  echo "############ $1 ############" | tr '_' ' '
  shift
  eval $@
  quit_when_fail
}

function quit_when_fail {
  if [[ $? -ne 0 ]]; then
    echo "> Task failed!"
    exit 1
  fi
}

run Install_vendors_from_Composer composer install
run Lint_YAML_configs bin/console lint:yaml config
run PHP_CodeSniffer vendor/bin/phpcs -p
run VarDump_Check vendor/bin/var-dump-check --symfony src
run PHPUnit vendor/bin/phpunit

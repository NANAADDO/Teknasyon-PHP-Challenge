#!/bin/bash

docker exec -t app bash  -c  "php artisan config:cache;vendor/bin/phpunit"

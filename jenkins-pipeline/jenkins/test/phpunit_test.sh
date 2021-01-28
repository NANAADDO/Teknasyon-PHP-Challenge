#!/bin/bash

docker exec -t farm-grow bash  -c  "php artisan config:cache;vendor/bin/phpunit"

#!/bin/bash

composer install --working-dir=/var/www/html/rabbitmq-test && 
    cp /var/www/html/rabbitmq-test/.env.example /var/www/html/rabbitmq-test/.env &&
    /var/www/html/rabbitmq-test/artisan key:generate &&
    /var/www/html/rabbitmq-test/artisan migrate


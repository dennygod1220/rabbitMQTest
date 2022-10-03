# Rabbit MQ Test

## Description

- This is a RabbitMQ and Laravel Demo in a docker envirment.

## Install guide

- pre install docker on your mechine.
- git clone this project.
- cd rabbitMQTest
- docker-compose up -d
- docker exec -it rabmysql mysqladmin -uroot -pjason create rabbit_test
- docker exec -it rabphp80 sh /startup.sh

## .env config setting 
- /www/rabbitmq-test/.env

## Start listen queue 
- docker exec -it rabphp80 php /var/www/html/rabbitmq-test/artisan queue:work rabbitmq
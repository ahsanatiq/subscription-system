#!/bin/bash

printf "\n"
echo "copying environment files..."
printf "\n"
cp .env.example .env
printf "\n"
echo "building containers..."
printf "\n"
docker-compose up -d
printf "\n"
echo "installing dependencies..."
printf "\n"
docker exec -it ahsan-phpfpm-api-1 composer install
printf "\n"
echo "creating test database..."
printf "\n"
docker exec -it ahsan-mysql mysql -u root -pteknasyon -e "create database teknasyon_testing; GRANT ALL PRIVILEGES ON *.* TO 'teknasyon'@'%' IDENTIFIED BY 'teknasyon';"
printf "\n"
echo "migrating the required schema in database..."
printf "\n"
docker exec -it ahsan-phpfpm-api-1 php artisan migrate
docker exec -it ahsan-phpfpm-api-1 php artisan db:seed
printf "\n"
echo "done..."
printf "\n"

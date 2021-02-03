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
docker exec -it ahsan-trivago-php composer install
printf "\n"
echo "creating test database..."
printf "\n"
docker exec -it ahsan-trivago-mysql mysql -u root -ptrivago -e "create database trivago_testing; GRANT ALL PRIVILEGES ON *.* TO 'trivago'@'%' IDENTIFIED BY 'trivago';";
printf "\n"
echo "migrating the required schema in database..."
printf "\n"
docker exec -it ahsan-trivago-php php artisan doctrine:migrations:migrate
printf "\n"
echo "done..."
printf "\n"

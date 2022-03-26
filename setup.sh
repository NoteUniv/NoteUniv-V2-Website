#!/bin/bash

composer install
npm install

cp .env.example .env

echo "\n\n\033[0;31mPlease fill the .env with your environment configuration and press enter\n\n\n"
read

mkdir -p storage/app/private/

wget https://raw.githubusercontent.com/NoteUniv/NoteUniv-Excel/main/mecc_template.xlsx -O storage/app/private/mecc_template.xlsx
wget https://raw.githubusercontent.com/NoteUniv/NoteUniv-Excel/main/grades_template.xlsx -O storage/app/private/grades_template.xlsx

php artisan key:generate
php artisan storage:link
php artisan migrate
GENERATED_USER=$(php artisan db:seed)

npm run dev

xdg-open http://localhost:8000

echo $GENERATED_USER

php artisan serve

# Getting started

## Installation
Switch to the repo folder backend folder

    cd packages/backend

run the below commands

    docker run --rm -u "$(id -u):$(id -g)" -v "$(pwd):/var/www/html" -w /var/www/html laravelsail/php82-composer:latest composer install --ignore-platform-reqs

Start the docker cotainer

    ./vendor/bin/sail up -d  
    
Run migrations, setup passport and start the server on port 8000

    ./vendor/bin/sail artisan migrate:refresh --seed && ./vendor/bin/sail artisan passport:install --force  && ./vendor/bin/sail artisan serve --port=8000

Switch to frontend folder

    cd packages/frontend

Install packages and start the site

    npm i && npm run dev

Open your browser and start booking.
Login details

    email: test@example.com
    password: Password@1


#!/bin/bash

cd /vagrant

[[ ! -f .env ]] && cp .env.example .env

sudo npm install
bundle install
gulp

php artisan migrate
[[ ! -f /etc/laravel_db_seeded ]] && php artisan db:seed && touch /etc/laravel_db_seeded

exit 0;

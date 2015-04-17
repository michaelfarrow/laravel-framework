#!/bin/bash

cd /vagrant

sudo npm install
gulp

php artisan migrate
[[ ! -f /etc/laravel_db_seeded ]] && php artisan db:seed && touch /etc/laravel_db_seeded

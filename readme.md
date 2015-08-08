## Laravel Framework

[![Build Status](http://drone.mikefarrow.co.uk/api/badge/github.com/weyforth/laravel-framework/status.svg?branch=master)](http://drone.mikefarrow.co.uk/github.com/weyforth/laravel-framework)

Docker based Laravel framework, leveraging Composer and Bower for dependency management, and Gulp for build automation

## Production Environment Variables:

By default in production, environment variables are read from environment files (db.env & web.env) in the deploy users home directory (/home/deploy):

web.env
LF_ROOT_USER_NAME
LF_ROOT_USER_PASSWORD
LF_ROOT_USER_EMAIL
LF_APP_KEY

db.env
POSTGRES_PASSWORD

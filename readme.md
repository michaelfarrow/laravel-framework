## Laravel Framework

[![Build Status](http://drone.mikefarrow.co.uk/api/badge/github.com/weyforth/laravel-framework/status.svg?branch=master)](http://drone.mikefarrow.co.uk/github.com/weyforth/laravel-framework)

Docker based Laravel framework, leveraging Composer and Bower for dependency management, and Gulp for build automation

### Prerequisites

You must have Docker and Docker Compose installed before beginning.

### Getting Started

* Clone this repo
* cd into the root of the repo and run:

```bash
tools/build
tools/install
tools/start
```

The application should now be running. If you're using boot2docker, run `boot2docker ip` to get the ip address of the virtual machine.

### Tools

Composer, Artisan, NPM, Bower and Gulp all have proxy scripts located in `tools`, which will run the correct docker-compose commands. For example, to update composer dependencies, use:

```bash
tools/composer update
```

### Building

You can run `tools/gulp` at any time to build the application, including copying fonts and front-end assets and compiling CSS and JS. `tools/gulp watch` can be used to watch SCSS files to compile, and JS files to lint.

### Production Environment Variables

By default in production, environment variables are read from environment files (db.env & web.env) in the deploy users home directory (/home/deploy):

**web.env**  
LF_ROOT_USER_NAME  
LF_ROOT_USER_PASSWORD  
LF_ROOT_USER_EMAIL  
LF_APP_KEY

**db.env**  
POSTGRES_PASSWORD

### Deployment

Deployment using Drone CI is built into the framework. Simply edit the IP address of the server to deploy to in `drone.yml`. After you've setup the server and the repo in Drone, just push your code to automatically deploy. The database will be migrated on each run, and seeded on the first run.


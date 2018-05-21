# Random number with RabbitMQ

## Requirements

You need to install them to run project:

 - PHP
 - Composer
 - Docker
 - Docker Compose
 - Make
 
## Install

Install Composer dependencies

    make composer-install
Build Docker images with Docker Compose

    make docker-compose-build
Run Docker containers in foreground OR

    make docker-compose-up
Run Docker containers in background

    make docker-compose-up-d
 Stop Docker containers

    make docker-compose-stop

## Usage

Open this URL in your browser

    http://localhost
    
 Click to Generate Number button

## Unittest

Run PHP Unittest with this command

    make docker-compose-up-unittest
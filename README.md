# Create a basic Hotel API
- The Fontend team is working on a new application for accommodation listings, in this app any hotelier can manipulate the information that they want to display on our platforms.
   
## Acceptance criteria

- I can get all the items for the given hotelier.
- I can get a single item.
- I can create new entries.
- I can update information of any of my items.
- I can delete any item.
- A booking endpoint than whenever is called reduces the accommodation availability, and that fails if there is no availability. 

## Tech Stack 
- symfony 4.3 skeleton `https://symfony.com/releases/4.3`
 
## Manual Setup 
#### Prerequisites
- PHP version 7.x
- Mysql version 5.7 or version 8
- Composer `https://getcomposer.org/` 

#### Steps 
1. Clone the repo.
2. copy env file `cp .env.dist .env` ,and edit your credentials of mysql database. 
3. `composer install`
4. run the first setup shell script `./firstSetup.sh`
5. run server ` bin/console server:start`

Oh! you can find out the application in `http://localhost:8000`

## Setup by Docker/Docker-Compose
1. Clone the repo.
2. copy env file `cp .env.dist .env` ,and edit your credentials of mysql database. 
3. run `docker-compose build`
4. run `docker-compose up -d`
5. run `docker-compose run php composer install`
6. run `docker-compose up`

Oh! you can find out the application in `http://localhost:8888`

## Unit Testing

- To run the unit test case ,run `bin/phpunit`
- if you pre-setuped the application with docker ,run `docker-compose run php bin/phpunit`

## OpenAPI Spec
- you can find out the api described as YAML file using SWAGGER `https://swagger.io/`

## Credit
- Mohamed Essam Fathalla `mohamedessamfathalla@gmail.com`  
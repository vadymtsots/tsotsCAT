tsotsCAT - Computer Assisted Translation project

## Prerequisites
- Docker
- Docker Compose v2
- Make installed

## Installation
1. go to `/devstack` directory
2. copy .env.example to .env
3. make sure that nginx/apache2 and mysql are not running on your machine
4. run `make start-d` to start docker containers in detached mode and migrate the database
5. access the application at `http://tsots-cat.local`

## Elasticsearch index
For the first-time installation, the index must be created. To do that, inside the app container run `php bin/console fos:elastica:create`.
To fill the index, inside the app container run `php bin/console fos:elastica:populate`.
The index will be updated automatically on every create/update/delete operation on segments table.

## Adding documents
Currently, the system supports only txt files. To add a document, go to `http://tsots-cat.local/projects/create` and upload a txt file.
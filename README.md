# EditMasterApi

[![StyleCI](https://github.styleci.io/repos/148159653/shield?branch=master)](https://github.styleci.io/repos/148159653)
[![CircleCI](https://circleci.com/gh/solt9029/EditMasterApi.svg?style=svg)](https://circleci.com/gh/solt9029/EditMasterApi)

## Environment

- docker: 18.06.1-ce

- docker-compose: 1.22.0

- php-cs-fixer: 2.13.0

- php: 7.1.16

## Setup

- Docker

```sh
git clone git@github.com:solt9029/EditMasterApi.git
cd EditMasterApi
docker-compose build
docker-compose up -d
```

- PHP

```sh
docker-compose exec php bash
composer install
cp .env.example .env
vi .env # edit config here.
php artisan key:generate
php artisan migrate
exit
```

- MySQL

```sh
docker-compose exec mysql bash
mysql -uroot -pphpapptest editmaster < /docker/181115-insert-scores.sql # insert data dumped on 2018/11/15 into scores table.
exit
```

## PHPDocs

```sh
# install phpDocumentor.
cd vendor/bin
wget http://phpdoc.org/phpDocumentor.phar
cd ../../

php vendor/bin/phpDocumentor.phar -d . --ignore vendor/ -t phpdocs/ # generate document.
php -S localhost:8085 # check document.
```

## Test

```sh
touch database/database.sqlite
cp .env.testing.example .env.testing
vi .env.testing # edit config here.
composer phpunit
```

## Release

```sh
git tag v*.*
git push origin v*.*
```

## Backup

- on the server

```sh
cd /usr/share/nginx/html/EditMasterApi/
docker exec -it editmasterapi_mysql_1 bash
```

- on the mysql container

```sh
mysqldump -u root -pphpapptest --no-create-info editmaster scores > /docker/XXXXXX-insert-scores.sql
```

- on the local machine

```sh
scp root@solt9029.com:/usr/share/nginx/html/EditMasterApi/docker/mysql/XXXXXX-insert-scores.sql ~/Desktop
```

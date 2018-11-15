# EditMasterApi

[![StyleCI](https://github.styleci.io/repos/148159653/shield?branch=master)](https://github.styleci.io/repos/148159653)

## Environment

- docker: 18.06.1-ce

- docker-compose: 1.22.0

- php-cs-fixer: 2.13.0

- php: 7.1.16

## Setup
### Docker

```
git clone git@github.com:solt9029/EditMasterApi.git
cd EditMasterApi
docker-compose build
docker-compose up -d
```

## PHP

```
docker-compose exec php bash
composer install
cp .env.example .env
# edit .env file.
php artisan key:generate
php artisan migrate
exit
```

## MySQL

```
docker-compose exec mysql bash
mysql -uroot -pphpapptest editmaster < /docker/181115-insert-scores.sql # insert data dumped on 2018/11/15 into scores table.
exit
```

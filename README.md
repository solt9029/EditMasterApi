# EditMasterApi

## Environment

- docker: 18.06.1-ce

- docker-compose: 1.22.0

- php-cs-fixer: 2.13.0

- php: 7.1.16


## Setup

```
git clone git@github.com:solt9029/EditMasterApi.git
cd EditMasterApi
docker-compose build
docker-compose up -d
docker-compose exec php bash
```

```
composer install
cp .env.example .env
# edit .env file.
php artisan key:generate
```


## Database

- The database of old version system is automatically imported from /docker/mysql/180930.sql through Dockerfile.

- You no longer need to use artisan migrate commands.

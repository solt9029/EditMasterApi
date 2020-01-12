# EditMasterApi

[![StyleCI](https://github.styleci.io/repos/148159653/shield?branch=master)](https://github.styleci.io/repos/148159653)
[![CircleCI](https://circleci.com/gh/solt9029/EditMasterApi.svg?style=svg)](https://circleci.com/gh/solt9029/EditMasterApi)

## Environment

- docker: 18.06.1-ce

- docker-compose: 1.22.0

- php-cs-fixer: 2.13.0

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
cd src/vendor/bin
wget http://phpdoc.org/phpDocumentor.phar
cd ../../../

php src/vendor/bin/phpDocumentor.phar -d . --ignore src/vendor/ -t phpdocs/ # generate document.
cd phpdocs
php -S localhost:8085 # check document.
```

## Test

```sh
cd src
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

## Backup on VPS

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

## Docker

- PHP

```sh
PROJECT_ID=editmaster
APP=php
docker build -t gcr.io/${PROJECT_ID}/${APP}:latest -f docker/php/Dockerfile .
docker push gcr.io/${PROJECT_ID}/${APP}:latest
```

- MySQL

```sh
PROJECT_ID=editmaster
APP=mysql
cd docker/mysql
docker build -t gcr.io/${PROJECT_ID}/${APP}:latest .
docker push gcr.io/${PROJECT_ID}/${APP}:latest
```

## Deploy to GKE

- Using StorageClass

```sh
PROJECT_ID=editmaster
CLUSTER_NAME=editmaster-cluster
MACHINE_TYPE=n1-standard-1
NUM_NODES=3
ZONE=asia-northeast1-a

gcloud config set project $PROJECT_ID
gcloud container clusters create $CLUSTER_NAME \ 
 --machine-type=$MACHINE_TYPE \ 
 --num-nodes=$NUM_NODES \ 
 --zone=$ZONE
gcloud container clusters get-credentials $CLUSTER_NAME

cd kubernetes
cp secret.yaml.example secret.yaml
vi secret.yaml
cp configmap.yaml.example configmap.yaml
vi configmap.yaml

kubectl apply -f storage-class.yaml
kubectl apply -f secret.yaml
kubectl apply -f configmap.yaml
kubectl apply -f mysql.yaml
kubectl apply -f migration-job.yaml
kubectl apply -f php.yaml
kubectl apply -f ingress.yaml
```

- Using CloudSQL

```sh
PROJECT_ID=editmaster
CLUSTER_NAME=editmaster-cluster
MACHINE_TYPE=n1-standard-1
NUM_NODES=3
ZONE=asia-northeast1-a
NETWORK_NAME=editmaster-network
SUBNET_NAME=editmaster-subnet
REGION=asia-northeast1
RANGE=10.0.0.0/9

gcloud config set project $PROJECT_ID
gcloud compute networks create $NETWORK_NAME --subnet-mode custom
gcloud compute networks subnets create $SUBNET_NAME \
 --network $NETWORK_NAME \
 --region $REGION \
 --range $RANGE
gcloud compute firewall-rules create ${NETWORK_NAME}-rule \
 --network $NETWORK_NAME \
 --allow tcp:80,icmp
gcloud container clusters create $CLUSTER_NAME \
 --zone=$ZONE \
 --network=$NETWORK_NAME \
 --subnetwork=$SUBNET_NAME \
 --enable-ip-alias \
 --cluster-ipv4-cidr=/16 \
 --services-ipv4-cidr=/22 \
 --num-nodes=$NUM_NODES \
 --machine-type=$MACHINE_TYPE \
 --no-enable-basic-auth \
 --no-issue-client-certificate \
 --metadata disable-legacy-endpoints=true \
 --preemptible
gcloud container clusters get-credentials $CLUSTER_NAME

# create CloudSQL instance using PrivateIP on dashboard.

cd kubernetes
cp secret.yaml.example secret.yaml
vi secret.yaml
cp configmap.yaml.example configmap.yaml
vi configmap.yaml

kubectl apply -f secret.yaml
kubectl apply -f configmap.yaml
kubectl apply -f migration-job.yaml
kubectl apply -f php.yaml
kubectl apply -f ingress.yaml
```

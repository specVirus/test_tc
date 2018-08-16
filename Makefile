SHELL := /bin/bash
######### [ DOCKER TOOLS ] ###################################################
files-init:
	sudo mkdir -p docker/logs
	sudo mkdir -p docker/db
	sudo mkdir -p docker/rabbitdb
	sudo touch docker/logs/site_access.log
	sudo touch docker/logs/site_error.log
	sudo touch docker/logs/api_access.log
	sudo touch docker/logs/api_error.log
	sudo touch docker/logs/xdebug.log

docker-stack-deploy:
	./docker/installScripts/create_stack.sh $(shell pwd)

docker-stack-deploy-teamcity:
	sudo docker-compose -f stack.teamcity.yml up -d

docker-terminal:
	sudo docker exec -ti $(shell sudo docker ps -f "name=testtc_php_1" --format "{{.Names}}") /bin/bash

docker-terminal-redis:
	sudo docker exec -ti $(shell sudo docker ps -f "name=testtc_redis_1" --format "{{.Names}}") /bin/bash

docker-terminal-rabbit:
	sudo docker exec -ti $(shell sudo docker ps -f "name=testtc_rabbitmq_1" --format "{{.Names}}") /bin/bash

docker-stack-rm:
	sudo docker-compose -f stack.example.yml down

docker-daemon-restart:
	sudo docker-compose -f stack.example.yml restart php-daemon

docker-cron-restart:
	sudo docker-compose -f stack.example.yml restart php-cron

docker-service-ls:
	sudo docker-compose -f stack.example.yml ps

docker-logs-daemon:
	sudo docker-compose -f stack.example.yml logs -f  php-daemon

docker-logs:
	sudo docker-compose -f stack.example.yml logs -f  php

docker-logs-nginx:
	sudo docker-compose -f stack.example.yml logs -f  nginx

docker-logs-rabbit:
	sudo docker-compose -f stack.example.yml logs -f  rabbit

docker-stack-restart:
	make docker-stack-rm
	make docker-stack-deploy

docker-status:
	sudo docker ps -f "name=testtc_"

docker-image-build:
	sudo docker build -t iwaydev/yii2-iway-template-php-fpm ./docker/builds/php
	sudo docker build -t iwaydev/yii2-iway-template-php-daemon-sample ./docker/builds/php-daemon-sample
	sudo docker build -t iwaydev/yii2-iway-template-postgres ./docker/builds/postgres
	sudo docker pull iwaydev/base-apidoc

docker-image-rm:
	sudo docker image rm iwaydev/yii2-iway-template-php-fpm --force
	sudo docker image rm iwaydev/yii2-iway-template-php-daemon-sample --force
	sudo docker image rm iwaydev/yii2-iway-template-postgres --force
	sudo docker image rm iwaydev/base-apidoc --force

######### [ DEPLOY TOOLS ] ###################################################

#Отбросить незафиксированные изменения
git-reset:
	git reset --hard

#Затянуть ветку master
git-pull-master:
	git pull origin master

#Затянуть ветку develop
git-pull-develop:
	git pull origin develop

#Установить зависимости
composer-install:
	composer.phar install --no-dev

#Установить зависимости, включая девелоперские
composer-install-dev:
	composer install

#Инициализировать окружение dev
yii-init-dev:
	php $(CURDIR)/init --env=Development -y --interactive=0

#Инициализировать окружение prod
yii-init-prod:
	php $(CURDIR)/init --env=Production -y --interactive=0

#Применить миграции
yii-migrate:
	php $(CURDIR)/yii migrate --interactive=0

#Применить миграции на тестовой базе
yii-test-migrate:
	php $(CURDIR)/yii_test migrate --interactive=0

#Инициализировать RBAC
yii-rbac-init:
	rm -rf $(CURDIR)/console/rbac/items.php
	rm -rf $(CURDIR)/console/rbac/rules.php
	rm -rf $(CURDIR)/console/rbac/assigments.php
	php $(CURDIR)/yii rbac/init

#Сбросить весь кеш
yii-cache-flush-all:
	php $(CURDIR)/yii cache/flush-all --interactive=0

#Удалить ассеты
rm-assets:
	rm -rf $(CURDIR)/api/web/assets/*
	rm -rf $(CURDIR)/site/web/assets/*

#Сгенерировать apiDoc для точки входа API
apidoc-api:
	sudo docker run -it --rm --name apidoc -v "$(PWD)":/var/www/yii2-iway-template -w /var/www/yii2-iway-template iwaydev/yii2-iway-template-apidoc apidoc -i ./api/ -o ./build/artifacts/apidoc/api/

#Сгенерировать swagger.json для точки входа API
swagger:
	php $(CURDIR)/vendor/bin/swagger --stdout $(CURDIR)/api > $(CURDIR)/build/artifacts/swagger.json

#Анализатор кода на соотвествие PSR-2
phpcs:
	./vendor/squizlabs/php_codesniffer/bin/phpcs --config-set ignore_errors_on_exit 1
	./vendor/squizlabs/php_codesniffer/bin/phpcs -p --extensions=php --standard=PSR2 --error-severity=1 --warning-severity=0 ./common ./api ./site ./console > $(CURDIR)/build/artifacts/phpcs.txt

#Анализатор качества кода
phpmd:
	php $(CURDIR)/vendor/phpmd/phpmd/src/bin/phpmd --ignore-violations-on-exit $(CURDIR)/common,$(CURDIR)/api,$(CURDIR)/site,$(CURDIR)/console html codesize,cleancode,naming,unusedcode,design > $(CURDIR)/build/artifacts/phpmd.html

#Сгенерировать swagger.json для точки входа API
phpmetrics:
	$(CURDIR)/vendor/phpmetrics/phpmetrics/bin/phpmetrics --report-html=$(CURDIR)/build/artifacts/metrics ./common ./console ./api ./site

#Подготовить окружение к запуску тестов
codecept-build:
	$(CURDIR)/vendor/bin/codecept build

#Подготовить окружение к запуску тестов
codecept-run:
	$(CURDIR)/vendor/bin/codecept run

#Запуск тестов с проверкой покрытия кода тестами и формированием отчета
codecept-run-coverage-html:
	$(CURDIR)/vendor/bin/codecept run --coverage-html

build-local: yii-init-dev composer-install-dev yii-rbac-init yii-migrate yii-test-migrate yii-cache-flush-all rm-assets swagger phpcs phpmd phpmetrics
build-dev: git-reset git-pull-develop yii-init-dev yii-rbac-init composer-install-dev yii-migrate yii-test-migrate yii-cache-flush-all rm-assets swagger phpcs phpmd phpmetrics codecept-build codecept-run
build-prod: git-reset git-pull-master yii-init-dev yii-rbac-init composer-install yii-migrate yii-cache-flush-all rm-assets
test: yii-test-migrate codecept-build codecept-run
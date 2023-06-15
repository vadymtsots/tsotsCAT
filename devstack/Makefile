SHELL := /bin/bash
CURDIR := $(shell pwd)
include $(CURDIR)/.env

PROJECT_DIR_PATH := $(PROJECT_DIR_PATH)
PROJECT_DIR := $(PROJECT_DIR)
PROJECT_REPOSITORY_URL := $(PROJECT_REPOSITORY_URL)

test:
	echo $(HOSTNAME);

setup:
	make create-project
	@make start-d

create-project:
	set -ex;\
    	if [ ! -d ${PROJECT_DIR_PATH} ]; then \
    		echo "Missing ${PROJECT_DIR}. Creating...";\
    		cd ..; \
    		git clone ${PROJECT_REPOSITORY_URL} ${PROJECT_DIR};\
    		cd $(CURDIR); \
    	fi;\

	cd ./${PROJECT_DIR_PATH};\
	set +ex;

start-d:
	make prepare-nginx
	@make prepare-env
	@docker compose build app
	@docker compose up -d
	@docker compose exec app composer install
	@echo "Wait on setup database" && sleep 5
	@docker exec app php bin/console doctrine:migrations:migrate

quick-start-d:
	make prepare-nginx
	@make prepare-env
	@docker compose build app
	@docker compose up -d

my-sql:
	docker compose exec db mysql -u${DB_USERNAME} -p${DB_PASSWORD}

stop:
	docker compose down

bash:
	docker exec -ti "$(DOCKER_PREFIX)-app" bash

update:
	docker compose build app
	@docker compose up -d

restart:
	make stop
	@make start-d

quick-restart:
	make stop
	@make quick-start-d

destroy:
	docker stop $(docker ps -a -q)
	@docker rm $(docker ps -a -q)
	@docker rmi $(docker images -q)

prepare-nginx:
	set -ex;\
		if [ ! -f './nginx/conf.d/app.conf' ]; then \
			echo "---> Missing nginx configuration. Creating...";\
			cp ./nginx/conf.d/app.stub ./nginx/conf.d/app.conf; \
		fi;\

	set +ex; \
	if [[ "$OSTYPE" == "darwin"* ]]; then \
      sed -i "" "s/{PROJECT_NAME}/${PROJECT_DIR}/g" ./nginx/conf.d/app.conf; \
	  sed -i "" "s/{HOSTNAME}/${HOSTNAME}/g" ./nginx/conf.d/app.conf; \
    else \
      sed -i -e "s/{PROJECT_NAME}/${PROJECT_DIR}/g" ./nginx/conf.d/app.conf; \
      sed -i -e "s/{HOSTNAME}/${HOSTNAME}/g" ./nginx/conf.d/app.conf; \
    fi

prepare-env:
	set -ex;\
    	if [ ! -f ./${PROJECT_DIR_PATH}/.env ]; then \
			(cp ./${PROJECT_DIR_PATH}/.env.example ./${PROJECT_DIR_PATH}/.env || true) \
    	fi;\
	set +ex;

root:
	docker exec -ti --user root ${PROJECT_DIR}-app ${command};
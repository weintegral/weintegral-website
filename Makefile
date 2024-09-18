#------------------------------------------------------------------------------------------#
# Print list of available tasks in this Makefile
#------------------------------------------------------------------------------------------#
.PHONY: list
commands:
	@echo ''
	@echo '-------------------------------------------------------------------------------'
	@echo 'Available Commands:'
	@echo '-------------------------------------------------------------------------------'
	@echo ''
	@LC_ALL=C $(MAKE) -pRrq -f $(lastword $(MAKEFILE_LIST)) : 2>/dev/null | awk -v RS= -F: '/^# File/,/^# Finished Make data base/ {if ($$1 !~ "^[#.]") {print $$1}}' | sort | egrep -v -e '^[^[:alnum:]]' -e '^$@$$'
	@echo ''
	@echo '-------------------------------------------------------------------------------'

list:
	@echo ''
	@echo '=============================================================================='
	@echo 'Docker Commands'
	@echo '=============================================================================='
	@echo 'webserver_login : Login to Web Server Container'
	@echo ''
	@echo 'sqlserver_login : Login to SQL Server Container'
	@echo ''
	@echo 'migrations_run : Run Database Migrations'
	@echo ''
	@echo 'dependencies_install : Install Project Dependencies'
	@echo ''
	@echo 'docker_rebuild_containers : Rebuild Docker Containers'
	@echo ''
	@echo 'docker_rebuild_images : Rebuild Docker Images'
	@echo ''
#------------------------------------------------------------------------------------------#

#------------------------------------------------------------------------------------------#
# Docker Commands
#------------------------------------------------------------------------------------------#

# View list of docker processes
webserver_login:
	docker compose exec -it we-webserver bash

# View docker CPU usage
sqlserver_login:
	docker compose exec -it we-sql-server bash

# Delete all containers
migrations_run:
	docker compose exec -it we-webserver php artisan migrate

# Delete all images
dependencies_install:
	docker compose exec -it we-webserver composer install
	docker compose exec -it we-webserver npm install

docker_rebuild_containers:
	docker compose down
	docker system prune -a -f
	docker volume prune -a -f
	docker compose up -d

docker_compose_rebuild:
	docker compose down
	docker system prune -a -f
	docker volume prune -a -f
	docker compose build --no-cache
	docker compose up -d

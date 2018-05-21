PATH_DOCKER_COMPOSE_FILE = $(PATH_DOCKER)/docker-compose.yml
PATH_DOCKER_COMPOSE_FILE_UNITTEST = $(PATH_DOCKER)/docker-compose-unittest.yml

CMD_DOCKER_COMPOSE_FILE = $(CMD_DOCKER_COMPOSE) -f $(PATH_DOCKER_COMPOSE_FILE)
CMD_DOCKER_COMPOSE_FILE_UNITTEST = $(CMD_DOCKER_COMPOSE) -f $(PATH_DOCKER_COMPOSE_FILE_UNITTEST)

docker-compose-build:
	$(CMD_DOCKER_COMPOSE_FILE) build

docker-compose-up:
	$(CMD_DOCKER_COMPOSE_FILE) up

docker-compose-up-unittest:
	$(CMD_DOCKER_COMPOSE_FILE_UNITTEST) up

docker-compose-up-d:
	$(CMD_DOCKER_COMPOSE_FILE) up  -d

docker-compose-stop:
	$(CMD_DOCKER_COMPOSE_FILE) stop

docker-compose-rm:
	$(CMD_DOCKER_COMPOSE_FILE) rm

help-docker-compose:
	@echo "$(TEXT_FORMAT_BOLD)docker-compose-build$(TEXT_FORMAT_NORMAL)  		        - Builds containers"
	@echo "$(TEXT_FORMAT_BOLD)docker-compose-up$(TEXT_FORMAT_NORMAL)  		        - Builds and starts containers"
	@echo "$(TEXT_FORMAT_BOLD)docker-compose-up-d$(TEXT_FORMAT_NORMAL)  		        - Docker compose up with detached mode"
	@echo "$(TEXT_FORMAT_BOLD)docker-compose-stop$(TEXT_FORMAT_NORMAL)  		        - Stops running containers"
	@echo "$(TEXT_FORMAT_BOLD)docker-compose-rm$(TEXT_FORMAT_NORMAL)  		        - Removes stopped containers"
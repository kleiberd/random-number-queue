default: help

THIS_MAKEFILE_PATH = $(word 1,$(MAKEFILE_LIST))
PATH_ROOT = $(shell cd $(dir $(THIS_MAKEFILE_PATH));pwd)

PATH_APP = $(PATH_ROOT)/app
PATH_DOCKER = $(PATH_ROOT)/docker
PATH_MISC = $(PATH_ROOT)/misc

include $(PATH_MISC)/Variables.mk
include $(PATH_MISC)/CsFix.mk
include $(PATH_MISC)/Composer.mk
include $(PATH_DOCKER)/Docker-compose.mk

help: help-cs-fix help-composer help-docker-compose

CMD_CS_FIX = $(CMD_PHP) $(PATH_VENDOR_BIN)/php-cs-fixer

composer-install:
	cd $(PATH_APP) && $(CMD_COMPOSER) install --ignore-platform-reqs

composer-update:
	cd $(PATH_APP) && $(CMD_COMPOSER) update --ignore-platform-reqs

help-composer:
	@echo "$(TEXT_FORMAT_BOLD)composer-install$(TEXT_FORMAT_NORMAL)  		        - Run Composer install"
	@echo "$(TEXT_FORMAT_BOLD)composer-update$(TEXT_FORMAT_NORMAL)  		        - Run Composer update"
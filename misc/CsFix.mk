PATH_VENDOR = $(PATH_APP)/vendor
PATH_VENDOR_BIN = $(PATH_VENDOR)/bin

CMD_CS_FIX = $(CMD_PHP) $(PATH_VENDOR_BIN)/php-cs-fixer

cs-fix:
	$(CMD_CS_FIX) fix --config $(PATH_APP)/.php_cs.dist

help-cs-fix:
	@echo "$(TEXT_FORMAT_BOLD)cs-fix$(TEXT_FORMAT_NORMAL)  		        	- Run PHP-CS-Fixer"
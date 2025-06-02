run:
	@echo "STARTING THE PROJECT"
	@echo "- Installing dependencies"
	php composer.phar install
	@echo "- Running migrations"
	./vendor/bin/phpmig migrate
	@echo "- Starting the server"
	php -S localhost:8080 -t . index.php

test:
	./vendor/bin/phpunit


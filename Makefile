SHELL = /bin/bash

.PHONY: start-mysql test fix

start-mysql:
	docker run -itd --rm --name dbal-fixtures-mysql -e MYSQL_ROOT_PASSWORD=dbal-fixtures -e MYSQL_USER=dbal-fixtures -e MYSQL_PASSWORD=dbal-fixtures -e MYSQL_DATABASE=test_fixture -p 3306:3306 mysql:5.7

test:
	@php bin/phpunit

fix:
	@php-cs-fixer fix src --rules=@PSR2,no_unused_imports
	@php-cs-fixer fix tests --rules=no_unused_imports

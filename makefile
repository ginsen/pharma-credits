## —— Pharma Credits ———————————————————————————————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

install: composer.lock ## Install vendors according to the current composer.lock file
	composer install

update: composer.json ## Update vendors according to the current composer.json file
	composer update

sf: ## List Symfony commands
	bin/console

cc: ## Clear cache
	bin/console c:c

warmup: ## Warmump the cache
	bin/console cache:warmup

fix-perms: ## Fix permissions of all var files
	chmod -R 777 var/*

start: ## Start the local Symfony web server
	bin/console server:start

stop: ## Stop the local Symfony web server
	bin/console server:stop

purge: ## Purge cache and logs
	rm -rf var/cache/* var/logs/*

load-fixtures: ## Build the db, validate schema db, load fixtures and check migration
	bin/console doctrine:database:create --if-not-exists
	bin/console doctrine:schema:drop --force
	bin/console doctrine:schema:create
	bin/console doctrine:schema:validate
	bin/console doctrine:migration:status
	bin/console doctrine:fixtures:load -n

cs: ## Launch check style and static analysis
	bin/php-cs-fixer --no-interaction --dry-run --diff -v fix

cs-fix: ## Executes cs fixer
	bin/php-cs-fixer --no-interaction --diff -v fix

dc: ## Launch Deptrac to check relations and dependencies between DDD layers
	bin/deptrac

test: phpunit.xml.dist ## Launch all functionnal and unit tests
	bin/phpunit --stop-on-failure --testdox

scanner: ## Launch sonar-scanner after phpunit
	bin/phpunit
	sonar-scanner

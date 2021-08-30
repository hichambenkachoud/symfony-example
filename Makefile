it:
	$(MAKE) prepare-dev
	$(MAKE) analyze

tests:
	$(MAKE) prepare-test
	$(MAKE) analyze
	php bin/phpunit

.PHONY: analyze
analyze:
	composer valid
	php bin/console doctrine:schema:valid
	php vendor/bin/phpcs


.PHONY: prepare-dev
prepare-dev:
	npm install
	npm run dev
	php bin/console cache:clear --env=dev
	php bin/console doctrine:database:drop --if-exists -f --env=dev
	php bin/console doctrine:database:create --env=dev
	php bin/console doctrine:schema:update -f --env=dev
	php bin/console doctrine:fixtures:load -n --env=dev

.PHONY: prepare-test
prepare-dev:
	npm install
	npm run dev
	php bin/console cache:clear --env=test
	php bin/console doctrine:database:drop --if-exists -f --env=test
	php bin/console doctrine:database:create --env=test
	php bin/console doctrine:schema:update -f --env=test
	php bin/console doctrine:fixtures:load -n --env=test

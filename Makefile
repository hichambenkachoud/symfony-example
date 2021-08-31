.PHONY: it
it:
	$(MAKE) prepare-dev
	$(MAKE) analyze

.PHONY: tests
tests:
	$(MAKE) prepare-test
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
	composer install --prefer-dist
	php bin/console doctrine:database:drop --if-exists -f --env=dev
	php bin/console doctrine:database:create --env=dev
	php bin/console doctrine:schema:update -f --env=dev
	php bin/console doctrine:fixtures:load -n --env=dev

.PHONY: prepare-test
prepare-test:
	npm install
	npm run dev
	composer install --prefer-dist
	php bin/console doctrine:database:drop --if-exists -f --env=test
	php bin/console doctrine:database:create --env=test
	php bin/console doctrine:schema:update -f --env=test
	php bin/console doctrine:fixtures:load -n --env=test

.PHONY: translations
translations:
	php bin/console translation:update --force fr

name := laravel.test
sail := ./vendor/bin/sail
run := run $(name)

docker:
	docker run --rm -u "$(id -u):$(id -g)" -v $(pwd):/var/www/html -w /var/www/html laravelsail/php81-composer:latest; composer install --ignore-platform-reqs

up:
	$(sail) up -d

build:
	$(sail) build

composer:
	$(sail) composer install -o

install: docker up build composer

down:
	$(sail) down

stop:
	$(sail) stop

bash:
	$(sail) $(run) bash

test:
	$(sail) $(run) php artisan test

restart: down install

phpcsfixer:
	$(sail) $(run) php artisan fixer:fix --no-interaction --allow-risky=yes --dry-run --diff

phpcsfixer_fix:
	$(sail) $(run) php artisan fixer:fix --no-interaction --allow-risky=yes --ansi

larastan:
	$(sail) $(run) ./vendor/bin/phpstan analyse

psalm:
	$(sail) $(run) ./vendor/bin/psalm

preparedb:
	$(sail) php artisan cache:forget spatie.permission.cache; $(sail) artisan migrate --seed

preparedbtest:
	$(sail) artisan migrate --env=testing

wipe:
	$(sail) $(run) php artisan db:wipe

clearcache:
	$(sail) $(run) php artisan cache:forget spatie.permission.cache; $(sail) $(run) php artisan cache:clear

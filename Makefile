name := laravel.test
sail := ./vendor/bin/sail
exec := exec $(name)

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
	$(sail) $(exec) bash

test:
	$(sail) $(exec) php artisan test --parallel

restart: down install

phpcsfixer:
	$(sail) $(exec) php artisan fixer:fix --no-interaction --allow-risky=yes --dry-run --diff

phpcsfixer_fix:
	$(sail) $(exec) php artisan fixer:fix --no-interaction --allow-risky=yes --ansi

larastan:
	$(sail) $(exec) ./vendor/bin/phpstan analyse

psalm:
	$(sail) $(exec) ./vendor/bin/psalm

preparedb:
	$(sail) php artisan cache:forget spatie.permission.cache; $(sail) artisan migrate --seed

preparedbtest:
	$(sail) artisan migrate --env=testing

wipe:
	$(sail) $(exec) php artisan db:wipe

clearcache:
	$(sail) $(exec) php artisan cache:forget spatie.permission.cache; $(sail) $(exec) php artisan cache:clear

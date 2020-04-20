setup:
	composer install
	cp -n .env.example .env
	php artisan key:gen --ansi
	cp .env .env.testing
	touch database/database.sqlite || true
	php artisan migrate

serve:
	php artisan serve

migrate:
	php artisan migrate

console:
	php artisan tinker

test:
	php artisan test

coverage:
	vendor/bin/phpunit

deploy:
	git push heroku

lint:
	composer phpcs -- --standard=PSR12 app database/factories routes tests

lint-fix:
	composer phpcbf app/Http/Controllers tests

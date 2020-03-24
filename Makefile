setup:
	composer install

serve:
	php artisan serve

migrate:
	php artisan migrate

console:
	php artisan tinker

test:
	php artisan test

deploy:
	git push heroku

lint:
	composer phpcs -- --standard=PSR12 app/Http/Controllers tests

lint-fix:
	composer phpcbf app/Http/Controllers tests

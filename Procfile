# web: php artisan serve --host=0.0.0.0 --port=$PORT
web: vendor/bin/heroku-php-apache2 public/
scheduler: php -d memory_limit=512M artisan schedule:daemon

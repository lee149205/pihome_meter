php -r "file_exists('.env') || copy('./docker/.env.example', '.env');"
chmod -R 777 storage
composer clear-cache
composer install
php artisan cache:clear
php artisan config:clear
composer run-script post-create-project-cmd
php artisan migrate
php artisan db:seed


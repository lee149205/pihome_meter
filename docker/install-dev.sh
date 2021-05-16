composer clear-cache
composer install
php artisan cache:clear
php artisan config:clear
composer run-script post-create-project-cmd
php artisan migrate:fresh
php artisan db:seed
php artisan db:seed --class=DevSeeder


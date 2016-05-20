@servers(['dev' => ''])

@task('deploydev', ['on' => 'dev', 'confirm' => true])
cd /web/
git pull
composer update
php artisan migrate --force
@endtask
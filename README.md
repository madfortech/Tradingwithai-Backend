php artisan native:install --force
php artisan native:run android
php artisan native:watch
php artisan optimize:clear
php artisan route:clear
php artisan cache:clear
php artisan view:clear
php artisan config:clear

adb shell pm list packages
adb devices

stripe listen --forward-to https://tradewithai.test/stripe/webhook

stripe listen --forward-to https://tradewithai.test/stripe/webhook


git push
ssh -o StrictHostKeyChecking=no  root@admin.inter-nat.com "
        cd /var/www/html/innter_nat_admin/&&
        git fetch --all &&
        git checkout -f transi &&
        git pull &&
        php artisan config:cache &&
        php artisan view:cache &&
        php artisan route:cache &&
        php artisan schedule:run &&
        php artisan migrate &&
        php artisan adhoc:run 4 &&
        composer install --ignore-platform-reqs &&
        npm run  dev &&
        chmod -R 777 ."

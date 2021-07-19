set -e

echo "Deploying Application ...."


#Enter maintenance mode
(php artisan down --message "The application is quickly being updated! Please try again in a min") || true

#update codebase

#Exit maintenance mode

php artisan up

echo "Updates Deployed"

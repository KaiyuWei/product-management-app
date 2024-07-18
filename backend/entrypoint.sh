#!/bin/bash

# Wait for the database to be ready
/usr/local/bin/wait-for-it.sh db:3306 --timeout=60 --strict -- echo "Database is up"

php artisan migrate

php artisan serve --host=0.0.0.0 --port=8000

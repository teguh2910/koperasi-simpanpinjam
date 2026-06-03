#!/bin/bash

echo "=== Installing Laravel Dependencies ==="
docker-compose run --rm composer install --no-interaction

echo "=== Starting Containers ==="
docker-compose up -d --build

echo "=== Generating App Key ==="
docker-compose exec app sh -c "php artisan key:generate"

echo "=== Running Migrations ==="
docker-compose exec app sh -c "php artisan migrate --force"

echo "=== Seeding Database ==="
docker-compose exec app sh -c "php artisan db:seed --force"

echo "=== Setup Complete ==="
echo "Website: http://localhost:8080"
echo "pgAdmin: http://localhost:5050"
echo ""
echo "Admin Login: admin@koperasi.com / password"
build: 
	docker-compose up -d --build
	composer install
	docker exec cs2_skin_helper_app php artisan key:generate
	# docker exec cs2_skin_helper_app php artisan migrate

rebuild:
	docker-compose down
	docker-compose up -d --build
	composer update
	docker exec cs2_skin_helper_app php artisan key:generate
	# docker exec cs2_skin_helper_app php artisan migrate

laravel:
	docker exec -it cs2_skin_helper_app bash

nginx:
	docker exec -it cs2_skin_helper_nginx bash

db:
	docker exec -it cs2_skin_helper_db bash
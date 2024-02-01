build: 
	docker-compose up -d --build
	composer install

rebuild:
	docker-compose down
	docker-compose up -d --build
	composer update

app bash:
	docker exec -it cs2_skin_helper_app bash

nginx bash:
	docker exec -it cs2_skin_helper_nginx bash
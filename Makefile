build: 
	docker-compose up -d --build
	composer install

rebuild:
	docker-compose down
	docker-compose up -d --build
	composer update

app:
	docker exec -it cs2_skin_helper_app bash

nginx:
	docker exec -it cs2_skin_helper_nginx bash

db:
	docker exec -it cs2_skin_helper_db bash
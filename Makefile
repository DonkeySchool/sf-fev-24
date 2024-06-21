install:
	symfony composer install
	symfony console lexik:jwt:generate-keypair
	make rebuild
	npm install
	npm run dev

rebuild:
	symfony console doctrine:database:drop -f
	symfony console doctrine:database:create
	symfony console doctrine:schema:update -f
	symfony console doctrine:fixtures:load -n

run:
	symfony serve --allow-http
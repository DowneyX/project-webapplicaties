build:
	npm install
	composer install

run:
	npm run dev
	php -S localhost:9000 -t ./public
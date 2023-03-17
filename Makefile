build:
	npm install
	composer install

run:
	npm run watch &
	php -S localhost:9000 -t ./public

connect:
	ssh -fN -L 3306:localhost:3306 shambuwu@shambuwu.com -p 18501
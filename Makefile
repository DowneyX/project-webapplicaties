build:
	npm install
	composer install --no-scripts

run:
	npm run watch &
	php -S localhost:9000 -t ./public

connect:
	ssh -fN -L 3307:localhost:3306 shambuwu@shambuwu.com -p 18501
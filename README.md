# IWA Monolith

Codebase for IWA's monolithic weather data application. Please read this README thoroughly.




## Run Locally

Clone the project

```bash
  git clone https://github.com/DowneyX/project-webapplicaties.git
```

Go to the project directory

```bash
  cd project-webapplicaties
```

Install dependencies

```bash
  composer install
```

Start the server

```bash
  # Use any WSGI server like NGINX, Apache or Gunicorn to serve this application. 
  # For development purposes we use the built-in php web server
  php -s 0.0.0.0:8000 -t ./public
```


## Authors

- [@Shambuwu](https://www.github.com/Shambuwu)


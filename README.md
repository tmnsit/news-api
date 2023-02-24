### Instalation local

- git clone git@github.com:tmnsit/news-api.git
- cd news-api
- composer install
- docker compose up
- cp .env.example .env
- php artisan migration

add crontab row "* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1"
- crontab -e
- php artisan key:generate
- php artisan serve

go to http://127.0.0.1:8000/api/documentation



<h1>Инструкции по запуску</h1>

Перед запуском убедитесь в том, что у вас установлены:
  - [Docker](https://docs.docker.com/engine/install/)
  - [Docker Compose](https://docs.docker.com/compose/install/)
  - [Git](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git)

Для первого запуска скопируйте в терминал следующее:
```shell
git clone -b master https://github.com/rexxless/api_php.git
cd api_php/project
cp .env.example .env # Если будет необходимо внести изменения в окружение, редактируйте файл .env (Не .env-example)!
cd ../deploy
docker compose up -d --build
docker compose exec app composer install 
docker compose exec app php artisan jwt:secret
```

Для запуска миграций и заполнения БД тестовыми данными скопируйте в терминал следующее:
```shell
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
```

Для всех последующих запусков достаточно скопировать в терминал следующее:
```shell
cd api_php/deploy
docker compose up
```

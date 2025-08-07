#  Инструкция по установке приложения

1) выполните команду 
composer install

2) на основе файла .env.example создайте файл .env и подставьте свои данные

3) выполните команду 
./vendor/bin/sail up -d

4) выполните миграции:
./vendor/bin/sail artisan migrate

5) чтобы миграции выполнились вместе с заполнением базы данных фейковыми данными, выполните:
./vendor/bin/sail artisan migrate:fresh --seed

6) Запуск тестов:
./vendor/bin/sail artisan test

7) После запуска контейнеров приложение будет доступно по адресу:
http://localhost


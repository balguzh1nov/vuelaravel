# Тестовое задание Laravel + Vue

## Установка и запуск

### Шаг 1: Клонирование репозитория
```sh
git clone https://github.com/balguzh1nov/vuelaravel
cd vuelaravel

--Создайте файл .env в папке purchases на основе .env.example и настройте его:
cp purchases/.env.example purchases/.env

-- Убедитесь, что переменные окружения для PostgreSQL в файле .env правильно настроены:
DB_CONNECTION=pgsql
DB_HOST=db
DB_PORT=5432
DB_DATABASE=laravel
DB_USERNAME=your_username
DB_PASSWORD=your_password

### Шаг 2: Запуск Docker контейнеров
docker-compose up --build

--Выполнение миграций базы данных
docker-compose exec app php artisan migrate --seed

```

![image](https://github.com/balguzh1nov/vuelaravel/assets/118799235/acf90837-3ed2-4955-8f0b-239fb0d03f95)
![image](https://github.com/balguzh1nov/vuelaravel/assets/118799235/a442447a-f0df-48e7-83cb-80145404b326)
![image](https://github.com/balguzh1nov/vuelaravel/assets/118799235/152b3c9b-004f-40ba-9b4a-0fc972cb2f1b)
![image](https://github.com/balguzh1nov/vuelaravel/assets/118799235/378c54da-7a7d-4d39-ae9d-1efd23796897)
![image](https://github.com/balguzh1nov/vuelaravel/assets/118799235/ff6a6314-31e0-472f-ada2-7b9ac18ebc37)

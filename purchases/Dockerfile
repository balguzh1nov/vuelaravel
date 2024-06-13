FROM php:8.1-fpm-alpine

# Установка необходимых пакетов и PHP расширений
RUN apk add --no-cache \
    postgresql-dev \
    && docker-php-ext-install pdo_pgsql

# Установка Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Установка рабочей директории
WORKDIR /var/www

# Копирование файлов приложения
COPY . .

# Установка зависимостей проекта
RUN composer install

# Копирование файла конфигурации и установка ключа приложения
COPY .env.example .env
RUN php artisan key:generate

# Открытие портов
EXPOSE 9000

# Запуск php-fpm сервера
CMD ["php-fpm"]

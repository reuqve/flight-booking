# Просто лететь

REST API для сервиса бронирования авиабилетов.

Проект реализован на Laravel и предоставляет API для работы с рейсами, пользователями, корзиной и заказами. Предусмотрены роли клиента и администратора.

## Стек

- PHP 8.4
- Laravel 13
- SQLite
- Laravel Sanctum
- Docker / Docker Compose
- Postman

## Структура проекта

```text
flight-booking/
├── deploy/
│   └── docker-compose.yml
├── project/
│   ├── app/
│   ├── database/
│   ├── routes/
│   ├── Dockerfile
│   └── ...
├── collection/
│   └── flight-booking.json
└── README.md
```

## Запуск проекта

### Требования

- Docker
- Docker Compose

### Запуск через Docker

Перейти в директорию `deploy`:

```bash
cd deploy
```

Собрать и запустить контейнер:

```bash
docker compose up -d --build
```

После запуска API доступно по адресу:

```text
http://127.0.0.1:8000
```

Проверить список рейсов:

```text
GET http://127.0.0.1:8000/api/products
```

### Миграции и тестовые данные

Для пересоздания базы данных и заполнения тестовыми данными:

```bash
docker compose exec app php artisan migrate:fresh --seed
```

В проекте используется SQLite. Файл базы данных находится в:

```text
project/database/database.sqlite
```

База данных сохраняется при перезапуске контейнера благодаря Docker volume.

## Тестовые пользователи

### Администратор

```text
Email: admin@flight.ru
Password: QWEasd123
Role: admin
```

### Клиент

```text
Email: user@flight.ru
Password: password
Role: client
```

## Авторизация

Для защищённых запросов используется Bearer Token через Laravel Sanctum.

После успешного входа полученный токен необходимо передать в заголовке:

```text
Authorization: Bearer <token>
```

В Postman используются две переменные:

```text
{{user_token}}
{{admin_token}}
```

`user_token` используется для запросов обычного пользователя, `admin_token` — для административных запросов.

## API

### Аутентификация

| Метод | Endpoint | Доступ | Назначение |
|---|---|---|---|
| POST | `/api/signup` | Guest | Регистрация |
| POST | `/api/login` | Guest | Авторизация |
| GET | `/api/logout` | Client | Выход из аккаунта |

### Профиль

| Метод | Endpoint | Доступ | Назначение |
|---|---|---|---|
| GET | `/api/profile` | Client | Получение профиля |
| PATCH | `/api/profile` | Client | Изменение профиля |

### Рейсы

| Метод | Endpoint | Доступ | Назначение |
|---|---|---|---|
| GET | `/api/products` | Guest | Получение списка рейсов |
| POST | `/api/product` | Admin | Создание рейса |
| PATCH | `/api/product/{id}` | Admin | Изменение рейса |
| DELETE | `/api/product/{id}` | Admin | Удаление рейса |

### Корзина

| Метод | Endpoint | Доступ | Назначение |
|---|---|---|---|
| GET | `/api/cart` | Client | Получение корзины |
| POST | `/api/cart/{product_id}` | Client | Добавление рейса в корзину |
| DELETE | `/api/cart/{id}` | Client | Удаление позиции из корзины |

### Заказы

| Метод | Endpoint | Доступ | Назначение |
|---|---|---|---|
| POST | `/api/order` | Client | Создание заказа |
| GET | `/api/order` | Client | История заказов |

## Формат ошибок

API использует следующие основные HTTP-коды:

### 403 — требуется авторизация

```json
{
    "message": "Login failed"
}
```

### 403 — недостаточно прав

```json
{
    "message": "Forbidden for you"
}
```

### 404 — ресурс не найден

```json
{
    "message": "Not found"
}
```

### 422 — ошибка валидации

```json
{
    "message": "Validation error",
    "field": "Validation error"
}
```

## Postman

Готовая коллекция Postman находится в:

```text
collection/flight-booking.json
```

Коллекция содержит запросы для:

- регистрации и авторизации;
- работы с профилем;
- корзины;
- заказов;
- получения списка рейсов;
- создания, изменения и удаления рейсов администратором;
- проверки ошибок авторизации, прав доступа, валидации и отсутствующих ресурсов.

Перед выполнением защищённых запросов необходимо указать актуальные значения `user_token` и `admin_token` в переменных коллекции.

## Docker

Docker-конфигурация находится в директории:

```text
deploy/
```

Основные файлы:

```text
deploy/docker-compose.yml
project/Dockerfile
project/.dockerignore
```

Приложение запускается в отдельном контейнере. SQLite используется как база данных и хранится в директории проекта, которая подключается к контейнеру через volume.

## Остановка проекта

Для остановки контейнера:

```bash
cd deploy
docker compose down
```

Для повторного запуска:

```bash
docker compose up -d
```
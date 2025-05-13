# Tender Project

Проект на Symfony для управления тендерами: загрузка из CSV, отображение с фильтрацией и пагинацией, создание и просмотр тендеров.

# Стек
- PHP: 8.3
- MySQL
- Symfony 7.2.6

## Возможности

- Импорт тендеров из CSV-файла через консоль
  php bin/console app:import-csv test_task_data.csv
- Просмотр списка тендеров с пагинацией и фильтрацией по названию и дате (GET)
  http://..../?name=123&date=
- Создание нового тендера через веб-интерфейс (POST)
  http://..../tender/new
- Просмотр детальной информации о тендере (GET)
  http://.../tender/3202
- Обработка ошибок при добавлении и фильтрации

## Чтобы развернуть проект - нужно:

1. git clone https://github.com/anna-ansu/tender-project.git
2. cd tender-project
3. composer install
4. php bin/console doctrine:database:create или создать вручную и вставить в .env DATABASE_URL с параметрами
5. php bin/console doctrine:migrations:migrate
// выполнить импорт файла в базу
6. php bin/console app:import-csv test_task_data.csv
// Запустить сервер
7. symfony server:start или php -S 127.0.0.1:8000 -t public

## Структура проекта

```bash
├── assets/                    # Фронтенд-ресурсы
├── bin/                       # Symfony CLI (bin/console)
├── config/                    # Конфигурация приложения
│   ├── packages/              # Конфигурации бандлов
│   └── routes/                # Маршруты
├── migrations/                # Doctrine миграции
├── public/                    # Доступная из браузера директория (index.php)
├── src/                       # Исходный код
│   ├── Command/               # Команды Symfony (app:import-csv)
│   ├── Controller/            # Контроллеры (TenderController)
│   ├── Entity/                # Сущности Doctrine (Tender)
│   ├── Form/                  # Symfony формы (TenderTypeForm)
│   └── Repository/            # Кастомные репозитории (TenderRepository)
├── templates/                 # Twig-шаблоны (index.html.twig, new.html.twig, show.html.twig, base.html.twig)
├── translations/              # Локализации (если используются)
├── .env                       # Переменные окружения
├── composer.json              # Зависимости проекта
└── test_task_data.csv         # CSV-файл для импорта

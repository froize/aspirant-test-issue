#### Действия по разворачиванию приложения
- Скачать приложение;
- Выполнить `composer update` для загрузки зависимостей;
- Запустить Docker;
- Войти в папку с приложением: `cd aspirant-test-issue.loc`;
- Выполнить команду `docker-compose up`;
- В новом окне выполнить команду `docker ps`, чтобы узнать имя контейнера `aspirant_test_issueloc_database_1`;
- Выполнить команду  `docker  exec -i aspirant_test_issueloc_database_1 mysql -uwebmaster -pwebmaster < sql/dump.sql`  для загрузки таблицы MySQL;
- Запустить приложение.


Автотесты
===

Запускаем миграции для тестовой БД:

```shell script
cd vendor/znlib/migration/bin
php console_test db:migrate:up --withConfirm=0
```

Запускаем проектные и пакетные тесты:

```shell script
php vendor/phpunit/phpunit/phpunit
```

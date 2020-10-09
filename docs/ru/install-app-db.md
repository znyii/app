Подготовка БД
===

Выполнить миграции:

```shell script
cd vendor/znlib/migration/bin
php console db:migrate:up
```

Выполнить иморт демо-данных в БД для разработки:

```
cd vendor/znlib/fixture/bin
php console db:fixture:import
```

Подробнее читайте [тут](https://github.com/yii2bundle/yii2-db/blob/master/guide/ru/console-fixture.md).

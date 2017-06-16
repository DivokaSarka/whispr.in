Конфигурация
-------------

### База данных

Измените файл `config/db.php` на реальные данные, например:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=whispr',
    'username' => 'root',
    'password' => '1234',
    'charset' => 'utf8',
];
```

### Выполняем миграции

```php
php yii migrate
```
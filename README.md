<p align="center">
    <h1 align="center">Инструкция по запуску</h1>
    <br>
</p>

УСТАНОВКА
------------

### Установка через Composer и Git

Шаг 1. Перейдите через консоль в папку с доменами OpenServer

~~~
cd domains
~~~

Шаг 2. Вернитесь в командную строку и в папке проекта вызовите команду клонирования

~~~
git clone https://github.com/wwaavvyy/cursednews.git
~~~

Шаг 3. Откройте composer, перейдите в папку проекта

~~~
cd domains/cursednews
~~~

Шаг 4. Напишите в composer

~~~
composer install
~~~

НАСТРОЙКА
-------------

### База данных

Отредактируйте файл `config/db.php` действительными данными, например:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=cursednews',
    'username' => 'root',
    'password' => '',
    'charset' => 'utf8',
];
```

### Дамп базы данных

Я оставил дамп базы данных, на всякий случай.

Шаг 1. Запустите phpMyAdmin

Шаг 2. Выберите вкладку "Импорт"

Шаг 3. Нажмите кнопку "Обзор"

Шаг 4. Выберите базу данных (она лежит в корневой папке проекта)

Шаг 5. Нажмите кнопку "Вперед"

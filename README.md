<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Тестовое задание
### Задача №1 (Backend)
Мы подготовили 5 API методов для работы с абстрактной таблицей расходов.
Скачать описание методов для Insomnia можно по ссылке(crud).

Требуется сделать реализацию данного API на PHP и базой данных MySQL.
Если какие-то моменты, на ваш взгляд, можно улучшить – можете вносить изменения.
Если в коде или в сопроводительном письме будут приведены комментарии с обоснованием ваших решений, это будет плюсом.
### Задача №2 (Frontend)
После того, как API будет работать, требуется сделать микро-приложение на Vue.js (можно с использованием Quasar или другого удобного для вас фреймворка), которое будет работать с этим API, будет состоять из отдельных компонентов и сможет:
- Выводить данные по всем расходам
- Добавлять новую позицию
- Редактировать имеющиеся позиции
- Удалять имеющиеся позиции
- Реализовывать валидацию данных
- Выводить toast-уведомления об успешных операциях или ошибках

Интерфейс на ваше усмотрение, но он должен быть удобен в обращении и хорошо отображаться как с ПК, так и с мобильных устройств.
Допускается (и поощряется) использовать готовые пакеты для того, чтобы решить задачу быстрее.

## Задачи реализованы на laravel 10, VUE 3. 
В Docker контейнеры не упаковывал, проверка в режиме разработки. На системе должны присутствовать:
- php 8.1+, 
- composer 2, 
- NODE 14+, 
- MYSQL 8

.env на соединение с БД поправить под себя 
### Запуск задания:
- composer install
- npm install
- php artisan migrate
- php artisan db:seed
- php artisan serve
- vite

Из консоли переходим по ссылке:

  LARAVEL v10.15.0  plugin v0.7.8

  ➜  APP_URL: http://localhost:8000

Получение конкретной позиции - api и запрос реализован, но в коде выводиться в консоль при редактировании для проверки ответа (получаем отредактированную запись). Практического применения нет.
## Задача №3 (SQL)

Имеется база со следующими таблицами:
```
CREATE TABLE `users` (
    `id`         INT(11) NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(255) DEFAULT NULL,
    `gender`     INT(11) NOT NULL COMMENT '0 - не указан, 1 - мужчина, 2 - женщина.',
    `birth_date` INT(11) NOT NULL COMMENT 'Дата в unixtime.',
    PRIMARY KEY (`id`)
);
CREATE TABLE `phone_numbers` (
    `id`      INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `phone`   VARCHAR(255) DEFAULT NULL,
    PRIMARY KEY (`id`)
);
```

Напишите запрос, возвращающий имя и число указанных телефонных номеров девушек в возрасте от 18 до 22 лет.
Оптимизируйте таблицы и запрос при необходимости.

### Ответ:
```
SELECT t1.name, count(t2.user_id) as tel
	FROM `users` as t1
	LEFT JOIN phone_numbers as t2 ON t1.id = t2.user_id
		WHERE t1.gender = 2 
			AND 
            NOW() BETWEEN DATE_ADD(t1.birth_date, INTERVAL 18 YEAR) AND DATE_ADD(t1.birth_date, INTERVAL 22 YEAR)
	GROUP BY t1.name;
```
Переделанные запросы на создание
TIMESTAMP — хранит дату и время начиная с 1970 года, поэтому не использовал:
```
CREATE TABLE `users` (
    `id`         INT(11) NOT NULL AUTO_INCREMENT,
    `name`       VARCHAR(50) DEFAULT NULL,
    `gender`     INT(2) NOT NULL COMMENT '0 - не указан, 1 - мужчина, 2 - женщина.',
    `birth_date` DATETIME NOT NULL CHECK (`birth_date` > '1900-01-01') COMMENT 'Дата в unixtime.',
    PRIMARY KEY (`id`)
);

CREATE TABLE `phone_numbers` (
    `id`      INT(11) NOT NULL AUTO_INCREMENT,
    `user_id` INT(11) NOT NULL,
    `phone`   VARCHAR(20) DEFAULT NULL,
    PRIMARY KEY (`id`),
    CONSTRAINT `phone` CHECK (`phone` REGEXP '[+]?[0-9]{1,3} ?\\(?[0-9]{3}\\)? ?[0-9]{2}[0-9 -]+[0-9]{2}'),
    FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
);
```
Вторичный ключ для скорости запроса и каскадного удаления, уменьшена необоснованная величина полей, ограничение на возраст для исключения ошибок, для примера регулярка на телефон 10 знаков.


## Задача №4 (Оптимизация)
Проведите рефакторинг, исправьте баги и прокомментируйте код, приведённый ниже.
```
function load_users_data($user_ids) {
    $user_ids = explode(',', $user_ids);
    foreach ($user_ids as $user_id) {
        $db = mysqli_connect("localhost", "root", "123123", "database");
        $sql = mysqli_query($db, "SELECT * FROM users WHERE id=$user_id");
        while($obj = $sql->fetch_object()){
            $data[$user_id] = $obj->name;
        }
        mysqli_close($db);
    }
    return $data;
}
// Как правило, в $_GET['user_ids'] должна приходить строка
// с номерами пользователей через запятую, например: 1,2,17,48
$data = load_users_data($_GET['user_ids']);
foreach ($data as $user_id=>$name) {
    echo "<a href=\"/show_user.php?id=$user_id\">$name</a>";
}
```
Прокомментируйте, какие минусы вы заметили в исходной реализации.
### Ответ:
1 вариант:
- mysqli_query использовать WHERE id IN ($user_ids)
- $data предварительно обьявить массивом.
- Использовать разные одинарные кавычки при выводе ссылок. 

2 вариант 
- использовать один запрос mysqli_fetch_all
- в foreach ($data as $value) ссылки генерить по ключам массива $value['id] и $value['name']
Пример по 2 варианту:
```
function load_users_data($user_ids) {
    $user_ids = explode(',', $user_ids);
    $db = new mysqli(("localhost", "root", "123123", "database", '3306');
    return $db->query("SELECT * FROM users WHERE id IN($user_ids)")
        ->fetch_all(MYSQLI_ASSOC);
}
// Как правило, в $_GET['user_ids'] должна приходить строка
// с номерами пользователей через запятую, например: 1,2,17,48
$data = load_users_data($_GET['user_ids']);
foreach ($data as $item) {
    echo "<a href='/show_user.php?id='.$item['id']."'>$item['name']</a>";
}
```
Не забудьте указать затраченное на задачу время:

Время рывками около 2 часов разворот последнего Larvel, webpack отсутствует, с vite ушло время.
Часа четыре на пристройку bootstrap, FontAwesomeIcon и подбор компонентов для реализации.
И сегодня часа три на все остальное.

Результат необходимо прислать в виде архива или ссылки на публичный репозиторий (github, gitlab) по адресу general@profsalon.org, в теме письма указать «Тестовое задание [Ваши ФИО]».
Спасибо!
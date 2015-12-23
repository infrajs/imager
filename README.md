# imager
Скрипт позволяет изменять размер картинок на лету. Адрес до картинки указывается через скрипт php и в браузер передаётся уже изменённая картинка.

## Установка
Устанавливается скрипт через [composer](http://getcomposer.org), ([русская справка по composer](http://loftblog.ru/2013/05/31/paketnyj-menedzher-php-composer-uskoryajsya/)). В секцию require нужно добавить ```"infrajs/imager":"~1"```
## use
Для работы скрипта в корне проекта рядом с ```vendor/``` нужно создать папку ```cache/``` с подпапкой ```mem/```. Папка ```cache/mem/``` должна быть доступна для записи.
```php
vendor/infrajs/imager/?src=-imager/test.jpg&w=300&h=200&crop=1&top=1
```
"-" сокращение для "vendor/infrajs/". Подробней [infrajs/path](https://github.com/infrajs/path)
## use [infrajs](https://github.com/infrajs/infrajs)
```php
/-imager/?src=-imager/test.jpg&w=300&h=200&crop=1&top=1
```

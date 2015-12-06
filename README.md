# imager
Скрипт позволяет изменять размер картинок на лету. Адрес до картинки указывается через скрипт php и в браузер передаётся уже изменённая картинка.

## Установка
Устанавливается скрипт через [composer](http://getcomposer.org), ([русская справка по composer](http://loftblog.ru/2013/05/31/paketnyj-menedzher-php-composer-uskoryajsya/)). В секцию require нужно добавить ```"infrajs/imager":"~1"```
## use
```php
vendor/infrajs/imager/imager.php?src=path/to/image.jpg&w=100&h=200&crop=1&top=1
```

## use [infrajs](https://github.com/infrajs)
```php
?*imager/imager.php?src=~image.jpg&w=100&h=200&crop=1&top=1
```

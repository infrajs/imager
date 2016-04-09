# imager
Скрипт позволяет изменять размер картинок на лету. Адрес до картинки указывается через скрипт php и в браузер передаётся уже изменённая картинка.

## Установка
Устанавливается скрипт через [composer](http://getcomposer.org), ([русская справка по composer](http://loftblog.ru/2013/05/31/paketnyj-menedzher-php-composer-uskoryajsya/)). В секцию require нужно добавить 
```json
{
  "require":{
    "infrajs/imager":"~1",
  }
}
```

Для работы скрипта в корне проекта рядом с ```vendor/``` нужно создать папку ```cache/``` с подпапкой ```mem/```. Папка ```cache/mem/``` должна быть доступна для записи.

Для автоматической установки, добавьте в composer.json [infrajs/update](https://github.com/infrajs/update)
```json
{
  "require":{
    "infrajs/imager":"~1",
    "infrajs/update":"~1"
  }
}
```
## Использование
```php
/vendor/infrajs/imager/?src=vendor/infrajs/imager/test.jpg&w=300&h=200&crop=1&top=1
```

## Короткий адрес
```php
/-imager/?src=-imager/test.jpg&w=300&h=200&crop=1&top=1
```
Доступен с расширением [infrajs/path](https://github.com/infrajs/path)
Требуется настройка [.htaccess](https://github.com/infrajs/path/blob/master/README.md)

## composer.json
```json
{
  "require":{
    "infrajs/imager":"~1",
    "infrajs/path":"~1",
    "infrajs/update":"~1"
  }
}

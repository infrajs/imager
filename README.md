# imager
Скрипт позволяет изменять размер картинок на лету. Адрес до картинки указывается через скрипт php и в браузер передаётся уже изменённая картинка.

## Установка
Устанавливается скрипт через [composer](http://getcomposer.org), 
([русская справка по composer](http://loftblog.ru/2013/05/31/paketnyj-menedzher-php-composer-uskoryajsya/)). 
В секцию **require** нужно добавить две записи [infrajs/imager](https://github.com/infrajs/imager) и [infrajs/router](https://github.com/infrajs/router)

###composer.json

```json
{
  "require":{
    "infrajs/imager":"~1",
    "infrajs/router":"~1"
  }
}
```

### Необходимо настроить **.htaccess**

```
RewriteEngine on
RewriteCond %{REQUEST_FILENAME} !-f
RewriteRule ^(.*)$ vendor/infrajs/router/index.php [L,QSA]
```

## Использование

```php
/-imager/?src=-imager/test.jpg&w=300&h=200&crop=1&top=1&num=0
```

Доступные параметры приведены в ссылке ```src```, ```w```, ```h```,```crop```,```top```, ```num```. 
Указання ссылка после установки будет работать в вашем проекте. Обязательный параметр только **src**.

 - **num** - номер картинки в указанной папке

Подробней о дополнительных символах в адресе [-~!] описано в [infrajs/path](https://github.com/infrajs/path).

## Установка без [infrajs/router](https://github.com/infrajs/router)

###composer.json

```json
{
  "require":{
    "infrajs/imager":"~1",
  }
}
```

Для работы скрипта в корне проекта рядом с ```vendor/``` потребуется вручную создать папку ```cache/``` с подпапкой ```mem/```. Папка ```cache/mem/``` должна быть доступна для записи.
Настривать **.htaccess** не нужно, скрипт будет работать по более длинному адресу.
```php
/vendor/infrajs/imager/?src=vendor/infrajs/imager/test.jpg&w=300&h=200&crop=1&top=1
```
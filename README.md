## Примеры использования пакета [kaspi/di-container](https://github.com/agdobrynin/di-container)

### 📃 PHP 8.1 и Composer установлены

Установить зависимости через composer:
```shell
composer install
```

Для запуска примеров:
```shell
php -d zend.assertions=1 src/index.php
```

> Для проверки утверждений в тестах используется функция [assert](https://www.php.net/assert)
> поэтому вызов интерпретатора с опцией `-d zend.assertions=1`

### 🐳 Docker / Docker desktop

Для развертывания потребуется установленный 🐳 docker
или же 🐋 docker desktop.
Проект будет работать как на Windows с поддержкой WSL2 так и на Linux машине.

Собрать docker-container c PHP 8.1:
```shell
docker-compose build
```
Установить зависимости через php composer:
```shell
docker-compose run --rm php composer i -no
```

Запуск примеров
```shell
docker-compose run --rm php php src/index.php
```

Можно работать в shell оболочке в docker контейнере:
```shell
docker-compose run --rm php sh
```
в появившейся командной строке можно выполнять команды.

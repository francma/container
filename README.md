# Container (Dependency Injection)

[![Build Status](https://travis-ci.org/francma/container.svg?branch=master)](https://travis-ci.org/francma/container)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

This package is compliant with [PSR-1], [PSR-2], [PSR-4] and [PSR-11]. If you notice compliance oversights, please send a patch via pull request.

[PSR-1]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md
[PSR-2]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md
[PSR-4]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md
[PSR-11]: https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-11-container.md

## Install

Via Composer

```
$ composer require francma/container
```

## Usage

```php
$di = new Container([
    'mysql' => [
        'host' => 'localhost',
        'dbname' => 'database',
        'port' => 3306,
        'charset' => 'utf8mb4',
        'password' => 'password',
        'user' => 'root',
    ],
    PDO::class => function (Container $di): PDO {
        $cfg = $di->get('mysql');
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];
        $dsn = "mysql:host={$cfg['host']};dbname={$cfg['dbname']};port={$cfg['port']};charset={$cfg['charset']}";

        return new PDO($dsn, $cfg['user'], $cfg['password'], $options);
    },
]);

$db1 = $di->get(PDO::class);
echo $db1->query("SELECT 1")->fetch(PDO::FETCH_COLUMN), PHP_EOL;

$db2 = $di->get(PDO::class);
assert(spl_object_hash($db1) === spl_object_hash($db2));
```

## Requirements

The following versions of PHP are supported by this version.

* PHP 7.1
* PHP 7.2
* PHP 7.3
* PHP 7.4

## Testing

```
$ composer test
$ composer phpcs
```

## License

The MIT License (MIT). Please see [License File](https://github.com/francma/container/blob/master/LICENSE.md) for more information.

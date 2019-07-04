<?php declare(strict_types=1);

use Francma\Container;

require __DIR__ . '/../vendor/autoload.php';

echo basename(__FILE__), '...';

class Service1
{

    public function __construct(string $param1)
    {
    }
}


class Service2
{

    public function __construct(Service1 $service1, int $param2)
    {
    }
}

class Service3
{

    public function __construct(Service1 $service1)
    {
    }
}

class Service4
{

    public function __construct(Service2 $service2, Service3 $service3)
    {
    }
}

$di = new Container([
    'param1' => 'string',
    'param2' => 1,
    Service1::class => function (Container $di): Service1 {
        return new Service1($di->get('param1'));
    },
    Service2::class => function (Container $di): Service2 {
        return new Service2($di->get(Service1::class), $di->get('param2'));
    },
    Service3::class => function (Container $di): Service3 {
        return new Service3($di->get(Service1::class));
    },
    Service4::class => function (Container $di): Service4 {
        return new Service4($di->get(Service2::class), $di->get(Service3::class));
    },
]);

$param2 = $di->get('param2');

$service4 = $di->get(Service4::class);
assert($service4 instanceof Service4);


echo ' OK!', PHP_EOL;
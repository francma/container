<?php declare(strict_types=1);

use Francma\Container;

require __DIR__ . '/../vendor/autoload.php';

echo basename(__FILE__), '...';

class CallableClass {

    public function __call($name, $arguments)
    {
        return 'Not CallableClass';
    }
};

class StaticClass {

    public static function call(Container $di)
    {
        return self::class;
    }
}

class InstancedClass {

    public function call(Container $di)
    {
        return self::class;
    }
}

$fn = function (Container $di) {
    return 'function';
};

$di = new Container([
    // https://www.php.net/manual/en/language.types.callable.php
    CallableClass::class => new CallableClass,
    'is_object' => 'is_object',
    'static' => [StaticClass::class, 'call'],
    'static_full' => 'StaticClass::call',
    'instanced' => [new InstancedClass, 'call'],
    'function' => $fn,
]);

assert($di->get('function') === 'function');

$instanced = $di->get('instanced');
assert($instanced[0] instanceof InstancedClass && is_string($instanced[1]));
assert($di->get(CallableClass::class) instanceof CallableClass);
assert($di->get('static') === [StaticClass::class, 'call']);
assert($di->get('static_full') === 'StaticClass::call');
assert($di->get('is_object') === 'is_object');

echo ' OK!', PHP_EOL;

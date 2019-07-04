<?php declare(strict_types=1);

namespace Francma;

use Closure;
use InvalidArgumentException;
use OutOfBoundsException;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

use function array_key_exists;
use function is_string;

class Container implements ContainerInterface
{

    private $entries;

    public function __construct(array $entries)
    {
        $this->entries = $entries;
    }

    public function get($id)
    {
        if (!$this->has($id)) {
            throw new class extends OutOfBoundsException implements NotFoundExceptionInterface
            {
                /* silence is golden */
            };
        }


        $entry =& $this->entries[$id];
        if ($entry instanceof Closure) { // instanceof https://www.php.net/manual/en/functions.anonymous.php
            $entry = $entry($this);
        }

        return $entry;
    }

    public function has($id)
    {
        if (!is_string($id)) {
            throw new class extends InvalidArgumentException implements ContainerExceptionInterface
            {
                /* silence is golden */
            };
        }

        return array_key_exists($id, $this->entries);
    }
}

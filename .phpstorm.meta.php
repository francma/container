<?php declare(strict_types=1);

namespace PHPSTORM_META {

    use Psr\Container\ContainerInterface;

    // PSR-11 Container Interface
    override(ContainerInterface::get(0), map([
        '' => '@',
    ]));
}
<?php
require __DIR__ . '/../vendor/autoload.php';

/**
 * Initialises Moss Framework
 */
$moss = new \Moss\Kernel\App(require __DIR__ . '/../src/bootstrap.php');

// TODO - this should be disabled on moss 1.2
$moss->router()
    ->register(
        'adminDynamic',
        new \Vox\Router\DynamicRoute(
            '/admin/{controller}/({action})',
            '\\Vox\\Admin\\Controller\\{controller}Controller@{action}Action'
        )
    );

/**
 * Unleashes the power of Moss
 */
$moss->run()
    ->send();

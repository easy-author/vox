<?php
require __DIR__ . '/../vendor/autoload.php';

/**
 * Initialises Moss Framework
 */
$moss = new \Moss\Kernel\App(require __DIR__ . '/../src/Vox/bootstrap.php');
$moss->router()
    ->register('dynamic', new \Vox\Router\DynamicRoute('/{controller}/({action})', null));

/**
 * Unleashes the power of Moss
 */
$moss->run()
    ->send();

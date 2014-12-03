<?php
require __DIR__ . '/../vendor/autoload.php';

/**
 * Initialises Moss Framework
 */
$moss = new \Moss\Kernel\App(require __DIR__ . '/../src/bootstrap.php');

/**
 * Unleashes the power of Moss
 */
$moss->run()
    ->send();

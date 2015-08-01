<?php
require __DIR__ . '/../vendor/autoload.php';

/**
 * Initialises Moss Framework
 */
$config = new \Moss\Config\Config(require __DIR__ . '/../src/bootstrap.php');
$moss = new \Moss\Kernel\App($config);

/**
 * Unleashes the power of Moss
 */
$moss->run()
    ->send();

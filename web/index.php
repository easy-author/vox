<?php
require __DIR__ . '/../vendor/autoload.php';

$moss = new \Moss\Kernel\App();
$moss->run()
    ->send();

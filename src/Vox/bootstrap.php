<?php

use Moss\Container\ContainerInterface;

return [
    'router' => [
        'index' => [
            'pattern' => '/',
            'controller' => 'Vox\Controllers\IndexController@indexAction',
        ],
        'controllerAction' => [
            'pattern' => '/{controller:[^\/]}/({action:[^\/]})',
//            'pattern' => '/{controller:.}',
            'controller' => function($app) {
                $controllerName = '\Vox\Controllers\\'.ucfirst($app->request->query()->get('controller')).'Controller';
                $actionName = $app->request->query()->get('action', 'index').'Action';

                $controller = new $controllerName($app);

                return $controller->$actionName();
            },
        ],
    ],
    'container' => [
        'pdo' => [
            'component' => function () {
                return new \Moss\Storage\Driver\PDO(
                    'mysql:dbname=moss_db;host=localhost;port=3306',
                    'moss_db_user',
                    'moss123',
                    new \Moss\Storage\Driver\Mutator(),
                    'prefix'
                );
            },
            'shared' => true
        ],
        'schema' => array(
            'component' => function (ContainerInterface $container) {
                $storage = new \Moss\Storage\StorageSchema($container->get('pdo'), new \Moss\Storage\Builder\MySQL\SchemaBuilder());

                $var = $container->get('config')
                    ->get('container');

                foreach (array_keys($var) as $model) {
                    if (strpos($model, 'storage:') !== 0) {
                        continue;
                    }

                    $storage->register($container->get($model), substr($model, 8));
                }

                return $storage;
            },
            'shared' => true
        ),
    ],

];
<?php
use Moss\Container\ContainerInterface;

return array(
    'container' => array(
        'storage' => array(
            'component' => function (ContainerInterface $container) {
                    $storage = new \Moss\Storage\StorageQuery(
                        $container->get('pdo'),
                        new \Moss\Storage\Builder\MySQL\QueryBuilder()
                    );

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
    ),
    'router' => array(
        'database:create' => array(
            'pattern' => 'database:create',
            'controller' => 'Console\Controller\StorageController@createAction',
            'methods' => array('cli'),
        ),
        'database:update' => array(
            'pattern' => 'database:update',
            'controller' => 'Console\Controller\StorageController@updateAction',
            'methods' => array('cli'),
        ),
        'database:drop' => array(
            'pattern' => 'database:drop',
            'controller' => 'Console\Controller\StorageController@dropAction',
            'methods' => array('cli'),
        )
    ),
);

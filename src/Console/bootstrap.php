<?php
use Moss\Container\ContainerInterface;

return array(
    'container' => array(
        'schema' => array(
            'component' => function (ContainerInterface $container) {
                return new \Moss\Storage\Schema\Schema(
                    $container->get('storage:connection'),
                    $container->get('storage:modelbag')
                );
            },
            'shared' => true
        )
    ),
    'router' => array(
        'database:configure' => array(
            'pattern' => 'database:configure',
            'controller' => 'Console\Controller\StorageController@configureAction',
            'methods' => array('cli'),
        ),
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
        ),

        'fixtures:user' => array(
            'pattern' => 'fixtures:user',
            'controller' => 'Console\Controller\FixtureController@userAction',
            'methods' => array('cli'),
        ),
    ),
);

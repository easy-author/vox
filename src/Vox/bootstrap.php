<?php


return [
    'router' => [
        'index' => [
            'pattern' => '/',
            'controller' => 'Vox\Controllers\IndexController@indexAction',
        ],
        'controllerAction' => [
//            'pattern' => '/{controller:.}(/{action:.})',
            'pattern' => '/{controller:.}',
            'controller' => function($app) {
                $controllerName = '\Vox\Controllers\\'.ucfirst($app->request->query()->get('controller')).'Controller';
                $actionName = $app->request->query()->get('action', 'index').'Action';

                $controller = new $controllerName($app);

                return $controller->$actionName();
            },
        ],
    ],
];
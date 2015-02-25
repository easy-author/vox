<?php
use Moss\Container\ContainerInterface;

return [
    'container' => [
        'path' => [
            'app' => __DIR__ . '/../../src',
            'base' => __DIR__ . '/../..',
            'cache' => __DIR__ . '/../../var/cache',
            'compile' => __DIR__ . '/../../var/compile',
            'public' => __DIR__ . '/../../web',
            'upload' => __DIR__ . '/../../web/upload'
        ],
        'view' => [
            'component' => function (ContainerInterface $container) {
                $options = [
                    'debug' => true,
                    'auto_reload' => true,
                    'strict_variables' => false,
                    'cache' => $container->get('path.compile')
                ];

                $twig = new Twig_Environment(new Moss\Bridge\Loader\File(__DIR__ . '/../{bundle}/{directory}/View/{file}.twig'), $options);
                $twig->setExtensions(
                    [
                        new Moss\Bridge\Extension\Resource(),
                        new Moss\Bridge\Extension\Url($container->get('router')),
                        new Moss\Bridge\Extension\Trans(),
                        new Twig_Extensions_Extension_Text(),
                    ]
                );

                $view = new \Moss\Bridge\View\View($twig);
                $view
                    ->set('request', $container->get('request'))
                    ->set('config', $container->get('config'))
                    ->set('flashbag', $container->get('flashbag'));

                return $view;
            }
        ],
        'security' => [
            'component' => function (ContainerInterface $container) {
                $stash = new \Moss\Security\TokenStash($container->get('session'));

                $provider = new \Vox\Admin\Model\UserModel($container->get('repository:user'));

                $url = $container
                    ->get('router')
                    ->make('admin.login.form');

                $security = new \Moss\Security\Security($stash, $url);

                $security->registerArea(new \Moss\Security\Area('admin/(!login|logout)'));
                $security->registerUserProvider($provider);

                return $security;
            },
            'shared' => true
        ],
        'flashbag' => [
            'component' => function (ContainerInterface $container) {
                return new \Moss\Http\Session\FlashBag($container->get('session'));
            },
            'shared' => true
        ],
        'repository:user' => [
            'component' => function (ContainerInterface $container) {
                return new \Vox\Admin\Repository\UserRepository($container->get('storage'));
            }
        ],
    ],
    'dispatcher' => [
        'kernel.route' => [
            function (ContainerInterface $container) {
                $security = $container->get('security');
                $request = $container->get('request');

                try {
                    $security
                        ->authenticate($request)
                        ->authorize($request);

                    return null;
                } catch (\Moss\Security\SecurityException $e) {
                    $response = new \Moss\Http\Response\ResponseRedirect($security->loginUrl());
                    $response->content($e->getMessage());

                    return $response;
                }
            }
        ],
    ],
    'router' => [
        'index' => [
            'pattern' => '/',
            'controller' => 'Vox\Front\Controller\BaseController@indexAction',
        ],


        'admin' => [
            'pattern' => '/admin/',
            'controller' => 'Vox\Admin\Controller\BaseController@indexAction',
        ],
// TODO - this should be enabled on Moss 1.2
//        'adminDynamic' => new \Vox\Router\DynamicRoute(
//            '/admin/{controller}/({action})',
//            '\\Vox\\Admin\\Controller\\{controller}Controller@{action}Action'
//        ),
        'admin.login.form' => [
            'pattern' => '/admin/login/',
            'controller' => 'Vox\Admin\Controller\BaseController@loginAction',
            'methods' => ['get'],
        ],
        'admin.login.auth' => [
            'pattern' => '/admin/login/',
            'controller' => 'Vox\Admin\Controller\BaseController@authAction',
            'methods' => ['post']
        ],
        'admin.logout' => [
            'pattern' => '/admin/logout/',
            'controller' => 'Vox\Admin\Controller\BaseController@logoutAction',
        ],
    ],
];

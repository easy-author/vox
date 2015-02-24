<?php
namespace Vox\Router;

/*
* This file is part of the vox package
*
* (c) Michal Wachowski <wachowski.michal@gmail.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

use Moss\Http\Router\Route;
use Moss\Http\Router\RouteException;

/**
 * Class DynamicRoute
 * Overloads Route and returns controller action from url as controller@action notation
 *
 * Usage:
 *     $router->register(
 *          'dynamic',
 *          new \Vox\Router\DynamicRoute(
 *              '/admin/{controller}/({action})',
 *              '\\Vox\\Admin\\Controller\\{controller}Controller@{action}Action',
 *              [],
 *              []
 *          )
 *      );
 * When calling /Foo_Bar/yada
 *     \Foo\BarController@yadaAction will be called
 * If no action - indexAction will be called
 *
 * @package Vox\Router
 */
class DynamicRoute extends Route
{
    /**
     * Constructor for dynamic routing
     *
     * @param string $uriPattern
     * @param string $controllerPattern
     * @param array $arguments
     * @param array $methods
     */
    public function __construct($uriPattern, $controllerPattern, array $arguments = [], array $methods = [])
    {
        parent::__construct($uriPattern, $controllerPattern, $arguments, $methods);
    }


    /**
     * Returns controller
     *
     * @return string|callable
     */
    public function controller()
    {
        return strtr(
            $this->controller, [
                '{controller}' => $this->arguments['controller'],
                '{action}' => $this->arguments['action'] ?: 'index'
            ]
        );
    }

    /**
     * Creates route url
     *
     * @param string $host
     * @param array $arguments
     *
     * @return string
     * @throws RouteException
     */
    public function make($host, array $arguments = [])
    {
        if(!empty($arguments) && $arguments == array_values($arguments)) {
            $arguments['controller'] = $arguments[0];
            unset($arguments[0]);

            if(isset($arguments[1])) {
                $arguments['action'] = $arguments[1];
                unset($arguments[1]);
            }
        }

        if(empty($arguments['controller'])) {
            throw new RouteException('Missing required controller argument');
        }

        return parent::make($host, $arguments);
    }
}
